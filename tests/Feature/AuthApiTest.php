<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    protected string $apiKey = 'k9l3xJuL6D9dBmvPIDMe6Th3Wj8WpzeJKvDbcBU4vgsdfgvdgdfN6DOVXmZzgKHEZ2hPYdGsyhhJdmCWzvFkGpl';

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_send_otp_success_and_sets_cooldown(): void
    {
        $response = $this->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->postJson('/api/v1/send-otp', [
            'mobile_number' => '9876543210',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'OTP sent successfully',
                'mobile_number' => '9876543210',
            ]);

        $this->assertTrue(Cache::has('otp_9876543210'));
        $this->assertTrue(Cache::has('otp_cooldown_9876543210'));
    }

    public function test_resend_otp_success_and_replaces_previous_otp(): void
    {
        $mobileNumber = '9876543210';
        Cache::put('otp_' . $mobileNumber, '1111', now()->addMinutes(5));
        // No cooldown active (e.g. 60 seconds have passed)

        $response = $this->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->postJson('/api/v1/resend-otp', [
            'mobile_number' => $mobileNumber,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'OTP resent successfully',
                'mobile_number' => $mobileNumber,
            ]);

        $newOtp = Cache::get('otp_' . $mobileNumber);
        $this->assertNotEmpty($newOtp);
        $this->assertNotEquals('1111', $newOtp);
        $this->assertTrue(Cache::has('otp_cooldown_' . $mobileNumber));
    }

    public function test_resend_otp_rate_limited_during_cooldown(): void
    {
        $mobileNumber = '9876543210';
        Cache::put('otp_' . $mobileNumber, '1111', now()->addMinutes(5));
        Cache::put('otp_cooldown_' . $mobileNumber, now()->addSeconds(50)->timestamp, now()->addSeconds(50));

        $response = $this->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->postJson('/api/v1/resend-otp', [
            'mobile_number' => $mobileNumber,
        ]);

        $response->assertStatus(429)
            ->assertJson([
                'status' => 'error',
            ]);

        $this->assertStringContainsString('Please wait', $response->json('message'));
        $this->assertStringContainsString('seconds before requesting another OTP.', $response->json('message'));
    }

    public function test_resend_otp_supports_mobile_parameter_name(): void
    {
        $response = $this->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->postJson('/api/v1/resend-otp', [
            'mobile' => '9876543210',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'OTP resent successfully',
                'mobile_number' => '9876543210',
            ]);
    }

    public function test_resend_otp_validation_fails_for_invalid_mobile(): void
    {
        $response = $this->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->postJson('/api/v1/resend-otp', [
            'mobile_number' => '123',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
            ])
            ->assertJsonValidationErrors(['mobile_number']);
    }

    public function test_verify_otp_succeeds_with_resent_otp(): void
    {
        $mobileNumber = '9876543210';

        // Resend OTP
        $resendResponse = $this->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->postJson('/api/v1/resend-otp', [
            'mobile_number' => $mobileNumber,
        ]);

        $resendResponse->assertStatus(200);

        $cachedOtp = Cache::get('otp_' . $mobileNumber);
        $this->assertNotEmpty($cachedOtp);

        // Verify OTP
        $verifyResponse = $this->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->postJson('/api/v1/verify-otp', [
            'mobile_number' => $mobileNumber,
            'otp' => $cachedOtp,
        ]);

        $verifyResponse->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'token_type' => 'Bearer',
            ]);

        $this->assertDatabaseHas('users', [
            'mobile_number' => $mobileNumber,
        ]);
    }

    public function test_resend_otp_unauthorized_without_api_key(): void
    {
        $response = $this->postJson('/api/v1/resend-otp', [
            'mobile_number' => '9876543210',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized. Invalid or missing API key.',
            ]);
    }

    public function test_logout_all_devices_revokes_all_tokens(): void
    {
        $user = User::create([
            'username' => 'multideviceuser',
            'mobile_number' => '9876543299',
        ]);

        // Create multiple device tokens
        $token1 = $user->createToken('device_1')->plainTextToken;
        $token2 = $user->createToken('device_2')->plainTextToken;
        $token3 = $user->createToken('device_3')->plainTextToken;

        $this->assertEquals(3, $user->tokens()->count());

        // Logout from all devices using token 1
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token1,
        ])->postJson('/api/v1/logout-all');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Logged out from all devices successfully',
            ]);

        // All tokens should be deleted
        $this->assertEquals(0, $user->tokens()->count());
    }

    public function test_unauthenticated_user_cannot_access_logout_all(): void
    {
        $response = $this->postJson('/api/v1/logout-all');
        $response->assertStatus(401);
    }
}

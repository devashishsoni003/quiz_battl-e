<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test u_id increments serial-wise correctly on user registration.
     */
    public function test_u_id_generates_serial_wise(): void
    {
        // 1. Create a user
        $user1 = User::create([
            'mobile_number' => '9999999901',
            'username' => 'testuser1',
        ]);

        // 2. Create another user
        $user2 = User::create([
            'mobile_number' => '9999999902',
            'username' => 'testuser2',
        ]);

        // Verify serial-wise generation
        $this->assertNotEmpty($user1->u_id);
        $this->assertNotEmpty($user2->u_id);

        $num1 = (int) substr($user1->u_id, 2);
        $num2 = (int) substr($user2->u_id, 2);

        $this->assertEquals($num1 + 1, $num2);
    }

    /**
     * Test u_id is returned in the API responses.
     */
    public function test_u_id_is_present_in_profile_api(): void
    {
        $user = User::create([
            'mobile_number' => '9999999903',
            'username' => 'testuser3',
        ]);

        // Fetch profile API
        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/profile');

        $response->assertStatus(200)
            ->assertJsonPath('user.u_id', $user->u_id);
    }

    /**
     * Test user can change password successfully.
     */
    public function test_user_can_change_password_successfully(): void
    {
        $user = User::create([
            'mobile_number' => '9999999904',
            'username' => 'passuser1',
            'password' => \Illuminate\Support\Facades\Hash::make('oldpassword123'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/change-password', [
            'current_password' => 'oldpassword123',
            'new_password' => 'newpassword123',
            'confirm_password' => 'newpassword123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Password changed successfully',
            ]);

        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword123', $user->fresh()->password));
    }

    /**
     * Test change password fails when current password is incorrect.
     */
    public function test_change_password_fails_if_current_password_incorrect(): void
    {
        $user = User::create([
            'mobile_number' => '9999999905',
            'username' => 'passuser2',
            'password' => \Illuminate\Support\Facades\Hash::make('oldpassword123'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/change-password', [
            'current_password' => 'wrongpassword',
            'new_password' => 'newpassword123',
            'confirm_password' => 'newpassword123',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Current password does not match.',
            ]);
    }

    /**
     * Test change password fails when confirm password does not match.
     */
    public function test_change_password_fails_if_confirm_password_does_not_match(): void
    {
        $user = User::create([
            'mobile_number' => '9999999906',
            'username' => 'passuser3',
            'password' => \Illuminate\Support\Facades\Hash::make('oldpassword123'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/change-password', [
            'current_password' => 'oldpassword123',
            'new_password' => 'newpassword123',
            'confirm_password' => 'differentpassword',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['confirm_password']);
    }

    /**
     * Test change password fails when new password matches current password.
     */
    public function test_change_password_fails_if_new_password_is_same(): void
    {
        $user = User::create([
            'mobile_number' => '9999999907',
            'username' => 'passuser4',
            'password' => \Illuminate\Support\Facades\Hash::make('oldpassword123'),
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/change-password', [
            'current_password' => 'oldpassword123',
            'new_password' => 'oldpassword123',
            'confirm_password' => 'oldpassword123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['new_password']);
    }

    /**
     * Test unauthenticated user cannot change password.
     */
    public function test_unauthenticated_user_cannot_access_change_password(): void
    {
        $response = $this->postJson('/api/v1/change-password', [
            'current_password' => 'oldpassword123',
            'new_password' => 'newpassword123',
            'confirm_password' => 'newpassword123',
        ]);

        $response->assertStatus(401);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Seller;
use App\Models\SuperAdmin;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test seller creation and database attributes.
     */
    public function test_can_create_seller(): void
    {
        $seller = Seller::create([
            'name' => 'John Doe',
            'mobile_number' => '9876543210',
            'email' => 'john@example.com',
            'whatsapp_number' => '9876543210',
            'coins' => 100,
            'status' => true,
        ]);

        $this->assertDatabaseHas('sellers', [
            'id' => $seller->id,
            'name' => 'John Doe',
            'mobile_number' => '9876543210',
            'email' => 'john@example.com',
            'coins' => 100,
        ]);
    }

    /**
     * Test admin can create a seller with coins and password.
     */
    public function test_admin_can_create_seller_with_coins_and_password(): void
    {
        $admin = SuperAdmin::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin_test2@example.com',
            'password' => 'password123',
        ]);

        $response = $this->actingAs($admin, 'super_admin')
            ->post(route('admin.sellers.store'), [
                'name' => 'Test Seller Admin',
                'mobile_number' => '9991112223',
                'email' => 'test_seller_admin@example.com',
                'whatsapp_number' => '9991112223',
                'coins' => 150,
                'password' => 'sellerpass123',
                'password_confirmation' => 'sellerpass123',
                'status' => 1,
            ]);

        $response->assertRedirect(route('admin.sellers.index'));

        $this->assertDatabaseHas('sellers', [
            'name' => 'Test Seller Admin',
            'mobile_number' => '9991112223',
            'email' => 'test_seller_admin@example.com',
            'coins' => 150,
        ]);
    }

    /**
     * Test Seller Send OTP.
     */
    public function test_seller_send_otp_success(): void
    {
        $seller = Seller::create([
            'name' => 'Jane Seller',
            'mobile_number' => '9876543211',
            'status' => true,
        ]);

        $response = $this->postJson(route('seller.send-otp'), [
            'mobile_number' => '9876543211',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'OTP sent successfully.'
            ]);

        $this->assertTrue(Cache::has('otp_9876543211'));
    }

    /**
     * Test Seller Verify OTP & Login.
     */
    public function test_seller_verify_otp_and_login_success(): void
    {
        $seller = Seller::create([
            'name' => 'Jane Seller',
            'mobile_number' => '9876543212',
            'status' => true,
        ]);

        Cache::put('otp_9876543212', '5678', now()->addMinutes(5));

        $response = $this->postJson(route('seller.verify-otp'), [
            'mobile_number' => '9876543212',
            'otp' => '5678',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Login successful.',
            ]);

        $this->assertAuthenticatedAs($seller, 'seller');
    }

    /**
     * Test Search User.
     */
    public function test_seller_search_user(): void
    {
        $seller = Seller::create([
            'name' => 'Jane Seller',
            'mobile_number' => '9876543215',
            'status' => true,
        ]);

        $user = \App\Models\User::create([
            'username' => 'testuser1',
            'mobile_number' => '9876543200',
            'coins' => 500,
            'u_id' => 'QB20001',
        ]);

        $response = $this->actingAs($seller, 'seller')
            ->getJson(route('seller.users.search', ['search_query' => 'QB20001']));

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'user' => [
                    'u_id' => 'QB20001',
                    'name' => 'testuser1',
                ]
            ]);
    }

    /**
     * Test Coin Transfer Success.
     */
    public function test_seller_transfer_coins_success(): void
    {
        $seller = Seller::create([
            'name' => 'Jane Seller',
            'mobile_number' => '9876543216',
            'coins' => 10000,
            'status' => true,
        ]);

        $user = \App\Models\User::create([
            'username' => 'testuser2',
            'mobile_number' => '9876543201',
            'coins' => 500,
            'u_id' => 'QB20002',
        ]);

        $response = $this->actingAs($seller, 'seller')
            ->postJson(route('seller.transfer.submit'), [
                'user_id' => $user->id,
                'amount' => 2000,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Coins transferred successfully.',
            ]);

        $seller->refresh();
        $user->refresh();

        $this->assertEquals(8000, $seller->coins);
        $this->assertEquals(2500, $user->coins);

        $this->assertDatabaseHas('seller_transactions', [
            'seller_id' => $seller->id,
            'user_id' => $user->id,
            'amount' => 2000,
            'type' => 'transfer',
        ]);
    }

    /**
     * Test Coin Transfer Insufficient Balance.
     */
    public function test_seller_transfer_coins_insufficient_balance(): void
    {
        $seller = Seller::create([
            'name' => 'Jane Seller',
            'mobile_number' => '9876543217',
            'coins' => 500,
            'status' => true,
        ]);

        $user = \App\Models\User::create([
            'username' => 'testuser3',
            'mobile_number' => '9876543202',
            'coins' => 500,
            'u_id' => 'QB20003',
        ]);

        $response = $this->actingAs($seller, 'seller')
            ->postJson(route('seller.transfer.submit'), [
                'user_id' => $user->id,
                'amount' => 2000,
            ]);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'error',
                'message' => 'Insufficient coin balance.',
            ]);

        $seller->refresh();
        $user->refresh();

        $this->assertEquals(500, $seller->coins);
        $this->assertEquals(500, $user->coins);
    }

    /**
     * Test Seller Dashboard access controls.
     */
    public function test_unauthenticated_seller_cannot_access_dashboard(): void
    {
        $response = $this->get(route('seller.dashboard'));
        $response->assertRedirect(route('seller.login'));
    }

    /**
     * Test Seller profile update.
     */
    public function test_seller_can_update_profile_and_upload_image(): void
    {
        Storage::fake('public');

        $seller = Seller::create([
            'name' => 'Jane Seller',
            'mobile_number' => '9876543213',
            'status' => true,
        ]);

        $image = UploadedFile::fake()->image('store.jpg');

        $response = $this->actingAs($seller, 'seller')
            ->post(route('seller.profile.update'), [
                'name' => 'Jane Updated',
                'whatsapp_number' => '9876543213',
                'password' => 'newpassword123',
                'image' => $image,
            ]);

        $response->assertRedirect();
        
        $seller->refresh();
        $this->assertEquals('Jane Updated', $seller->name);
        $this->assertEquals('9876543213', $seller->whatsapp_number);
        $this->assertNotNull($seller->image);

        Storage::disk('public')->assertExists('sellers/' . $seller->image);
    }

    /**
     * Test Seller and Admin Guard Isolation.
     */
    public function test_seller_cannot_access_admin_dashboard(): void
    {
        $seller = Seller::create([
            'name' => 'Jane Seller',
            'mobile_number' => '9876543214',
            'status' => true,
        ]);

        $response = $this->actingAs($seller, 'seller')->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test Admin cannot access Seller Dashboard automatically.
     */
    public function test_admin_cannot_access_seller_dashboard(): void
    {
        $admin = SuperAdmin::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin_test@example.com',
            'password' => 'password123',
        ]);

        $response = $this->actingAs($admin, 'super_admin')->get(route('seller.dashboard'));
        $response->assertRedirect(route('seller.login'));
    }
}

<?php

namespace Tests\Feature;

use App\Models\Referral;
use App\Models\ReferralSetting;
use App\Models\Seller;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReferralPercentageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        ReferralSetting::create([
            'title' => 'Refer and Earn',
            'description' => 'Invite friends and earn reward percentage.',
            'reward_per_referral' => 10, // 10%
            'new_user_bonus' => 50, // 50 Coins
            'status' => 1,
        ]);
    }

    /**
     * Case 4: Referral Applied -> New user gets bonus (50), Referrer gets 0 until purchase.
     */
    public function test_case_4_referral_applied_gives_bonus_only_to_new_user(): void
    {
        $referrer = User::create([
            'username' => 'referrer_user',
            'mobile_number' => '9876543201',
            'referral_code' => 'REF123',
            'coins' => 100,
            'total_referrals' => 0,
            'total_referral_coins' => 0,
        ]);

        $newUser = User::create([
            'username' => 'new_user',
            'mobile_number' => '9876543202',
            'referral_code' => 'NEW123',
            'coins' => 0,
            'total_referrals' => 0,
            'total_referral_coins' => 0,
        ]);

        $response = $this->actingAs($newUser, 'sanctum')->postJson('/api/v1/referral/apply', [
            'referral_code' => 'REF123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Referral code applied successfully.',
            ]);

        $newUser->refresh();
        $referrer->refresh();

        // New user gets 50 coins immediately
        $this->assertEquals(50, $newUser->coins);
        $this->assertEquals($referrer->id, $newUser->referred_by);

        // Referrer gets 0 coins on apply, but total_referrals increments
        $this->assertEquals(100, $referrer->coins);
        $this->assertEquals(0, $referrer->total_referral_coins);
        $this->assertEquals(1, $referrer->total_referrals);

        // Referral record is created with Pending status and 0 reward_amount
        $referral = Referral::where('referred_user_id', $newUser->id)->first();
        $this->assertNotNull($referral);
        $this->assertEquals('Pending', $referral->status);
        $this->assertEquals(0, $referral->reward_amount);
    }

    /**
     * Case 1: Referral % = 10, Purchase = 1000 -> Referrer gets 100 coins (10%).
     */
    public function test_case_1_referral_ten_percent_on_one_thousand_coins_purchase(): void
    {
        ReferralSetting::first()->update(['reward_per_referral' => 10]);

        $referrer = User::create([
            'username' => 'referrer1',
            'mobile_number' => '9876543211',
            'referral_code' => 'REF10',
            'coins' => 0,
            'total_referrals' => 1,
            'total_referral_coins' => 0,
        ]);

        $buyer = User::create([
            'username' => 'buyer1',
            'mobile_number' => '9876543212',
            'referred_by' => $referrer->id,
            'coins' => 50,
        ]);

        Referral::create([
            'referrer_id' => $referrer->id,
            'referred_user_id' => $buyer->id,
            'referral_code' => 'REF10',
            'reward_amount' => 0,
            'status' => 'Pending',
            'joined_at' => now(),
        ]);

        $seller = Seller::create([
            'name' => 'Seller One',
            'mobile_number' => '9876543210',
            'coins' => 5000,
            'status' => true,
        ]);

        $response = $this->actingAs($seller, 'seller')->postJson(route('seller.transfer.submit'), [
            'user_id' => $buyer->id,
            'amount' => 1000,
        ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $referrer->refresh();
        $buyer->refresh();

        // Referrer receives 10% of 1000 = 100 coins
        $this->assertEquals(100, $referrer->coins);
        $this->assertEquals(100, $referrer->total_referral_coins);

        // Buyer receives 1000 coins (+ 50 existing = 1050)
        $this->assertEquals(1050, $buyer->coins);

        // Wallet Transaction created for referrer
        $referrerTxn = WalletTransaction::where('user_id', $referrer->id)->first();
        $this->assertNotNull($referrerTxn);
        $this->assertEquals(100, $referrerTxn->amount);
        $this->assertEquals('Referral Reward (10%) from buyer1 purchase', $referrerTxn->description);

        // Referral record updated
        $referral = Referral::where('referred_user_id', $buyer->id)->first();
        $this->assertEquals('Completed', $referral->status);
        $this->assertEquals(100, $referral->reward_amount);
    }

    /**
     * Case 2: Referral % = 25, Purchase = 4000 -> Referrer gets 1000 coins (25%).
     */
    public function test_case_2_referral_twenty_five_percent_on_four_thousand_coins_purchase(): void
    {
        ReferralSetting::first()->update(['reward_per_referral' => 25]);

        $referrer = User::create([
            'username' => 'referrer2',
            'mobile_number' => '9876543221',
            'referral_code' => 'REF25',
            'coins' => 500,
            'total_referrals' => 1,
            'total_referral_coins' => 0,
        ]);

        $buyer = User::create([
            'username' => 'buyer2',
            'mobile_number' => '9876543222',
            'referred_by' => $referrer->id,
            'coins' => 0,
        ]);

        Referral::create([
            'referrer_id' => $referrer->id,
            'referred_user_id' => $buyer->id,
            'referral_code' => 'REF25',
            'reward_amount' => 0,
            'status' => 'Pending',
            'joined_at' => now(),
        ]);

        $seller = Seller::create([
            'name' => 'Seller Two',
            'mobile_number' => '9876543220',
            'coins' => 10000,
            'status' => true,
        ]);

        $response = $this->actingAs($seller, 'seller')->postJson(route('seller.transfer.submit'), [
            'user_id' => $buyer->id,
            'amount' => 4000,
        ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $referrer->refresh();

        // Referrer receives 25% of 4000 = 1000 (+ 500 existing = 1500)
        $this->assertEquals(1500, $referrer->coins);
        $this->assertEquals(1000, $referrer->total_referral_coins);
    }

    /**
     * Case 3: Referral % = 0, Purchase = 5000 -> Referrer gets 0 coins.
     */
    public function test_case_3_referral_zero_percent_on_five_thousand_coins_purchase(): void
    {
        ReferralSetting::first()->update(['reward_per_referral' => 0]);

        $referrer = User::create([
            'username' => 'referrer3',
            'mobile_number' => '9876543231',
            'referral_code' => 'REF0',
            'coins' => 200,
            'total_referrals' => 1,
            'total_referral_coins' => 0,
        ]);

        $buyer = User::create([
            'username' => 'buyer3',
            'mobile_number' => '9876543232',
            'referred_by' => $referrer->id,
            'coins' => 0,
        ]);

        $seller = Seller::create([
            'name' => 'Seller Three',
            'mobile_number' => '9876543230',
            'coins' => 10000,
            'status' => true,
        ]);

        $response = $this->actingAs($seller, 'seller')->postJson(route('seller.transfer.submit'), [
            'user_id' => $buyer->id,
            'amount' => 5000,
        ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $referrer->refresh();

        // Referrer receives 0 coins
        $this->assertEquals(200, $referrer->coins);
        $this->assertEquals(0, $referrer->total_referral_coins);
    }
}

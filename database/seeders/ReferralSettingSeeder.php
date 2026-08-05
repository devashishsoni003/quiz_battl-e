<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReferralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ReferralSetting::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'Refer and Earn',
                'description' => 'Invite your friends and earn rewards.',
                'reward_per_referral' => 100,
                'new_user_bonus' => 50,
                'status' => 1,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WithdrawalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\WithdrawalSetting::updateOrCreate(
            ['id' => 1],
            [
                'coins_per_usd' => 1000,
                'usd_to_local_rate' => 83.50,
                'local_currency' => 'INR',
                'minimum_withdrawal_coins' => 5000,
                'maximum_withdrawal_coins' => 100000,
                'processing_time' => '3-5 Business Days',
                'note' => 'Please note that withdrawal processing may be delayed on public holidays.',
                'status' => 1
            ]
        );
    }
}

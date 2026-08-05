<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalSetting;
use Illuminate\Http\Request;

class WithdrawalSettingController extends Controller
{
    public function edit()
    {
        $setting = WithdrawalSetting::firstOrCreate(
            ['id' => 1],
            [
                'coins_per_usd' => 1000,
                'usd_to_local_rate' => 83.50,
                'local_currency' => 'INR',
                'minimum_withdrawal_coins' => 5000,
                'maximum_withdrawal_coins' => 100000,
                'processing_time' => '3-5 Business Days',
                'status' => 1
            ]
        );

        return view('admin.pages.withdrawal-settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'coins_per_usd' => 'required|numeric|gt:0',
            'usd_to_local_rate' => 'required|numeric|gt:0',
            'local_currency' => 'required|string|max:10',
            'minimum_withdrawal_coins' => 'required|integer|gt:0',
            'maximum_withdrawal_coins' => 'required|integer|gt:minimum_withdrawal_coins',
            'processing_time' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'status' => 'boolean'
        ]);

        $setting = WithdrawalSetting::firstOrFail();
        
        $setting->update([
            'coins_per_usd' => $request->coins_per_usd,
            'usd_to_local_rate' => $request->usd_to_local_rate,
            'local_currency' => $request->local_currency,
            'minimum_withdrawal_coins' => $request->minimum_withdrawal_coins,
            'maximum_withdrawal_coins' => $request->maximum_withdrawal_coins,
            'processing_time' => $request->processing_time,
            'note' => $request->note,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Withdrawal Settings updated successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReferralSettingController extends Controller
{
    /**
     * Show the form for editing the referral settings.
     */
    public function edit()
    {
        $settings = ReferralSetting::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'Refer and Earn',
                'description' => 'Invite your friends and earn rewards.',
                'reward_per_referral' => 100,
                'new_user_bonus' => 50,
                'status' => 1,
            ]
        );

        return view('admin.pages.referral-settings.edit', compact('settings'));
    }

    /**
     * Update the referral settings in storage.
     */
    public function update(Request $request)
    {
        $settings = ReferralSetting::firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reward_per_referral' => 'required|numeric|min:0',
            'new_user_bonus' => 'required|numeric|min:0',
            'share_title' => 'nullable|string|max:255',
            'share_message' => 'nullable|string',
            'share_link' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('banner_image');

        if ($request->hasFile('banner_image')) {
            // Delete old image
            if ($settings->banner_image && Storage::disk('public')->exists('referral/' . $settings->banner_image)) {
                Storage::disk('public')->delete('referral/' . $settings->banner_image);
            }

            $imageName = time() . '.' . $request->banner_image->extension();
            $request->banner_image->storeAs('referral', $imageName, 'public');
            $data['banner_image'] = $imageName;
        }

        $settings->update($data);

        return redirect()->back()->with('success', 'Referral settings updated successfully.');
    }
}

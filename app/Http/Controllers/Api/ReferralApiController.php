<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\ReferralSetting;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReferralApiController extends Controller
{
    /**
     * API 1: Return complete referral screen data.
     */
    public function getReferralData(Request $request)
    {
        $user = $request->user();

        $settings = ReferralSetting::first() ?? new ReferralSetting([
            'title' => '',
            'description' => '',
            'reward_per_referral' => 0,
            'new_user_bonus' => 0,
            'share_title' => '',
            'share_message' => '',
        ]);

        $recentHistory = Referral::with('referredUser')
            ->where('referrer_id', $user->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($referral) {
                return [
                    'id' => $referral->id,
                    'name' => $referral->referredUser ? $referral->referredUser->username : 'Unknown',
                    'profile_image' => $referral->referredUser ? $referral->referredUser->image_url : null,
                    'reward_amount' => $referral->reward_amount,
                    'joined_date' => $referral->joined_at ? $referral->joined_at->toIso8601String() : null,
                ];
            });

        $domain = url('/');
        $referralCode = $user->referral_code ?? 'NOCODE';
        $customShareLink = $settings->share_link ?? "$domain/invite/$referralCode";

        return response()->json([
            'status' => true,
            'message' => 'Referral data fetched successfully.',
            'data' => [
                'banner_image' => $settings->banner_url ?? "",
                'title' => $settings->title ?? "",
                'description' => $settings->description ?? "",
                'reward_per_referral' => (int) $settings->reward_per_referral,
                'new_user_bonus' => (int) $settings->new_user_bonus,
                'share_title' => $settings->share_title ?? "",
                'share_message' => $settings->share_message ?? "",
                'referral_code' => $referralCode,
                'referral_link' => $customShareLink,
                'total_invited' => (int) $user->total_referrals,
                'joined' => (int) Referral::where('referrer_id', $user->id)->where('status', 'Completed')->count(),
                'coins_earned' => (int) $user->total_referral_coins,
                'recent_history' => $recentHistory->toArray() ?? [],
            ]
        ], 200);
    }


    public function getHistory(Request $request)
    {
        $user = $request->user();

        $referrals = Referral::with('referredUser')
            ->where('referrer_id', $user->id)
            ->latest()
            ->paginate(10);

        $mappedHistory = $referrals->map(function ($referral) {
            return [
                'id' => $referral->id,
                'user_name' => $referral->referredUser ? $referral->referredUser->username : 'Unknown',
                'user_image' => $referral->referredUser ? $referral->referredUser->image_url : null,
                'reward_amount' => $referral->reward_amount,
                'status' => $referral->status,
                'joined_at' => $referral->joined_at ? $referral->joined_at->toIso8601String() : null,
                'rewarded_at' => $referral->rewarded_at ? $referral->rewarded_at->toIso8601String() : null,
            ];
        });

        $paginatedResponse = $referrals->toArray();
        $paginatedResponse['data'] = $mappedHistory;

        return response()->json([
            'status' => true,
            'message' => 'Referral history fetched successfully.',
            'data' => $paginatedResponse
        ], 200);
    }


    public function applyReferral(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'referral_code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $referralCode = $request->input('referral_code');

        if ($user->referral_code === $referralCode) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot apply your own referral code.',
            ], 400);
        }

        if ($user->referred_by !== null) {
            return response()->json([
                'status' => false,
                'message' => 'You have already applied a referral code.',
            ], 400);
        }

        $referrer = User::where('referral_code', $referralCode)->first();
        if (!$referrer) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid referral code.',
            ], 404);
        }

        $settings = ReferralSetting::first();
        $rewardAmount = $settings ? $settings->reward_per_referral : 0;
        $newUserBonus = $settings ? $settings->new_user_bonus : 0;

        try {
            DB::beginTransaction();


            $user->referred_by = $referrer->id;

            if ($newUserBonus > 0) {
                $user->coins += $newUserBonus;
                WalletTransaction::create([
                    'user_id' => $user->id,
                    'amount' => $newUserBonus,
                    'type' => 'credit',
                    'description' => 'New User Referral Bonus'
                ]);
            }
            $user->save();


            Referral::create([
                'referrer_id' => $referrer->id,
                'referred_user_id' => $user->id,
                'referral_code' => $referralCode,
                'reward_amount' => $rewardAmount,
                'status' => 'Completed',
                'joined_at' => now(),
                'rewarded_at' => now(),
            ]);


            if ($rewardAmount > 0) {
                $referrer->coins += $rewardAmount;
                $referrer->total_referrals += 1;
                $referrer->total_referral_coins += $rewardAmount;
                $referrer->save();

                WalletTransaction::create([
                    'user_id' => $referrer->id,
                    'amount' => $rewardAmount,
                    'type' => 'credit',
                    'description' => 'Referral Bonus for inviting ' . $user->name,
                ]);
            } else {
                $referrer->total_referrals += 1;
                $referrer->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Referral code applied successfully.',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while applying the referral code. Please try again.',
            ], 500);
        }
    }

    /**
     * API 4: Return share data.
     */
    public function getShareData(Request $request)
    {
        $user = $request->user();
        $settings = ReferralSetting::first();

        $domain = url('/');
        $referralCode = $user->referral_code ?? 'NOCODE';
        $customShareLink = $settings && $settings->share_link ? $settings->share_link : "$domain/invite/$referralCode";

        return response()->json([
            'status' => true,
            'data' => [
                'share_title' => $settings->share_title ?? "",
                'share_message' => $settings->share_message ?? "",
                'share_link' => $customShareLink,
                'referral_code' => $referralCode
            ]
        ], 200);
    }
}

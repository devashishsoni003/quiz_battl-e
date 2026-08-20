<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\ReferralSetting;
use App\Models\Seller;
use App\Models\SellerTransaction;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Show the Transfer Coins form.
     */
    public function showTransferForm()
    {
        return view('seller.pages.transfer');
    }

    /**
     * Search user by User ID (u_id) or Mobile Number.
     */
    public function searchUser(Request $request)
    {
        $query = $request->input('search_query');

        if (empty($query)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please enter User ID or Mobile Number.'
            ], 422);
        }

        $user = User::where('u_id', $query)
            ->orWhere('mobile_number', $query)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'u_id' => $user->u_id,
                'name' => $user->username ?? 'N/A',
                'mobile' => $user->mobile_number,
                'image_url' => $user->image_url,
                'coins' => $user->coins,
                'status' => 'Active' // We can assume active since no status field in user model
            ]
        ]);
    }

    /**
     * Perform coin transfer from seller to user.
     */
    public function transferCoins(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $validator->errors()
            ], 422);
        }

        $userId = $request->input('user_id');
        $amount = (int) $request->input('amount');
        $sellerId = Auth::guard('seller')->id();

        try {
            DB::beginTransaction();

            // Lock the seller and user rows for update to prevent race conditions
            $seller = Seller::lockForUpdate()->findOrFail($sellerId);
            $user = User::lockForUpdate()->findOrFail($userId);

            // Validation checks
            if ($seller->coins < $amount) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Insufficient coin balance.'
                ], 400);
            }

            $referenceId = 'TXN' . strtoupper(Str::random(10));

            // Record balances before transaction
            $sellerBalanceBefore = $seller->coins;
            $userBalanceBefore = $user->coins;

            // Deduct coins from Seller
            $seller->coins -= $amount;
            $seller->save();

            // Add coins to User
            $user->coins += $amount;
            $user->save();

            // Create Seller Transaction Record
            SellerTransaction::create([
                'seller_id' => $seller->id,
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'transfer',
                'description' => "Coins transferred to User ID: {$user->u_id}",
                'balance_before' => $sellerBalanceBefore,
                'balance_after' => $seller->coins,
                'status' => 'Completed',
                'reference_id' => $referenceId,
            ]);

            // Create User Wallet Transaction Record
            WalletTransaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'credit',
                'description' => "Coins received from Seller ID: {$seller->u_id}",
            ]);

            // Handle Dynamic Referral Percentage Reward if user was referred
            if ($user->referred_by) {
                $referrer = User::lockForUpdate()->find($user->referred_by);
                if ($referrer) {
                    $settings = ReferralSetting::first();
                    $percentage = $settings ? (float) $settings->reward_per_referral : 0;
                    if ($percentage > 0) {
                        $rewardCoins = (int) floor(($amount * $percentage) / 100);
                        if ($rewardCoins > 0) {
                            $referrer->coins += $rewardCoins;
                            $referrer->total_referral_coins += $rewardCoins;
                            $referrer->save();

                            $formattedPercentage = ($percentage == (int) $percentage) ? (int) $percentage : $percentage;
                            $userIdentifier = $user->username ?: ($user->u_id ?: 'USER' . $user->id);

                            WalletTransaction::create([
                                'user_id' => $referrer->id,
                                'amount' => $rewardCoins,
                                'type' => 'credit',
                                'description' => "Referral Reward ({$formattedPercentage}%) from {$userIdentifier} purchase",
                            ]);

                            $referral = Referral::where('referred_user_id', $user->id)
                                ->where('referrer_id', $referrer->id)
                                ->first();

                            if ($referral) {
                                $referral->reward_amount += $rewardCoins;
                                $referral->status = 'Completed';
                                $referral->rewarded_at = now();
                                $referral->save();
                            }
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Coins transferred successfully.',
                'reference_id' => $referenceId,
                'seller_balance' => $seller->coins
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Coin Transfer Exception', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during transfer. Please try again.'
            ], 500);
        }
    }

    /**
     * Display a listing of seller transactions.
     */
    public function transactionsList(Request $request)
    {
        $seller = Auth::guard('seller')->user();
        $query = SellerTransaction::where('seller_id', $seller->id)->with('user')->latest();

        // Filter by start/end date
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->input('start_date') . ' 00:00:00',
                $request->input('end_date') . ' 23:59:59'
            ]);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Search by User ID or Username
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('username', 'like', "%{$search}%")
                       ->orWhere('u_id', 'like', "%{$search}%");
                })->orWhere('reference_id', 'like', "%{$search}%");
            });
        }

        $transactions = $query->paginate(10)->appends($request->all());

        return view('seller.pages.transactions', compact('transactions'));
    }

    /**
     * Display a listing of distributed coins history.
     */
    public function distributionsList(Request $request)
    {
        $seller = Auth::guard('seller')->user();
        // Distribution is only 'transfer' type transactions to users
        $query = SellerTransaction::where('seller_id', $seller->id)
            ->where('type', 'transfer')
            ->with('user')
            ->latest();

        // Filter by start/end date
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->input('start_date') . ' 00:00:00',
                $request->input('end_date') . ' 23:59:59'
            ]);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Search by User ID, Name, Reference ID
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('username', 'like', "%{$search}%")
                       ->orWhere('u_id', 'like', "%{$search}%");
                })->orWhere('reference_id', 'like', "%{$search}%");
            });
        }

        // Filter by min/max coins amount
        if ($request->filled('amount')) {
            $query->where('amount', $request->input('amount'));
        }

        $distributions = $query->paginate(10)->appends($request->all());

        return view('seller.pages.distributions', compact('distributions'));
    }
}

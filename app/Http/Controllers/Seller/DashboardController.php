<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Show the Seller Dashboard.
     */
    public function index()
    {
        $seller = Auth::guard('seller')->user();

        // 1. Available Coins
        $availableCoins = $seller->coins;

        // 2. Calculate Total Profit (10% commission on completed coin transfers)
        $totalTransferredCoins = SellerTransaction::where('seller_id', $seller->id)
            ->where('type', 'transfer')
            ->where('status', 'Completed')
            ->sum('amount');
        $totalProfit = $totalTransferredCoins * 0.10; // 10% profit margin

        // 3. Today's Summary
        $todayCoinsSent = SellerTransaction::where('seller_id', $seller->id)
            ->where('type', 'transfer')
            ->where('status', 'Completed')
            ->whereDate('created_at', now()->today())
            ->sum('amount');

        $todayUsersCount = SellerTransaction::where('seller_id', $seller->id)
            ->where('type', 'transfer')
            ->where('status', 'Completed')
            ->whereDate('created_at', now()->today())
            ->distinct('user_id')
            ->count('user_id');

        $todayCoinsReceived = SellerTransaction::where('seller_id', $seller->id)
            ->where('type', 'recharge')
            ->where('status', 'Completed')
            ->whereDate('created_at', now()->today())
            ->sum('amount');

        // 4. Recent Transactions (latest 5)
        $recentTransactions = SellerTransaction::where('seller_id', $seller->id)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('seller.pages.dashboard', compact(
            'seller',
            'availableCoins',
            'totalProfit',
            'todayCoinsSent',
            'todayUsersCount',
            'todayCoinsReceived',
            'recentTransactions'
        ));
    }

    /**
     * Show the Seller Profile edit page.
     */
    public function profile()
    {
        $seller = Auth::guard('seller')->user();
        return view('seller.pages.profile', compact('seller'));
    }

    /**
     * Update the Seller Profile.
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Seller $seller */
        $seller = Auth::guard('seller')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'whatsapp_number' => 'nullable|numeric|digits_between:10,15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $seller->name = $request->input('name');
        $seller->whatsapp_number = $request->input('whatsapp_number');

        if ($request->filled('password')) {
            $seller->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($seller->image && Storage::disk('public')->exists('sellers/' . $seller->image)) {
                Storage::disk('public')->delete('sellers/' . $seller->image);
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->storeAs('sellers', $imageName, 'public');
            $seller->image = $imageName;
        }

        $seller->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}

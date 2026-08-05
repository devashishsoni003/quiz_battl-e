<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Referral::with(['referrer', 'referredUser'])->latest();

        // Referrer Filter
        if ($request->filled('referrer')) {
            $referrerSearch = $request->input('referrer');
            $query->whereHas('referrer', function ($q) use ($referrerSearch) {
                $q->where('username', 'like', "%{$referrerSearch}%")
                  ->orWhere('mobile_number', 'like', "%{$referrerSearch}%");
            });
        }

        // Referred User Filter
        if ($request->filled('referred_user')) {
            $referredSearch = $request->input('referred_user');
            $query->whereHas('referredUser', function ($q) use ($referredSearch) {
                $q->where('username', 'like', "%{$referredSearch}%")
                  ->orWhere('mobile_number', 'like', "%{$referredSearch}%");
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Date Range Filter
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $referrals = $query->paginate(10)->withQueryString();

        return view('admin.pages.referrals.index', compact('referrals'));
    }
}

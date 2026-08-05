<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;

class WithdrawalRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = WithdrawalRequest::with(['user', 'withdrawalAccount', 'admin'])->latest();

        // Filter by user
        if ($request->filled('user')) {
            $userSearch = $request->input('user');
            $query->whereHas('user', function ($q) use ($userSearch) {
                $q->where('username', 'like', "%{$userSearch}%")
                  ->orWhere('mobile_number', 'like', "%{$userSearch}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->input('start_date') . ' 00:00:00',
                $request->input('end_date') . ' 23:59:59'
            ]);
        }

        $requests = $query->paginate(15)->appends($request->all());

        return view('admin.pages.withdrawal-requests.index', compact('requests'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'transaction_id' => 'required|string|max:255',
            'admin_note' => 'nullable|string'
        ]);

        $withdrawalRequest = WithdrawalRequest::findOrFail($id);
        if ($withdrawalRequest->status !== 'Pending') {
            return redirect()->back()->with('error', 'Only pending requests can be approved.');
        }

        $withdrawalRequest->update([
            'status' => 'Approved',
            'transaction_id' => $request->transaction_id,
            'admin_note' => $request->admin_note,
            'approved_by' => auth()->id() ?? 1, // Fallback to 1 if auth issue in console
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Withdrawal request approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string'
        ]);

        $withdrawalRequest = WithdrawalRequest::findOrFail($id);
        if ($withdrawalRequest->status !== 'Pending') {
            return redirect()->back()->with('error', 'Only pending requests can be rejected.');
        }

        // Wallet logic would ideally refund the coins here if it's rejected,
        // but the prompt says: "Do NOT modify existing wallet logic."
        // We will just update status as requested.
        
        $withdrawalRequest->update([
            'status' => 'Rejected',
            'admin_note' => $request->reject_reason,
            'rejected_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Withdrawal request rejected successfully.');
    }
}

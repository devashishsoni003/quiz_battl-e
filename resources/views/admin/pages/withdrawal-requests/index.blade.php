@extends('admin.layouts.index')

@section('title', 'Withdrawal Requests')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Withdrawal Requests</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <div class="profile-card-header" style="margin-bottom: 0.5rem;">
                    <span class="header-icon">💸</span>
                    <h2>Withdrawal Requests</h2>
                </div>
                <p style="color: #9ca3af; font-size: 0.9rem; margin-top: 0; margin-bottom: 1rem;">View and manage user withdrawal requests</p>
            </div>
        </div>

        <!-- Filters -->
        <form action="{{ route('admin.withdrawal-requests.index') }}" method="GET" style="margin-bottom: 2rem; background: #1a1825; padding: 1.5rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.05);">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
                
                <div style="flex: 1 1 200px;">
                    <label class="form-label" style="font-size: 0.85rem;">User Name/Mobile</label>
                    <input type="text" name="user" class="form-input" value="{{ request('user') }}" placeholder="Search user...">
                </div>

                <div style="flex: 1 1 150px;">
                    <label class="form-label" style="font-size: 0.85rem;">Status</label>
                    <select name="status" class="form-input" style="background-color: #1e1b2e;">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div style="flex: 1 1 150px;">
                    <label class="form-label" style="font-size: 0.85rem;">Start Date</label>
                    <input type="date" name="start_date" class="form-input" value="{{ request('start_date') }}" style="background-color: #1e1b2e; color-scheme: dark;">
                </div>

                <div style="flex: 1 1 150px;">
                    <label class="form-label" style="font-size: 0.85rem;">End Date</label>
                    <input type="date" name="end_date" class="form-input" value="{{ request('end_date') }}" style="background-color: #1e1b2e; color-scheme: dark;">
                </div>

                <div style="flex: 0 0 auto;">
                    <button type="submit" class="btn-profile-save" style="padding: 0.6rem 1.5rem;">Filter</button>
                    <a href="{{ route('admin.withdrawal-requests.index') }}" class="btn-profile-save" style="background-color: #4b5563; padding: 0.6rem 1.5rem; text-decoration: none; margin-left: 0.5rem;">Reset</a>
                </div>
            </div>
        </form>

        <!-- Data Table -->
        <div style="overflow-x: auto;">
            <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>User</th>
                        <th>Account Details</th>
                        <th>Coins</th>
                        <th>USD Amount</th>
                        <th>Final Amount</th>
                        <th>Status</th>
                        <th>Request Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($requests as $req)
                    <tr>
                        <td>{{ $loop->iteration + $requests->firstItem() - 1 }}</td>
                        <td>
                            @if($req->user)
                                <div style="display: flex; flex-direction: column;">
                                    <strong style="color: #ffffff;">{{ $req->user->username ?: 'No Username' }}</strong>
                                    <span style="color: #9ca3af; font-size: 0.8rem;">{{ $req->user->mobile_number ?: 'No Mobile' }}</span>
                                </div>
                            @else
                                <span style="color: #ef4444;">User Deleted</span>
                            @endif
                        </td>
                        <td>
                            @if($req->withdrawalAccount)
                                <div style="display: flex; flex-direction: column;">
                                    <strong style="color: #ffffff; text-transform: uppercase;">{{ $req->withdrawalAccount->type }}</strong>
                                    <span style="color: #9ca3af; font-size: 0.8rem;">{{ json_encode($req->withdrawalAccount->details) }}</span>
                                </div>
                            @else
                                <span style="color: #9ca3af;">N/A</span>
                            @endif
                        </td>
                        <td><strong style="color: #fbbf24;">{{ number_format($req->coins) }}</strong></td>
                        <td>${{ number_format($req->usd_amount, 2) }}</td>
                        <td>
                            <strong style="color: #10b981;">{{ number_format($req->final_amount, 2) }} {{ $req->currency }}</strong>
                        </td>
                        <td>
                            @if($req->status === 'Approved')
                                <span class="gateway-badge gateway-stripe" style="border: none;">Approved</span>
                            @elseif($req->status === 'Rejected')
                                <span class="gateway-badge gateway-razorpay" style="border: none;">Rejected</span>
                            @else
                                <span class="gateway-badge" style="background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2);">Pending</span>
                            @endif
                        </td>
                        <td style="color: #9ca3af; font-size: 0.9rem;">
                            {{ $req->created_at ? $req->created_at->format('d M, Y h:i A') : '-' }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                @if($req->status === 'Pending')
                                    <button onclick="openApproveModal({{ $req->id }})" class="btn-profile-save" style="background-color: #10b981; padding: 0.4rem 0.8rem; font-size: 0.8rem;">Approve</button>
                                    <button onclick="openRejectModal({{ $req->id }})" class="btn-profile-save" style="background-color: #ef4444; padding: 0.4rem 0.8rem; font-size: 0.8rem;">Reject</button>
                                @else
                                    <span style="color: #9ca3af; font-size: 0.8rem;">No Actions</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: #9ca3af; padding: 2rem 0;">No withdrawal requests found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $requests->links('admin.common.pagination') }}
        </div>
        
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
    <div class="profile-content-card" style="width: 400px; max-width: 90%; background: #13111c;">
        <div class="profile-card-header" style="margin-bottom: 1.5rem; justify-content: space-between;">
            <h3 style="margin:0;">Approve Request</h3>
            <button onclick="closeModal('approveModal')" style="background:none; border:none; color:#fff; font-size:1.5rem; cursor:pointer;">&times;</button>
        </div>
        <form id="approveForm" method="POST" action="">
            @csrf
            <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                <label class="form-label">Transaction ID<span class="req">*</span></label>
                <input type="text" name="transaction_id" class="form-input" required>
            </div>
            <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                <label class="form-label">Admin Note (Optional)</label>
                <textarea name="admin_note" class="form-input" rows="3"></textarea>
            </div>
            <div style="text-align: right;">
                <button type="button" onclick="closeModal('approveModal')" class="btn-profile-save" style="background-color: #4b5563; margin-right: 0.5rem;">Cancel</button>
                <button type="submit" class="btn-profile-save" style="background-color: #10b981;">Confirm Approve</button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
    <div class="profile-content-card" style="width: 400px; max-width: 90%; background: #13111c;">
        <div class="profile-card-header" style="margin-bottom: 1.5rem; justify-content: space-between;">
            <h3 style="margin:0;">Reject Request</h3>
            <button onclick="closeModal('rejectModal')" style="background:none; border:none; color:#fff; font-size:1.5rem; cursor:pointer;">&times;</button>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                <label class="form-label">Reject Reason<span class="req">*</span></label>
                <textarea name="reject_reason" class="form-input" rows="3" required></textarea>
            </div>
            <div style="text-align: right;">
                <button type="button" onclick="closeModal('rejectModal')" class="btn-profile-save" style="background-color: #4b5563; margin-right: 0.5rem;">Cancel</button>
                <button type="submit" class="btn-profile-save" style="background-color: #ef4444;">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openApproveModal(id) {
        document.getElementById('approveForm').action = `/admin/withdrawal-requests/${id}/approve`;
        document.getElementById('approveModal').style.display = 'flex';
    }
    
    function openRejectModal(id) {
        document.getElementById('rejectForm').action = `/admin/withdrawal-requests/${id}/reject`;
        document.getElementById('rejectModal').style.display = 'flex';
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
</script>
@endpush

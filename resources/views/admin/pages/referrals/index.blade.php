@extends('admin.layouts.index')

@section('title', 'Referral History')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Referral History</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <div class="profile-card-header" style="margin-bottom: 0.5rem;">
                    <span class="header-icon">🔗</span>
                    <h2>Referral History</h2>
                </div>
                <p style="color: #9ca3af; font-size: 0.9rem; margin-top: 0; margin-bottom: 1rem;">View all referrals made by users</p>
            </div>
        </div>

        <!-- Filters -->
        <form action="{{ route('admin.referrals.index') }}" method="GET" style="margin-bottom: 2rem; background: #1a1825; padding: 1.5rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.05);">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
                
                <div style="flex: 1 1 200px;">
                    <label class="form-label" style="font-size: 0.85rem;">Referrer Name/Email</label>
                    <input type="text" name="referrer" class="form-input" value="{{ request('referrer') }}" placeholder="Search referrer...">
                </div>

                <div style="flex: 1 1 200px;">
                    <label class="form-label" style="font-size: 0.85rem;">Referred User Name/Email</label>
                    <input type="text" name="referred_user" class="form-input" value="{{ request('referred_user') }}" placeholder="Search referred user...">
                </div>

                <div style="flex: 1 1 150px;">
                    <label class="form-label" style="font-size: 0.85rem;">Status</label>
                    <select name="status" class="form-input" style="background-color: #1e1b2e;">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                    <a href="{{ route('admin.referrals.index') }}" class="btn-profile-save" style="background-color: #4b5563; padding: 0.6rem 1.5rem; text-decoration: none; margin-left: 0.5rem;">Reset</a>
                </div>
            </div>
        </form>

        <!-- Data Table -->
        <div style="overflow-x: auto;">
            <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Referrer</th>
                        <th>Referral Code</th>
                        <th>Referred User</th>
                        <th>Reward</th>
                        <th>Status</th>
                        <th>Joined Date</th>
                        <th>Reward Date</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($referrals as $referral)
                    <tr>
                        <td>{{ $loop->iteration + $referrals->firstItem() - 1 }}</td>
                        <td>
                            @if($referral->referrer)
                                <div style="display: flex; flex-direction: column;">
                                    <strong style="color: #ffffff;">{{ $referral->referrer->username ?: 'No Username' }}</strong>
                                    <span style="color: #9ca3af; font-size: 0.8rem;">{{ $referral->referrer->mobile_number ?: 'No Mobile' }}</span>
                                </div>
                            @else
                                <span style="color: #ef4444;">User Deleted</span>
                            @endif
                        </td>
                        <td><span style="background-color: #374151; color: #e5e7eb; padding: 0.25rem 0.75rem; border-radius: 4px; font-family: monospace;">{{ $referral->referral_code }}</span></td>
                        <td>
                            @if($referral->referredUser)
                                <div style="display: flex; flex-direction: column;">
                                    <strong style="color: #ffffff;">{{ $referral->referredUser->username ?: 'No Username' }}</strong>
                                    <span style="color: #9ca3af; font-size: 0.8rem;">{{ $referral->referredUser->mobile_number ?: 'No Mobile' }}</span>
                                </div>
                            @else
                                <span style="color: #ef4444;">User Deleted</span>
                            @endif
                        </td>
                        <td><strong style="color: #fbbf24;">{{ $referral->reward_amount }} Coins</strong></td>
                        <td>
                            @if($referral->status === 'Completed')
                                <span class="gateway-badge gateway-stripe" style="border: none;">Completed</span>
                            @elseif($referral->status === 'Cancelled')
                                <span class="gateway-badge gateway-razorpay" style="border: none;">Cancelled</span>
                            @else
                                <span class="gateway-badge" style="background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2);">Pending</span>
                            @endif
                        </td>
                        <td style="color: #9ca3af; font-size: 0.9rem;">
                            {{ $referral->joined_at ? $referral->joined_at->format('d M, Y h:i A') : '-' }}
                        </td>
                        <td style="color: #9ca3af; font-size: 0.9rem;">
                            {{ $referral->rewarded_at ? $referral->rewarded_at->format('d M, Y h:i A') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #9ca3af; padding: 2rem 0;">No referral records found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $referrals->links('admin.common.pagination') }}
        </div>
        
    </div>
</div>
@endsection

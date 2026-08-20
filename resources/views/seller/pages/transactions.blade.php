@extends('seller.layouts.index')

@section('title', 'My Transactions')

@section('content')
<div style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('seller.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Transactions</span>
    </span>
</div>

<div class="profile-layout-container" style="display: flex; flex-direction: column; gap: 1.5rem;">
    <!-- Filters Card -->
    <div class="profile-content-card" style="width: 100%;">
        <div class="profile-card-header">
            <span class="header-icon">⚙️</span>
            <h2>Filter Transactions</h2>
        </div>

        <div style="padding: 1.5rem;">
            <form method="GET" action="{{ route('seller.transactions') }}">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.2rem; align-items: flex-end; flex-wrap: wrap;">
                    
                    <!-- Search query -->
                    <div class="form-group-custom">
                        <label class="form-label" for="search">Search User / Txn ID</label>
                        <input type="text" name="search" id="search" class="form-input" value="{{ request('search') }}" placeholder="User ID or Txn ID">
                    </div>

                    <!-- Type filter -->
                    <div class="form-group-custom">
                        <label class="form-label" for="type">Type</label>
                        <select name="type" id="type" class="form-input" style="background-color: #1e1b2e; color: #ffffff;">
                            <option value="">All Types</option>
                            <option value="transfer" {{ request('type') === 'transfer' ? 'selected' : '' }}>Sent (Transfer)</option>
                            <option value="recharge" {{ request('type') === 'recharge' ? 'selected' : '' }}>Received (Recharge)</option>
                        </select>
                    </div>

                    <!-- Status filter -->
                    <div class="form-group-custom">
                        <label class="form-label" for="status">Status</label>
                        <select name="status" id="status" class="form-input" style="background-color: #1e1b2e; color: #ffffff;">
                            <option value="">All Statuses</option>
                            <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Failed" {{ request('status') === 'Failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>

                    <!-- Start date -->
                    <div class="form-group-custom">
                        <label class="form-label" for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-input" value="{{ request('start_date') }}" style="color-scheme: dark;">
                    </div>

                    <!-- End date -->
                    <div class="form-group-custom">
                        <label class="form-label" for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-input" value="{{ request('end_date') }}" style="color-scheme: dark;">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem; justify-content: flex-end;">
                    <a href="{{ route('seller.transactions') }}" class="btn-profile-save" style="background-color: #4b5563; text-decoration: none; text-align: center;">Reset</a>
                    <button type="submit" class="btn-profile-save">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions List Table -->
    <div class="profile-content-card" style="width: 100%;">
        <div style="overflow-x: auto; padding: 1.5rem;">
            <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Type</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Balance Before</th>
                        <th>Balance After</th>
                        <th>Status</th>
                        <th>Date/Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $txn)
                        <tr>
                            <td><strong style="color: #ffffff;">{{ $txn->reference_id }}</strong></td>
                            <td>
                                @if($txn->type === 'transfer')
                                    <span style="background-color: #3b82f6; color: #ffffff; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; text-transform: uppercase;">Sent</span>
                                @else
                                    <span style="background-color: #22c55e; color: #ffffff; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; text-transform: uppercase;">Received</span>
                                @endif
                            </td>
                            <td>
                                @if($txn->user)
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <img src="{{ $txn->user->image_url }}" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                        <div>
                                            <span style="color: #ffffff; display: block; font-weight: 600;">{{ $txn->user->username }}</span>
                                            <span style="font-size: 0.75rem; color: #8e89a5;">ID: {{ $txn->user->u_id }}</span>
                                        </div>
                                    </div>
                                @else
                                    <span style="color: #8e89a5;">N/A (System)</span>
                                @endif
                            </td>
                            <td>
                                <strong style="{{ $txn->type === 'transfer' ? 'color: #ef4444;' : 'color: #22c55e;' }}">
                                    {{ $txn->type === 'transfer' ? '-' : '+' }}{{ number_format($txn->amount) }}
                                </strong>
                            </td>
                            <td>{{ number_format($txn->balance_before) }}</td>
                            <td>{{ number_format($txn->balance_after) }}</td>
                            <td>
                                <span style="background-color: #1e293b; color: #38bdf8; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">
                                    {{ $txn->status }}
                                </span>
                            </td>
                            <td>{{ $txn->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #8e89a5; padding: 3rem;">No transactions found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

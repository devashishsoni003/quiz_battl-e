@extends('seller.layouts.index')

@section('title', 'Seller Dashboard')

@section('content')
<div style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <span style="color: #ffffff; font-weight: 600;">Dashboard</span>
    </span>
</div>

<div class="dashboard-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Seller Profile Card -->
    <div class="stat-card" style="display: flex; gap: 1.2rem; align-items: center; background: #1e1b2e; border: 1px solid #2e2a47; border-radius: 12px; padding: 1.5rem; position: relative;">
        <img src="{{ $seller->image_url }}" alt="Profile Image" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid #a855f7;">
        <div>
            <h3 style="color: #ffffff; margin: 0 0 0.25rem 0; font-size: 1.2rem; font-weight: 700;">{{ $seller->name }}</h3>
            <span style="display: block; color: #8e89a5; font-size: 0.85rem; margin-bottom: 0.25rem;">Seller ID: <strong>{{ $seller->u_id ?? 'N/A' }}</strong></span>
            <span style="display: block; color: #8e89a5; font-size: 0.85rem; margin-bottom: 0.5rem;">WhatsApp: <strong>{{ $seller->whatsapp_number ?? 'N/A' }}</strong></span>
            <div style="display: flex; align-items: center; gap: 0.4rem;">
                <span style="width: 8px; height: 8px; background-color: #22c55e; border-radius: 50%;"></span>
                <span style="color: #22c55e; font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Online</span>
            </div>
        </div>
        <div style="position: absolute; top: 1rem; right: 1rem; font-size: 1.2rem; cursor: pointer;" title="Notifications">🔔</div>
    </div>

    <!-- Available Coins Card -->
    <div class="stat-card" style="background: #1e1b2e; border: 1px solid #2e2a47; border-radius: 12px; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <span style="color: #8e89a5; font-weight: 600; font-size: 0.9rem;">AVAILABLE COINS</span>
                <span style="font-size: 1.5rem;">🪙</span>
            </div>
            <h2 style="color: #ffffff; font-size: 2rem; margin: 0; font-weight: 800;">{{ number_format($availableCoins) }}</h2>
        </div>
        <div style="margin-top: 1rem;">
            <a href="{{ route('seller.transfer') }}" class="btn-profile-save" style="display: inline-block; padding: 0.5rem 1rem; text-decoration: none; border-radius: 6px; font-size: 0.85rem; font-weight: 600; text-align: center; width: 100%;">Transfer Coins →</a>
        </div>
    </div>

    <!-- Total Profit Card -->
    <div class="stat-card" style="background: #1e1b2e; border: 1px solid #2e2a47; border-radius: 12px; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <span style="color: #8e89a5; font-weight: 600; font-size: 0.9rem;">TOTAL PROFIT (10%)</span>
                <span style="font-size: 1.5rem;">📈</span>
            </div>
            <h2 style="color: #22c55e; font-size: 2rem; margin: 0; font-weight: 800;">₹{{ number_format($totalProfit, 2) }}</h2>
        </div>
        <div style="margin-top: 1rem; color: #8e89a5; font-size: 0.8rem;">
            📊 Cumulative calculation on all distributions
        </div>
    </div>
</div>

<!-- Today's Summary Row -->
<h3 style="color: #ffffff; font-size: 1.1rem; margin-bottom: 1rem; font-weight: 600;">Today's Summary</h3>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; margin-bottom: 2.5rem;">
    <!-- Coins Sent -->
    <div style="background: #161426; border-left: 4px solid #a855f7; padding: 1rem; border-radius: 4px;">
        <span style="color: #8e89a5; font-size: 0.8rem; display: block; margin-bottom: 0.25rem;">Coins Sent</span>
        <strong style="color: #ffffff; font-size: 1.3rem;">{{ number_format($todayCoinsSent) }}</strong>
    </div>

    <!-- Users -->
    <div style="background: #161426; border-left: 4px solid #3b82f6; padding: 1rem; border-radius: 4px;">
        <span style="color: #8e89a5; font-size: 0.8rem; display: block; margin-bottom: 0.25rem;">Active Users Sent</span>
        <strong style="color: #ffffff; font-size: 1.3rem;">{{ $todayUsersCount }}</strong>
    </div>

    <!-- Coins Received -->
    <div style="background: #161426; border-left: 4px solid #22c55e; padding: 1rem; border-radius: 4px;">
        <span style="color: #8e89a5; font-size: 0.8rem; display: block; margin-bottom: 0.25rem;">Coins Received (Recharge)</span>
        <strong style="color: #ffffff; font-size: 1.3rem;">{{ number_format($todayCoinsReceived) }}</strong>
    </div>
</div>

<!-- Recent Transactions -->
<div class="profile-content-card" style="width: 100%; margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-bottom: 1px solid #1e1b2e;">
        <h3 style="color: #ffffff; font-size: 1.1rem; margin: 0; font-weight: 600;">Recent Transactions</h3>
        <a href="{{ route('seller.transactions') }}" style="color: #a855f7; text-decoration: none; font-size: 0.9rem; font-weight: 600;">View All →</a>
    </div>
    
    <div style="overflow-x: auto; padding: 1rem;">
        <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Type</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date/Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $txn)
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
                        <td>
                            <span style="background-color: #1e293b; color: #38bdf8; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">
                                {{ $txn->status }}
                            </span>
                        </td>
                        <td>{{ $txn->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #8e89a5; padding: 2rem;">No recent transactions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

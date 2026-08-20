@extends('seller.layouts.index')

@section('title', 'Distribution History')

@section('content')
<div style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('seller.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Distribution History</span>
    </span>
</div>

<div class="profile-layout-container" style="display: flex; flex-direction: column; gap: 1.5rem;">
    <!-- Filters Card -->
    <div class="profile-content-card" style="width: 100%;">
        <div class="profile-card-header">
            <span class="header-icon">⚙️</span>
            <h2>Filter Distributions</h2>
        </div>

        <div style="padding: 1.5rem;">
            <form method="GET" action="{{ route('seller.distributions') }}">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.2rem; align-items: flex-end; flex-wrap: wrap;">
                    
                    <!-- Search query -->
                    <div class="form-group-custom">
                        <label class="form-label" for="search">Search User / Txn ID</label>
                        <input type="text" name="search" id="search" class="form-input" value="{{ request('search') }}" placeholder="User ID or Txn ID">
                    </div>

                    <!-- Amount filter -->
                    <div class="form-group-custom">
                        <label class="form-label" for="amount">Exact Coins Amount</label>
                        <input type="number" name="amount" id="amount" class="form-input" value="{{ request('amount') }}" placeholder="e.g. 2000">
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
                    <a href="{{ route('seller.distributions') }}" class="btn-profile-save" style="background-color: #4b5563; text-decoration: none; text-align: center;">Reset</a>
                    <button type="submit" class="btn-profile-save">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Distributions List Table -->
    <div class="profile-content-card" style="width: 100%;">
        <div style="overflow-x: auto; padding: 1.5rem;">
            <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Distribution ID</th>
                        <th>User</th>
                        <th>User ID</th>
                        <th>Coins</th>
                        <th>Status</th>
                        <th>Reference/Transaction ID</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($distributions as $dist)
                        <tr>
                            <td><strong style="color: #ffffff;">#DIST-{{ $dist->id }}</strong></td>
                            <td>
                                @if($dist->user)
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <img src="{{ $dist->user->image_url }}" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                        <span style="color: #ffffff; font-weight: 600;">{{ $dist->user->username }}</span>
                                    </div>
                                @else
                                    <span style="color: #8e89a5;">N/A</span>
                                @endif
                            </td>
                            <td><span style="color: #ffffff; font-weight: 600;">{{ $dist->user->u_id ?? 'N/A' }}</span></td>
                            <td><strong style="color: #ef4444;">-{{ number_format($dist->amount) }} Coins</strong></td>
                            <td>
                                <span style="background-color: #1e293b; color: #38bdf8; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">
                                    {{ $dist->status }}
                                </span>
                            </td>
                            <td>{{ $dist->reference_id }}</td>
                            <td>{{ $dist->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #8e89a5; padding: 3rem;">No distribution history found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
                {{ $distributions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

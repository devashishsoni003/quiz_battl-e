@extends('admin.layouts.index')

@section('title', 'Sellers')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Sellers</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <div class="profile-card-header" style="margin-bottom: 0.5rem;">
                    <span class="header-icon">🛍️</span>
                    <h2>Manage Sellers</h2>
                </div>
                <p style="color: #9ca3af; font-size: 0.9rem; margin-top: 0; margin-bottom: 1rem;">View and manage registered sellers</p>
            </div>
            <a href="{{ route('admin.sellers.create') }}" class="btn-profile-save" style="text-decoration: none; display: inline-block;">+ Add Seller</a>
        </div>

        <div style="overflow-x: auto;">
            <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Profile/Store Image</th>
                        <th>Seller ID</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>WhatsApp Number</th>
                        <th>Coins</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($sellers as $seller)
                    <tr>
                        <td>{{ $loop->iteration + ($sellers->currentPage() - 1) * $sellers->perPage() }}</td>
                        <td>
                            <img src="{{ $seller->image_url }}" alt="Seller Image" style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover;">
                        </td>
                        <td><strong style="color: #ffffff;">{{ $seller->u_id ?? 'N/A' }}</strong></td>
                        <td><span style="color: #ffffff; font-weight: 600;">{{ $seller->name }}</span></td>
                        <td>{{ $seller->mobile_number }}</td>
                        <td>{{ $seller->whatsapp_number ?? 'N/A' }}</td>
                        <td><span style="background-color: #374151; color: #e5e7eb; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">🪙 {{ $seller->coins }}</span></td>
                        <td>
                            <form action="{{ route('admin.sellers.toggle-status', $seller->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="gateway-badge {{ $seller->status ? 'gateway-stripe' : 'gateway-razorpay' }}" style="border: none; cursor: pointer;">
                                    {{ $seller->status ? 'active' : 'inactive' }}
                                </button>
                            </form>
                        </td>
                        <td style="color: #9ca3af; font-size: 0.9rem;">
                            {{ $seller->created_at->format('d M, Y') }}
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('admin.sellers.edit', $seller->id) }}" class="action-btn edit-btn" style="text-decoration: none;">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.sellers.destroy', $seller->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this seller?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn" style="background: none; border: none; cursor: pointer;">
                                    🗑️ Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: #9ca3af; padding: 2rem 0;">No sellers found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $sellers->links('admin.common.pagination') }}
        </div>
        
    </div>
</div>
@endsection

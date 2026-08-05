@extends('admin.layouts.index')

@section('title', 'Quiz Battle - Home Promotions')

@section('content')
<div class="dashboard-header-title" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
            <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / <span style="color: #ffffff; font-weight: 600;">Home Promotions</span>
        </span>
        <h1 style="font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 800; color: #ffffff; margin-top: 0.5rem;">Home Promotions</h1>
    </div>
    <a href="{{ route('admin.home-promotions.create') }}" class="btn-profile-save" style="text-decoration: none; display: inline-block;">+ Add Promotion</a>
</div>

<section class="data-panel" style="margin-bottom: 2.5rem;">
    <div class="panel-header" style="margin-bottom: 1.5rem; align-items: flex-start;">
        <div>
            <h2 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; font-weight: 700; color: #ffffff;">Manage Promotions</h2>
            <p class="panel-subtitle">Manage promotional blocks and call-to-actions</p>
        </div>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Image</th>
                    <th>Image 2</th>
                    <th>Title</th>
                    <th>Button Text</th>
                    <th>Link Type</th>
                    <th>Sorting</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promotions as $promotion)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ $promotion->image_url }}" alt="Promo" style="height: 50px; border-radius: 4px; object-fit: cover;">
                    </td>
                    <td>
                        @if($promotion->image_2)
                            <img src="{{ $promotion->image_2_url }}" alt="Promo 2" style="height: 50px; border-radius: 4px; object-fit: cover;">
                        @else
                            <span style="color: #9ca3af; font-size: 0.8rem;">None</span>
                        @endif
                    </td>
                    <td><strong style="color: #ffffff;">{{ Str::limit($promotion->title, 30) }}</strong></td>
                    <td style="color: #9ca3af;">{{ $promotion->button_text }}</td>
                    <td><span class="gateway-badge gateway-paypal" style="background-color: #374151; color: #e5e7eb;">{{ ucfirst($promotion->link_type) }}</span></td>
                    <td><span class="count-bubble">{{ $promotion->sorting }}</span></td>
                    <td>
                        <form action="{{ route('admin.home-promotions.toggle-status', $promotion->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                                @if($promotion->status)
                                    <span class="gateway-badge gateway-stripe" style="background-color: rgba(52, 211, 153, 0.2); color: #34d399;">Active</span>
                                @else
                                    <span class="gateway-badge gateway-stripe" style="background-color: rgba(239, 68, 68, 0.2); color: #ef4444;">Inactive</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.home-promotions.edit', $promotion->id) }}" style="color: #60a5fa; margin-right: 10px; text-decoration: none;">✏️ Edit</a>
                        <form action="{{ route('admin.home-promotions.destroy', $promotion->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: #f87171; background: none; border: none; cursor: pointer;">🗑️ Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: #9ca3af; padding: 2rem 0;">No promotions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 1rem;">
            {{ $promotions->links('admin.common.pagination') }}
        </div>
    </div>
</section>
@endsection

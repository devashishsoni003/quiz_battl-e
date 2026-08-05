@extends('admin.layouts.index')

@section('title', 'Frames')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Frames</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <div class="profile-card-header" style="margin-bottom: 0.5rem;">
                    <span class="header-icon">🖼️</span>
                    <h2>Manage Frames</h2>
                </div>
                <p style="color: #9ca3af; font-size: 0.9rem; margin-top: 0; margin-bottom: 1rem;">Manage user profile frames</p>
            </div>
            <a href="{{ route('admin.frames.create') }}" class="btn-profile-save" style="text-decoration: none; display: inline-block;">+ Add Frame</a>
        </div>

        <div style="overflow-x: auto;">
            <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Frame Image</th>
                        <th>Frame Name</th>
                        <th>Required Level</th>
                        <th>Sorting</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($frames as $frame)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ $frame->image_url }}" alt="Frame" style="height: 60px; width: 60px; border-radius: 4px; object-fit: contain; background: #1e1b2e;">
                        </td>
                        <td><strong style="color: #ffffff;">{{ Str::limit($frame->title, 30) }}</strong></td>
                        <td><span style="color: #fbbf24; font-weight: 600;">⭐ Level {{ $frame->required_level }}</span></td>
                        <td><span style="background-color: #374151; color: #e5e7eb; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">{{ $frame->sorting }}</span></td>
                        <td>
                            <form action="{{ route('admin.frames.toggle-status', $frame->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="gateway-badge {{ $frame->status ? 'gateway-stripe' : 'gateway-razorpay' }}" style="border: none; cursor: pointer;">
                                    {{ $frame->status ? 'active' : 'inactive' }}
                                </button>
                            </form>
                        </td>
                        <td style="color: #9ca3af; font-size: 0.9rem;">
                            {{ $frame->created_at->format('d M, Y') }}
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('admin.frames.edit', $frame->id) }}" class="action-btn edit-btn">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.frames.destroy', $frame->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this frame?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn">
                                    🗑️ Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #9ca3af; padding: 2rem 0;">No frames found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $frames->links('admin.common.pagination') }}
        </div>
        
    </div>
</div>
@endsection

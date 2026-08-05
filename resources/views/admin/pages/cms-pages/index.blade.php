@extends('admin.layouts.index')

@section('title', 'CMS Pages')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">CMS Pages</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <div class="profile-card-header" style="margin-bottom: 0.5rem;">
                    <span class="header-icon">📄</span>
                    <h2>Manage CMS Pages</h2>
                </div>
                <p style="color: #9ca3af; font-size: 0.9rem; margin-top: 0; margin-bottom: 1rem;">Manage your website's content pages</p>
            </div>
            <a href="{{ route('admin.pages.create') }}" class="btn-profile-save" style="text-decoration: none; display: inline-block;">+ Add Page</a>
        </div>

        <div style="overflow-x: auto;">
            <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong style="color: #ffffff;">{{ Str::limit($page->title, 40) }}</strong></td>
                        <td><span style="color: #9ca3af; font-size: 0.9rem;">/{{ $page->slug }}</span></td>
                        <td>
                            <form action="{{ route('admin.pages.toggle-status', $page->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="gateway-badge {{ $page->status ? 'gateway-stripe' : 'gateway-razorpay' }}" style="border: none; cursor: pointer;">
                                    {{ $page->status ? 'active' : 'inactive' }}
                                </button>
                            </form>
                        </td>
                        <td style="color: #9ca3af; font-size: 0.9rem;">
                            {{ $page->created_at->format('d M, Y') }}
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="action-btn edit-btn">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this page?');">
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
                        <td colspan="6" style="text-align: center; color: #9ca3af; padding: 2rem 0;">No pages found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $pages->links('admin.common.pagination') }}
        </div>
        
    </div>
</div>
@endsection

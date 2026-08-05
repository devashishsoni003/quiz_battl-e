@extends('admin.layouts.index')

@section('title', 'Categories')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Categories</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <div class="profile-card-header" style="margin-bottom: 0.5rem;">
                    <span class="header-icon">🏷️</span>
                    <h2>Manage Categories</h2>
                </div>
                <p style="color: #9ca3af; font-size: 0.9rem; margin-top: 0; margin-bottom: 1rem;">Manage your content categories</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn-profile-save" style="text-decoration: none; display: inline-block;">+ Add Category</a>
        </div>

        <div style="overflow-x: auto;">
            <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Category Image</th>
                        <th>Title</th>
                        <th>Sorting</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ $category->image_url }}" alt="Category" style="height: 50px; border-radius: 4px; object-fit: cover;">
                        </td>
                        <td><strong style="color: #ffffff;">{{ Str::limit($category->title, 30) }}</strong></td>
                        <td><span style="background-color: #374151; color: #e5e7eb; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">{{ $category->sorting }}</span></td>
                        <td>
                            <form action="{{ route('admin.categories.toggle-status', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="gateway-badge {{ $category->status ? 'gateway-stripe' : 'gateway-razorpay' }}" style="border: none; cursor: pointer;">
                                    {{ $category->status ? 'active' : 'inactive' }}
                                </button>
                            </form>
                        </td>
                        <td style="color: #9ca3af; font-size: 0.9rem;">
                            {{ $category->created_at->format('d M, Y') }}
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="action-btn edit-btn" style="text-decoration: none;">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
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
                        <td colspan="7" style="text-align: center; color: #9ca3af; padding: 2rem 0;">No categories found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $categories->links('admin.common.pagination') }}
        </div>
        
    </div>
</div>
@endsection

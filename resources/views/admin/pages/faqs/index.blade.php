@extends('admin.layouts.index')

@section('title', 'FAQs')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">FAQs</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <div class="profile-card-header" style="margin-bottom: 0.5rem;">
                    <span class="header-icon">❓</span>
                    <h2>Manage FAQs</h2>
                </div>
                <p style="color: #9ca3af; font-size: 0.9rem; margin-top: 0; margin-bottom: 1rem;">View, search, and manage Frequently Asked Questions</p>
            </div>
            <a href="{{ route('admin.faqs.create') }}" class="btn-profile-save" style="text-decoration: none; display: inline-block;">+ Add FAQ</a>
        </div>

        <!-- Search Filter -->
        <form action="{{ route('admin.faqs.index') }}" method="GET" style="margin-bottom: 2rem; background: #1a1825; padding: 1.5rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.05);">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
                <div style="flex: 1 1 300px;">
                    <label class="form-label" style="font-size: 0.85rem;">Search Question/Answer</label>
                    <input type="text" name="search" class="form-input" value="{{ request('search') }}" placeholder="Enter keyword to search...">
                </div>
                <div style="flex: 0 0 auto;">
                    <button type="submit" class="btn-profile-save" style="padding: 0.6rem 1.5rem;">Search</button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn-profile-save" style="background-color: #4b5563; padding: 0.6rem 1.5rem; text-decoration: none; margin-left: 0.5rem;">Reset</a>
                </div>
            </div>
        </form>

        <div style="overflow-x: auto;">
            <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Icon</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Sorting</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($faqs as $faq)
                    <tr>
                        <td>{{ $loop->iteration + ($faqs->currentPage() - 1) * $faqs->perPage() }}</td>
                        <td>
                            <img src="{{ $faq->icon_url }}" alt="Icon" style="height: 35px; width: 35px; border-radius: 4px; object-fit: cover; background: #1e1b2e;">
                        </td>
                        <td><strong style="color: #ffffff;">{{ Str::limit($faq->question, 50) }}</strong></td>
                        <td style="color: #d1d5db; max-width: 300px;">{{ Str::limit($faq->answer, 80) }}</td>
                        <td><span style="background-color: #374151; color: #e5e7eb; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">{{ $faq->sorting }}</span></td>
                        <td>
                            <form action="{{ route('admin.faqs.toggle-status', $faq->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="gateway-badge {{ $faq->status ? 'gateway-stripe' : 'gateway-razorpay' }}" style="border: none; cursor: pointer;">
                                    {{ $faq->status ? 'active' : 'inactive' }}
                                </button>
                            </form>
                        </td>
                        <td style="color: #9ca3af; font-size: 0.9rem;">
                            {{ $faq->created_at ? $faq->created_at->format('d M, Y') : '-' }}
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="action-btn edit-btn" style="text-decoration: none;">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
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
                        <td colspan="7" style="text-align: center; color: #9ca3af; padding: 2rem 0;">No FAQs found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $faqs->links('admin.common.pagination') }}
        </div>
        
    </div>
</div>
@endsection

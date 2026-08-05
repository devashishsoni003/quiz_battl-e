@extends('admin.layouts.index')

@section('title', 'Quiz Levels')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Quiz Levels</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
            <div>
                <div class="profile-card-header" style="margin-bottom: 0.5rem;">
                    <span class="header-icon">🏅</span>
                    <h2>Manage Quiz Levels</h2>
                </div>
                <p style="color: #9ca3af; font-size: 0.9rem; margin-top: 0; margin-bottom: 1rem;">Manage your quiz levels</p>
            </div>
            <a href="{{ route('admin.quiz-levels.create') }}" class="btn-profile-save" style="text-decoration: none; display: inline-block;">+ Add Quiz Level</a>
        </div>

        <div style="overflow-x: auto;">
            <table class="data-panel" style="width: 100%; text-align: left; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Icon</th>
                        <th>Category</th>
                        <th>Level Name</th>
                        <th>Entry Coins</th>
                        <th>Border Color</th>
                        <th>Sorting</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($quiz_levels as $level)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ $level->icon_url }}" alt="Icon" style="height: 50px; width: 50px; border-radius: 4px; object-fit: contain; background: #1e1b2e;">
                        </td>
                        <td><strong style="color: #ffffff;">{{ $level->category ? $level->category->title : 'N/A' }}</strong></td>
                        <td><strong style="color: #ffffff;">{{ Str::limit($level->title, 30) }}</strong></td>
                        <td><span style="color: #fbbf24; font-weight: 600;">🪙 {{ $level->entry_coins }}</span></td>
                        <td>
                            @if($level->color)
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $level->color }}; border: 1px solid #4b5563;"></div>
                                    <span style="color: #9ca3af;">{{ $level->color }}</span>
                                </div>
                            @else
                                <span style="color: #6b7280;">None</span>
                            @endif
                        </td>
                        <td><span style="background-color: #374151; color: #e5e7eb; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">{{ $level->sorting }}</span></td>
                        <td>
                            <form action="{{ route('admin.quiz-levels.toggle-status', $level->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="gateway-badge {{ $level->status ? 'gateway-stripe' : 'gateway-razorpay' }}" style="border: none; cursor: pointer;">
                                    {{ $level->status ? 'active' : 'inactive' }}
                                </button>
                            </form>
                        </td>
                        <td style="color: #9ca3af; font-size: 0.9rem;">
                            {{ $level->created_at->format('d M, Y') }}
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('admin.quiz-levels.edit', $level->id) }}" class="action-btn edit-btn" style="text-decoration: none;">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.quiz-levels.destroy', $level->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this quiz level?');">
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
                        <td colspan="10" style="text-align: center; color: #9ca3af; padding: 2rem 0;">No quiz levels found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $quiz_levels->links('admin.common.pagination') }}
        </div>
        
    </div>
</div>
@endsection

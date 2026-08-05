<aside class="sidebar">
    <style>
        .nav-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out, padding 0.3s ease-in-out;
            padding-top: 0;
            padding-bottom: 0;
        }
        .nav-submenu.open {
            max-height: 300px;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
    </style>
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/images/quiz-battle.png') }}" alt="Quiz Battle" class="sidebar-logo-img">
            </a>
        </div>
    </div>


    <div class="sidebar-menu-wrapper">
        <ul class="nav-menu">
            <li class="nav-item active">
                <a href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon">🏠</span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">💳</span>
                    <span class="nav-text">Plans</span>
                    <span class="nav-badge">3</span>
                </a>
            </li>

            <li class="sidebar-section-title">Home Management</li>
            <li class="nav-item {{ request()->routeIs('admin.home-sliders.*') ? 'active' : '' }}">
                <a href="{{ route('admin.home-sliders.index') }}">
                    <span class="nav-icon">🖼️</span>
                    <span class="nav-text">Home Sliders</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.home-promotions.*') ? 'active' : '' }}">
                <a href="{{ route('admin.home-promotions.index') }}">
                    <span class="nav-icon">📢</span>
                    <span class="nav-text">Home Promotions</span>
                </a>
            </li>

            <li class="sidebar-section-title">Platform</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">👥</span>
                    <span class="nav-text">Users</span>
                    <span class="nav-badge">46</span>
                </a>
            </li>

            <li class="sidebar-section-title">Marketing</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">✉️</span>
                    <span class="nav-text">Newsletter Subscribers</span>
                    <span class="nav-badge">1</span>
                </a>
            </li>

            <li class="sidebar-section-title">Content</li>
            <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}">
                    <span class="nav-icon">🏷️</span>
                    <span class="nav-text">Categories</span>
                    <span class="nav-badge">{{ \App\Models\Category::count() }}</span>
                </a>
            </li>
            <!-- Quiz Management Section -->
            <li class="sidebar-section-title">Quiz Management</li>
            <li class="nav-item {{ request()->routeIs('admin.quiz-levels.*') ? 'active' : '' }}">
                <a href="{{ route('admin.quiz-levels.index') }}">
                    <span class="nav-icon">🏅</span>
                    <span class="nav-text">Quiz Levels</span>
                    <span class="nav-badge">{{ \App\Models\QuizLevel::count() }}</span>
                </a>
            </li>

            <!-- Customization Section -->
            <li class="sidebar-section-title">Customization</li>
            <li class="nav-item {{ request()->routeIs('admin.frames.*') ? 'active' : '' }}">
                <a href="{{ route('admin.frames.index') }}">
                    <span class="nav-icon">🖼️</span>
                    <span class="nav-text">Frames</span>
                    <span class="nav-badge">{{ \App\Models\Frame::count() }}</span>
                </a>
            </li>

            <!-- CMS Section -->
            <li class="sidebar-section-title">CMS</li>
            <li class="nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <a href="{{ route('admin.pages.index') }}">
                    <span class="nav-icon">📄</span>
                    <span class="nav-text">Pages</span>
                    <span class="nav-badge">{{ \App\Models\Page::count() }}</span>
                </a>
            </li>

            <!-- Marketing Section -->
            <li class="sidebar-section-title">Marketing</li>
            <li class="nav-item {{ request()->routeIs('admin.referral-settings.*') || request()->routeIs('admin.referrals.*') ? 'active' : '' }}">
                <a href="#" onclick="event.preventDefault(); this.parentElement.querySelector('.nav-submenu').classList.toggle('open'); let icon = this.querySelector('.caret-icon'); if(icon) { icon.style.transform = this.parentElement.querySelector('.nav-submenu').classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)'; }" style="display: flex; justify-content: space-between; align-items: center; padding: 0.8rem 1.25rem; cursor: pointer; text-decoration: none;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span class="nav-icon">📢</span>
                        <span class="nav-text" style="color: {{ request()->routeIs('admin.referral-settings.*') || request()->routeIs('admin.referrals.*') ? '#ffffff' : '#9ca3af' }}">Referral Management</span>
                    </div>
                    <span class="caret-icon" style="font-size: 0.7rem; color: #9ca3af; transition: transform 0.3s ease; transform: {{ request()->routeIs('admin.referral-settings.*') || request()->routeIs('admin.referrals.*') ? 'rotate(180deg)' : 'rotate(0deg)' }}">▼</span>
                </a>
                <ul class="nav-submenu {{ request()->routeIs('admin.referral-settings.*') || request()->routeIs('admin.referrals.*') ? 'open' : '' }}" style="list-style: none; padding-left: 3rem; margin: 0; background-color: #121019;">
                    <li style="margin-bottom: 0.5rem;">
                        <a href="{{ route('admin.referral-settings.edit') }}" style="color: {{ request()->routeIs('admin.referral-settings.*') ? '#ffffff' : '#9ca3af' }}; text-decoration: none; font-size: 0.9rem; transition: color 0.2s;">⚙️ Settings</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.referrals.index') }}" style="color: {{ request()->routeIs('admin.referrals.*') ? '#ffffff' : '#9ca3af' }}; text-decoration: none; font-size: 0.9rem; transition: color 0.2s;">🔗 History</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-section-title">Finance</li>
            <li class="nav-item {{ request()->routeIs('admin.withdrawal-settings.*') || request()->routeIs('admin.withdrawal-requests.*') ? 'active' : '' }}">
                <a href="#" onclick="event.preventDefault(); this.parentElement.querySelector('.nav-submenu').classList.toggle('open'); let icon = this.querySelector('.caret-icon'); if(icon) { icon.style.transform = this.parentElement.querySelector('.nav-submenu').classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)'; }" style="display: flex; justify-content: space-between; align-items: center; padding: 0.8rem 1.25rem; cursor: pointer; text-decoration: none;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span class="nav-icon">💸</span>
                        <span class="nav-text" style="color: {{ request()->routeIs('admin.withdrawal-settings.*') || request()->routeIs('admin.withdrawal-requests.*') ? '#ffffff' : '#9ca3af' }}">Withdrawal Management</span>
                    </div>
                    <span class="caret-icon" style="font-size: 0.7rem; color: #9ca3af; transition: transform 0.3s ease; transform: {{ request()->routeIs('admin.withdrawal-settings.*') || request()->routeIs('admin.withdrawal-requests.*') ? 'rotate(180deg)' : 'rotate(0deg)' }}">▼</span>
                </a>
                <ul class="nav-submenu {{ request()->routeIs('admin.withdrawal-settings.*') || request()->routeIs('admin.withdrawal-requests.*') ? 'open' : '' }}" style="list-style: none; padding-left: 3rem; margin: 0; background-color: #121019;">
                    <li style="margin-bottom: 0.5rem;">
                        <a href="{{ route('admin.withdrawal-settings.edit') }}" style="color: {{ request()->routeIs('admin.withdrawal-settings.*') ? '#ffffff' : '#9ca3af' }}; text-decoration: none; font-size: 0.9rem; transition: color 0.2s;">⚙️ Settings</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.withdrawal-requests.index') }}" style="color: {{ request()->routeIs('admin.withdrawal-requests.*') ? '#ffffff' : '#9ca3af' }}; text-decoration: none; font-size: 0.9rem; transition: color 0.2s;">📋 Requests</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">🛍️</span>
                    <span class="nav-text">Orders</span>
                    <span class="nav-badge">12</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">💵</span>
                    <span class="nav-text">Creator Payouts</span>
                    <span class="nav-badge">3</span>
                </a>
            </li>

            <li class="sidebar-section-title">AI</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">🎛️</span>
                    <span class="nav-text">AI Generation Logs</span>
                </a>
            </li>

            <li class="sidebar-section-title">Configuration</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">⚙️</span>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

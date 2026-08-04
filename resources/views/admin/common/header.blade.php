<!-- Navbar Header (Sits to the right of the sidebar) -->
<header class="dashboard-header">
    <div class="header-left">

    </div>
    <div class="header-right">
        <!-- Orange status button -->
        <button class="header-btn orange-btn">
            <span class="btn-icon">⊕</span>
        </button>
        <!-- Red status button -->
        <button class="header-btn red-btn">A</button>
        <!-- Plain status text button -->
        <button class="header-text-btn">A</button>
        <!-- Notification Bell -->
        <div class="notification-wrapper">
            <button class="header-btn plain-btn">
                <span class="btn-icon">🔔</span>
                <span class="badge">4</span>
            </button>
        </div>
        <!-- Language flag selector -->

        <!-- Profile avatar dropdown -->
        <div class="profile-dropdown-wrapper" id="profile-dropdown-wrapper">
            <img src="{{ Auth::guard('super_admin')->user()->image_url }}" alt="Profile" class="profile-avatar" id="profile-avatar-btn">

            <!-- Dropdown Menu -->
            <div class="profile-dropdown" id="profile-dropdown-menu">
                <div class="dropdown-header">
                    <img src="{{ Auth::guard('super_admin')->user()->image_url }}" alt="Profile" class="dropdown-avatar">
                    <div class="dropdown-info">
                        <div class="dropdown-name">
                            {{ Auth::guard('super_admin')->check() ? Auth::guard('super_admin')->user()->first_name . ' ' . Auth::guard('super_admin')->user()->last_name : 'Ivan Norris' }}
                        </div>
                        <div class="dropdown-email">
                            {{ Auth::guard('super_admin')->check() ? Auth::guard('super_admin')->user()->email : 'demo@streamit.com' }}
                        </div>
                    </div>
                </div>
                <ul class="dropdown-menu-list">
                    <li>
                        <a href="{{ route('admin.profile') }}">
                            <span>My Profile</span>
                            <span class="menu-icon">👤</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Settings</span>
                            <span class="menu-icon">⚙</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                            <span>Logout</span>
                            <span class="menu-icon">🚪</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

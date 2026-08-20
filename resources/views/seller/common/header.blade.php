<header class="dashboard-header">
    <div class="header-left">
    </div>
    <div class="header-right">
        <div class="profile-dropdown-wrapper" id="profile-dropdown-wrapper">
            <img src="{{ Auth::guard('seller')->user()->image_url }}" alt="Profile" class="profile-avatar" id="profile-avatar-btn">
            <div class="profile-dropdown" id="profile-dropdown-menu">
                <div class="dropdown-header">
                    <img src="{{ Auth::guard('seller')->user()->image_url }}" alt="Profile" class="dropdown-avatar">
                    <div class="dropdown-info">
                        <div class="dropdown-name">
                            {{ Auth::guard('seller')->user()->name }}
                        </div>
                        <div class="dropdown-email">
                            {{ Auth::guard('seller')->user()->mobile_number }}
                        </div>
                    </div>
                </div>
                <ul class="dropdown-menu-list">
                    <li>
                        <a href="{{ route('seller.profile') }}">
                            <span>My Profile</span>
                            <span class="menu-icon">👤</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('seller-logout-form').submit();">
                            <span>Logout</span>
                            <span class="menu-icon">🚪</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

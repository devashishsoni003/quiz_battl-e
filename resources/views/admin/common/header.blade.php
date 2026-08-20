<header class="dashboard-header">
    <div class="header-left">
        <!-- Sidebar Hamburger Toggle Button -->
        <button type="button" class="sidebar-toggle-btn" id="sidebar-toggle-btn" title="Toggle Sidebar">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <!-- Search Input Box with Ctrl+K shortcut badge (Screenshot 2) -->
        <div class="header-search-container">
            <span class="header-search-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <input type="text" class="header-search-input" placeholder="Search..." aria-label="Search">
            <span class="header-search-shortcut">Ctrl+K</span>
        </div>
    </div>

    <div class="header-right">
        <!-- Globe / Website Icon -->
        <button type="button" class="header-icon-btn" title="Website">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="2" y1="12" x2="22" y2="12"></line>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
            </svg>
        </button>

        <!-- Theme Mode Toggle -->
        <button type="button" class="header-icon-btn" title="Toggle Theme">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
        </button>

        <!-- Language Selector Button -->
        <button type="button" class="header-lang-btn">
            <span>文A</span>
            <span>English</span>
            <span style="font-size: 0.65rem; color: #9ca3af;">▼</span>
        </button>

        <!-- Notification Bell with Red Badge -->
        <div class="notification-wrapper">
            <button type="button" class="header-icon-btn" title="Notifications">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span class="notification-badge">4</span>
            </button>
        </div>

        <!-- Profile Widget & Dropdown (Screenshot 4) -->
        <div class="profile-dropdown-wrapper" id="profile-dropdown-wrapper">
            <button type="button" class="profile-widget-btn" id="profile-avatar-btn">
                @if(Auth::guard('super_admin')->check() && Auth::guard('super_admin')->user()->image)
                    <img src="{{ Auth::guard('super_admin')->user()->image_url }}" alt="Profile" class="profile-avatar-pill">
                @else
                    <div class="profile-avatar-pill">SU</div>
                @endif
                <span class="profile-name-text">
                    {{ Auth::guard('super_admin')->check() ? (Auth::guard('super_admin')->user()->first_name . ' ' . Auth::guard('super_admin')->user()->last_name) : 'Super Admin' }}
                </span>
                <span class="profile-chevron">▼</span>
            </button>

            <!-- Dropdown Card -->
            <div class="profile-dropdown" id="profile-dropdown-menu">
                <div class="dropdown-header">
                    <div class="dropdown-name">
                        {{ Auth::guard('super_admin')->check() ? (Auth::guard('super_admin')->user()->first_name . ' ' . Auth::guard('super_admin')->user()->last_name) : 'Super Admin' }}
                    </div>
                    <div class="dropdown-email">
                        {{ Auth::guard('super_admin')->check() ? Auth::guard('super_admin')->user()->email : 'admin@softivus.com' }}
                    </div>
                </div>
                <ul class="dropdown-menu-list">
                    <li>
                        <a href="{{ route('admin.profile') }}">
                            <span class="menu-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.index') }}">
                            <span class="menu-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </span>
                            <span>Settings</span>
                        </a>
                    </li>
                    <div class="divider"></div>
                    <li>
                        <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                            <span class="menu-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                            </span>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

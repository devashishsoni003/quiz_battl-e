<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-wrapper">
            @if(file_exists(public_path('assets/images/quiz-battle.png')))
                <img src="{{ asset('assets/images/quiz-battle.png') }}" alt="Quiz Battle" class="sidebar-logo-img">
            @else
                <div class="brand-icon-cheerly">⚡</div>
                <span class="brand-title-cheerly">QuizBattle</span>
            @endif
        </a>
    </div>

    <div class="sidebar-menu-wrapper">
        <ul class="nav-menu">
            <!-- Dashboard -->
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </span>
                    <span class="nav-text">Plans</span>
                    <span class="nav-badge">3</span>
                </a>
            </li>

            <!-- Home Management -->
            <li class="sidebar-section-title">Home Management</li>
            <li class="nav-item {{ request()->routeIs('admin.home-sliders.*') ? 'active' : '' }}">
                <a href="{{ route('admin.home-sliders.index') }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                    </span>
                    <span class="nav-text">Home Sliders</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.home-promotions.*') ? 'active' : '' }}">
                <a href="{{ route('admin.home-promotions.index') }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </span>
                    <span class="nav-text">Home Promotions</span>
                </a>
            </li>

            <!-- Platform -->
            <li class="sidebar-section-title">Platform</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </span>
                    <span class="nav-text">Users</span>
                    <span class="nav-badge">{{ \App\Models\User::count() }}</span>
                </a>
            </li>

            <!-- Seller Management -->
            <li class="sidebar-section-title">Seller Management</li>
            <li class="nav-item {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}">
                <a href="{{ route('admin.sellers.index') }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                    </span>
                    <span class="nav-text">Sellers</span>
                    <span class="nav-badge">{{ \App\Models\Seller::count() }}</span>
                </a>
            </li>

            <!-- Marketing -->
            <li class="sidebar-section-title">Marketing</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </span>
                    <span class="nav-text">Newsletter Subscribers</span>
                    <span class="nav-badge">1</span>
                </a>
            </li>

            <!-- Referral Accordion -->
            <li class="nav-item {{ request()->routeIs('admin.referral-settings.*') || request()->routeIs('admin.referrals.*') ? 'active' : '' }}">
                <a href="#" onclick="event.preventDefault(); this.parentElement.querySelector('.nav-submenu').classList.toggle('open'); let icon = this.querySelector('.caret-icon'); if(icon) { icon.style.transform = this.parentElement.querySelector('.nav-submenu').classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)'; }">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="18" cy="5" r="3"></circle>
                            <circle cx="6" cy="12" r="3"></circle>
                            <circle cx="18" cy="19" r="3"></circle>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                        </svg>
                    </span>
                    <span class="nav-text">Referral Management</span>
                    <span class="caret-icon" style="font-size: 0.65rem; transition: transform 0.25s ease; transform: {{ request()->routeIs('admin.referral-settings.*') || request()->routeIs('admin.referrals.*') ? 'rotate(180deg)' : 'rotate(0deg)' }};">▼</span>
                </a>
                <ul class="nav-submenu {{ request()->routeIs('admin.referral-settings.*') || request()->routeIs('admin.referrals.*') ? 'open' : '' }}">
                    <li>
                        <a href="{{ route('admin.referral-settings.edit') }}" class="{{ request()->routeIs('admin.referral-settings.*') ? 'active' : '' }}">Settings</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.referrals.index') }}" class="{{ request()->routeIs('admin.referrals.*') ? 'active' : '' }}">History</a>
                    </li>
                </ul>
            </li>

            <!-- Content -->
            <li class="sidebar-section-title">Content</li>
            <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                    </span>
                    <span class="nav-text">Categories</span>
                    <span class="nav-badge">{{ \App\Models\Category::count() }}</span>
                </a>
            </li>

            <!-- Quiz Management -->
            <li class="sidebar-section-title">Quiz Management</li>
            <li class="nav-item {{ request()->routeIs('admin.quiz-levels.*') ? 'active' : '' }}">
                <a href="{{ route('admin.quiz-levels.index') }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </span>
                    <span class="nav-text">Quiz Levels</span>
                    <span class="nav-badge">{{ \App\Models\QuizLevel::count() }}</span>
                </a>
            </li>

            <!-- Customization -->
            <li class="sidebar-section-title">Customization</li>
            <li class="nav-item {{ request()->routeIs('admin.frames.*') ? 'active' : '' }}">
                <a href="{{ route('admin.frames.index') }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <rect x="7" y="7" width="10" height="10"></rect>
                        </svg>
                    </span>
                    <span class="nav-text">Frames</span>
                    <span class="nav-badge">{{ \App\Models\Frame::count() }}</span>
                </a>
            </li>

            <!-- CMS -->
            <li class="sidebar-section-title">CMS</li>
            <li class="nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                <a href="{{ route('admin.pages.index') }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </span>
                    <span class="nav-text">Pages</span>
                    <span class="nav-badge">{{ \App\Models\Page::count() }}</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <a href="{{ route('admin.faqs.index') }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                    </span>
                    <span class="nav-text">FAQ</span>
                    <span class="nav-badge">{{ \App\Models\Faq::count() }}</span>
                </a>
            </li>

            <!-- Finance -->
            <li class="sidebar-section-title">Finance</li>
            <li class="nav-item {{ request()->routeIs('admin.withdrawal-settings.*') || request()->routeIs('admin.withdrawal-requests.*') ? 'active' : '' }}">
                <a href="#" onclick="event.preventDefault(); this.parentElement.querySelector('.nav-submenu').classList.toggle('open'); let icon = this.querySelector('.caret-icon'); if(icon) { icon.style.transform = this.parentElement.querySelector('.nav-submenu').classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)'; }">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </span>
                    <span class="nav-text">Withdrawal Management</span>
                    <span class="caret-icon" style="font-size: 0.65rem; transition: transform 0.25s ease; transform: {{ request()->routeIs('admin.withdrawal-settings.*') || request()->routeIs('admin.withdrawal-requests.*') ? 'rotate(180deg)' : 'rotate(0deg)' }};">▼</span>
                </a>
                <ul class="nav-submenu {{ request()->routeIs('admin.withdrawal-settings.*') || request()->routeIs('admin.withdrawal-requests.*') ? 'open' : '' }}">
                    <li>
                        <a href="{{ route('admin.withdrawal-settings.edit') }}" class="{{ request()->routeIs('admin.withdrawal-settings.*') ? 'active' : '' }}">Settings</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.withdrawal-requests.index') }}" class="{{ request()->routeIs('admin.withdrawal-requests.*') ? 'active' : '' }}">Requests</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </span>
                    <span class="nav-text">Orders</span>
                    <span class="nav-badge">12</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <line x1="6" y1="12" x2="6" y2="12.01"></line>
                            <line x1="10" y1="12" x2="10" y2="12.01"></line>
                            <line x1="14" y1="12" x2="14" y2="12.01"></line>
                            <line x1="18" y1="12" x2="18" y2="12.01"></line>
                        </svg>
                    </span>
                    <span class="nav-text">Creator Payouts</span>
                    <span class="nav-badge">3</span>
                </a>
            </li>

            <!-- AI -->
            <li class="sidebar-section-title">AI</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                    </span>
                    <span class="nav-text">AI Generation Logs</span>
                </a>
            </li>

            <!-- Configuration -->
            <li class="sidebar-section-title">Configuration</li>
            <li class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.index') }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                    </span>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

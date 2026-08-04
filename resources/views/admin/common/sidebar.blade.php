<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/images/quiz-battle.png') }}" alt="Quiz Battle" class="sidebar-logo-img">
            </a>
        </div>
    </div>
    
    <!-- Sidebar Menu scroll wrapper for smooth scrolling -->
    <div class="sidebar-menu-wrapper">
        <ul class="nav-menu">
            <!-- Main Section -->
            <li class="nav-item active">
                <a href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon">🏠</span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">🏷️</span>
                    <span class="nav-text">Categories</span>
                    <span class="nav-badge">20</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">💳</span>
                    <span class="nav-text">Plans</span>
                    <span class="nav-badge">3</span>
                </a>
            </li>

            <!-- Platform Section -->
            <li class="sidebar-section-title">Platform</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">👥</span>
                    <span class="nav-text">Users</span>
                    <span class="nav-badge">46</span>
                </a>
            </li>

            <!-- Marketing Section -->
            <li class="sidebar-section-title">Marketing</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">✉️</span>
                    <span class="nav-text">Newsletter Subscribers</span>
                    <span class="nav-badge">1</span>
                </a>
            </li>

            <!-- Content Section -->
            <li class="sidebar-section-title">Content</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">🎓</span>
                    <span class="nav-text">Quizzes</span>
                    <span class="nav-badge">20</span>
                </a>
            </li>

            <!-- Finance Section -->
            <li class="sidebar-section-title">Finance</li>
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

            <!-- AI Section -->
            <li class="sidebar-section-title">AI</li>
            <li class="nav-item">
                <a href="#">
                    <span class="nav-icon">🎛️</span>
                    <span class="nav-text">AI Generation Logs</span>
                </a>
            </li>

            <!-- Configuration Section -->
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

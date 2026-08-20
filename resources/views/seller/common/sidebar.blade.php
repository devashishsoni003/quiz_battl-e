<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('seller.dashboard') }}">
                <img src="{{ asset('assets/images/quiz-battle.png') }}" alt="Quiz Battle" class="sidebar-logo-img">
            </a>
        </div>
    </div>

    <div class="sidebar-menu-wrapper">
        <ul class="nav-menu">
            <li class="nav-item {{ request()->routeIs('seller.dashboard*') ? 'active' : '' }}">
                <a href="{{ route('seller.dashboard') }}">
                    <span class="nav-icon">🏠</span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-section-title">Seller Options</li>
            
            <li class="nav-item {{ request()->routeIs('seller.transfer*') ? 'active' : '' }}">
                <a href="{{ route('seller.transfer') }}">
                    <span class="nav-icon">🪙</span>
                    <span class="nav-text">Transfer Coins</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('seller.transactions*') ? 'active' : '' }}">
                <a href="{{ route('seller.transactions') }}">
                    <span class="nav-icon">📊</span>
                    <span class="nav-text">Transactions</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('seller.distributions*') ? 'active' : '' }}">
                <a href="{{ route('seller.distributions') }}">
                    <span class="nav-icon">📅</span>
                    <span class="nav-text">Distribution History</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('seller.profile*') ? 'active' : '' }}">
                <a href="{{ route('seller.profile') }}">
                    <span class="nav-icon">👤</span>
                    <span class="nav-text">My Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" onclick="event.preventDefault(); document.getElementById('seller-logout-form').submit();">
                    <span class="nav-icon">🚪</span>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quiz Battle - Seller Console')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Link to global assets CSS stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @stack('styles')
</head>
<body>
    <div class="dashboard-wrapper">
        @include('seller.common.sidebar')

        <!-- Main Content Area -->
        <main class="main-content">
            @include('seller.common.header')

            <!-- Page-specific content panel -->
            <div class="admin-page-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Hidden Logout Form -->
    <form id="seller-logout-form" action="{{ route('seller.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Side Toaster Notification -->
    @include('admin.common.toaster')

    <!-- Layout interactions scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Profile dropdown toggle
            const profileWrapper = document.getElementById('profile-dropdown-wrapper');
            const avatarBtn = document.getElementById('profile-avatar-btn');
            const dropdownMenu = document.getElementById('profile-dropdown-menu');

            if (avatarBtn && dropdownMenu) {
                avatarBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('active');
                });

                document.addEventListener('click', function (e) {
                    if (profileWrapper && !profileWrapper.contains(e.target)) {
                        dropdownMenu.classList.remove('active');
                    }
                });
            }

            // Sidebar collapse toggle
            const toggleBtn = document.getElementById('sidebar-toggle-btn');
            const mainContent = document.querySelector('.main-content');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                    const sidebarEl = document.querySelector('.sidebar');
                    if (sidebarEl && mainContent) {
                        sidebarEl.classList.toggle('collapsed');
                        mainContent.classList.toggle('expanded');

                        // Toggle collapse arrow direction
                        const arrowSpan = toggleBtn.querySelector('span');
                        if (arrowSpan) {
                            arrowSpan.textContent = sidebarEl.classList.contains('collapsed') ? '→' : '←';
                        }
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

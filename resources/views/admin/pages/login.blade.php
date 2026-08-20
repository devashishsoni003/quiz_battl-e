<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Battle - Admin Sign in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; overflow-x: hidden;">

    <div class="auth-page-container">
        
        <!-- Left Side: Hero Section with 3D Illustration (1:1 Screenshot 1) -->
        <div class="auth-left-hero">
            
            <!-- Top Bar: Logo & Secure Access Badge -->
            <div class="auth-hero-header">
                <a href="{{ url('/') }}" class="auth-hero-brand">
                    <div class="auth-brand-icon">
                       
                    </div>
                    <span class="auth-brand-name"></span>
                </a>

                <div class="auth-secure-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                    <span>Secure access</span>
                </div>
            </div>

            <!-- Center: 3D Animated Illustration -->
            <div class="auth-hero-center">
                <img src="{{ asset('assets/images/admin-auth-illustration.svg') }}" alt="Admin Auth Illustration" class="auth-illustration-img">
            </div>

            <!-- Bottom: Title & Subtitle -->
            <div class="auth-hero-footer">
                <h1 class="auth-hero-title">Run your recognition<br>platform with confidence.</h1>
                <p class="auth-hero-subtitle">A focused gateway for secure operations, team access, and critical business workflows.</p>
            </div>
        </div>

        <!-- Right Side: Login Form (1:1 Screenshot 1) -->
        <div class="auth-right-form">
            <div class="auth-form-card">

                <!-- Logout Flash Alert (Screenshot 1 green notice) -->
                @if (session('toast_success') || session('success') || session('status'))
                    <div class="auth-logout-alert">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>{{ session('toast_success') ?? (session('success') ?? session('status')) }}</span>
                    </div>
                @endif

                <!-- Purple Lock Icon -->
                <div class="auth-lock-icon-box">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>

                <!-- Titles -->
                <h2 class="auth-form-title">Welcome back</h2>
                <p class="auth-form-subtitle">Enter your admin credentials to access the panel.</p>

                <!-- Form -->
                <form action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf

                    <!-- Email Address -->
                    <div class="auth-input-group">
                        <label class="auth-input-label" for="email">Email Address <span class="req">*</span></label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            <input type="email" name="email" id="email" class="auth-input-field" value="{{ old('email') }}" placeholder="admin@example.com" required autocomplete="email" autofocus>
                        </div>
                        @error('email')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="auth-input-group">
                        <label class="auth-input-label" for="password">Password <span class="req">*</span></label>
                        <div class="auth-input-wrapper">
                            <span class="auth-input-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input type="password" name="password" id="password" class="auth-input-field with-toggle" placeholder="Enter your password" required autocomplete="current-password">
                            <button type="button" class="auth-password-toggle" id="password-toggle-eye" title="Toggle password visibility">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember me & Forgot Password -->
                    <div class="auth-remember-row">
                        <label class="auth-checkbox-label" for="remember">
                            <input type="checkbox" name="remember" id="remember" class="auth-checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="auth-forgot-link">Forgot password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-auth-submit">Sign In</button>

                    <!-- Demo Credentials Quick Fill -->
                    <div class="auth-demo-badge">
                        <span><strong>Demo:</strong> superadmin@gmail.com</span>
                        <button type="button" class="btn-quick-fill" id="btn-use-credentials">Auto Fill</button>
                    </div>
                </form>

            </div>

            <!-- Footer Copyright -->
            <div class="auth-footer-copyright">
                © {{ date('Y') }} Admin Panel. All rights reserved.
            </div>
        </div>

    </div>

    <!-- Script to handle password toggle & demo autofill -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const useCredsBtn = document.getElementById('btn-use-credentials');
            const passwordEye = document.getElementById('password-toggle-eye');

            // Quick Fill demo credentials
            if (useCredsBtn) {
                useCredsBtn.addEventListener('click', function () {
                    emailInput.value = 'superadmin@gmail.com';
                    passwordInput.value = '12345678';
                });
            }

            // Toggle password visibility
            if (passwordEye) {
                let isShown = false;
                passwordEye.addEventListener('click', function () {
                    isShown = !isShown;
                    passwordInput.setAttribute('type', isShown ? 'text' : 'password');
                    passwordEye.innerHTML = isShown 
                        ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`
                        : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
                });
            }
        });
    </script>
</body>
</html>

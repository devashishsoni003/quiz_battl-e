<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizora - Admin Sign in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="login-body">

    <div class="login-card">
        <div class="login-header">
            <div class="login-header-logo-container">
                <img src="{{ asset('assets/images/quiz-battle.png') }}" alt="Quiz Battle Logo" class="login-logo-img">
            </div>

        </div>

        <!-- Demo Credentials Banner -->
        <div class="demo-banner">
            <div class="demo-banner-left">
                <div class="demo-title">DEMO CREDENTIALS</div>
                <div class="demo-credentials">
                    <span class="role">Admin</span>
                    <span class="email">superadmin@gmail.com</span>
                    <span class="pass">••••••••</span>
                </div>
            </div>
            <button type="button" class="btn-demo-use" id="btn-use-credentials">Use →</button>
        </div>

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="email">Email address<span class="req">*</span></label>
                <div class="input-container">
                    <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" placeholder="Enter email address" required>
                </div>
                @error('email')
                    <div class="validation-error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label" for="password">Password<span class="req">*</span></label>
                <div class="input-container">
                    <input type="password" name="password" id="password" class="form-input" placeholder="Enter password" required>
                    <span class="password-toggle-icon" id="password-toggle-eye">👁</span>
                </div>
                @error('password')
                    <div class="validation-error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember me -->
            <div class="remember-me-container">
                <input type="checkbox" name="remember" id="remember" class="custom-checkbox" {{ old('remember') ? 'checked' : '' }}>
                <label class="remember-me-label" for="remember">Remember me</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-login-submit">Sign in</button>
        </form>
    </div>

    <!-- Script to handle dynamic fills and password visibility toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const useCredsBtn = document.getElementById('btn-use-credentials');
            const passwordEye = document.getElementById('password-toggle-eye');

            // Set up demo credentials insertion
            if (useCredsBtn) {
                useCredsBtn.addEventListener('click', function () {
                    emailInput.value = 'superadmin@gmail.com';
                    passwordInput.value = '12345678';
                });
            }

            // Toggle password visibility
            if (passwordEye) {
                passwordEye.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    passwordEye.textContent = type === 'password' ? '👁' : '👁‍🗨';
                });
            }
        });
    </script>
    @include('admin.common.toaster')
</body>
</html>

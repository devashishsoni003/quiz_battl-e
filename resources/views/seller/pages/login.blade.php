<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizora - Seller Sign in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <style>
        .hidden {
            display: none !important;
        }
        .demo-banner {
            background-color: #1e1b2e;
            border: 1px solid #ff9800;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 15px;
            color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .demo-title {
            font-size: 0.75rem;
            color: #ff9800;
            font-weight: bold;
        }
        .demo-credentials {
            font-size: 0.85rem;
        }
        .btn-demo-use {
            background-color: #ff9800;
            border: none;
            color: #121019;
            padding: 4px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>
<body class="login-body">

    <div class="login-card">
        <div class="login-header">
            <div class="login-header-logo-container">
                <img src="{{ asset('assets/images/quiz-battle.png') }}" alt="Quiz Battle Logo" class="login-logo-img">
            </div>
            <h2 style="color: #ffffff; text-align: center; margin-top: 1rem; font-family: 'Outfit', sans-serif;">Seller Login</h2>
        </div>

        <!-- Demo Credentials Banner -->
        <div class="demo-banner">
            <div>
                <div class="demo-title">DEMO SELLER</div>
                <div class="demo-credentials">
                    <span>Mobile: <strong>1234567890</strong></span> | <span>OTP: <strong>1234</strong></span>
                </div>
            </div>
            <button type="button" class="btn-demo-use" id="btn-use-demo">Use →</button>
        </div>

        <div id="alert-container" style="margin-bottom: 1rem; border-radius: 4px; padding: 10px; font-size: 0.9rem;" class="hidden"></div>

        <form id="login-form">
            @csrf

            <!-- Mobile Number -->
            <div class="form-group" id="mobile-group">
                <label class="form-label" for="mobile_number">Mobile Number<span class="req">*</span></label>
                <div class="input-container">
                    <input type="text" name="mobile_number" id="mobile_number" class="form-input" placeholder="Enter 10 digit mobile number" required pattern="\d{10}">
                </div>
                <div class="validation-error-message hidden" id="mobile-error"></div>
            </div>

            <!-- Send OTP Button -->
            <button type="button" class="btn-login-submit" id="btn-send-otp">Send OTP</button>

            <!-- OTP Input Group -->
            <div class="form-group hidden" id="otp-group" style="margin-top: 1.5rem;">
                <label class="form-label" for="otp">Enter OTP<span class="req">*</span></label>
                <div class="input-container">
                    <input type="text" name="otp" id="otp" class="form-input" placeholder="Enter 4-digit OTP" pattern="\d{4}">
                </div>
                <div class="validation-error-message hidden" id="otp-error"></div>
            </div>

            <!-- Verify OTP Button -->
            <button type="button" class="btn-login-submit hidden" id="btn-verify-otp" style="margin-top: 1rem;">Verify & Login</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileInput = document.getElementById('mobile_number');
            const otpInput = document.getElementById('otp');
            const useDemoBtn = document.getElementById('btn-use-demo');
            
            const btnSendOtp = document.getElementById('btn-send-otp');
            const btnVerifyOtp = document.getElementById('btn-verify-otp');
            
            const mobileGroup = document.getElementById('mobile-group');
            const otpGroup = document.getElementById('otp-group');
            
            const alertContainer = document.getElementById('alert-container');
            const mobileError = document.getElementById('mobile-error');
            const otpError = document.getElementById('otp-error');

            function showAlert(message, type = 'error') {
                alertContainer.textContent = message;
                alertContainer.className = '';
                if (type === 'error') {
                    alertContainer.style.backgroundColor = '#fca5a5';
                    alertContainer.style.color = '#7f1d1d';
                } else {
                    alertContainer.style.backgroundColor = '#86efac';
                    alertContainer.style.color = '#14532d';
                }
            }

            function hideAlert() {
                alertContainer.className = 'hidden';
            }

            // Click Use Demo Credentials
            if (useDemoBtn) {
                useDemoBtn.addEventListener('click', function () {
                    mobileInput.value = '1234567890';
                    otpInput.value = '1234';
                });
            }

            // Send OTP Action
            btnSendOtp.addEventListener('click', function () {
                hideAlert();
                mobileError.textContent = '';
                mobileError.classList.add('hidden');

                const mobile = mobileInput.value.trim();
                if (!/^\d{10}$/.test(mobile)) {
                    mobileError.textContent = 'Please enter a valid 10-digit mobile number.';
                    mobileError.classList.remove('hidden');
                    return;
                }

                btnSendOtp.disabled = true;
                btnSendOtp.textContent = 'Sending...';

                fetch('{{ route('seller.send-otp') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ mobile_number: mobile })
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    if (res.status === 200) {
                        showAlert('OTP sent successfully. Please check your messages.', 'success');
                        
                        // Show OTP field and Verify button
                        otpGroup.classList.remove('hidden');
                        btnVerifyOtp.classList.remove('hidden');
                        
                        // Disable mobile number editing
                        mobileInput.readOnly = true;

                        // Rename button
                        btnSendOtp.textContent = 'Resend OTP';
                        btnSendOtp.style.opacity = '0.7';
                        
                        // Enable after 30 seconds
                        setTimeout(() => {
                            btnSendOtp.disabled = false;
                            btnSendOtp.style.opacity = '1';
                        }, 30000);
                    } else {
                        btnSendOtp.disabled = false;
                        btnSendOtp.textContent = 'Send OTP';
                        
                        const msg = res.body.message || 'Failed to send OTP. Please try again.';
                        showAlert(msg, 'error');

                        if (res.body.errors && res.body.errors.mobile_number) {
                            mobileError.textContent = res.body.errors.mobile_number[0];
                            mobileError.classList.remove('hidden');
                        }
                    }
                })
                .catch(err => {
                    btnSendOtp.disabled = false;
                    btnSendOtp.textContent = 'Send OTP';
                    showAlert('An error occurred. Please try again.', 'error');
                });
            });

            // Verify OTP Action
            btnVerifyOtp.addEventListener('click', function () {
                hideAlert();
                otpError.textContent = '';
                otpError.classList.add('hidden');

                const mobile = mobileInput.value.trim();
                const otp = otpInput.value.trim();

                if (!otp) {
                    otpError.textContent = 'Please enter the OTP.';
                    otpError.classList.remove('hidden');
                    return;
                }

                btnVerifyOtp.disabled = true;
                btnVerifyOtp.textContent = 'Verifying...';

                fetch('{{ route('seller.verify-otp') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ mobile_number: mobile, otp: otp })
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    if (res.status === 200) {
                        showAlert('Login successful! Redirecting...', 'success');
                        window.location.href = res.body.redirect;
                    } else {
                        btnVerifyOtp.disabled = false;
                        btnVerifyOtp.textContent = 'Verify & Login';
                        
                        const msg = res.body.message || 'Invalid OTP. Please try again.';
                        showAlert(msg, 'error');

                        if (res.body.errors && res.body.errors.otp) {
                            otpError.textContent = res.body.errors.otp[0];
                            otpError.classList.remove('hidden');
                        }
                    }
                })
                .catch(err => {
                    btnVerifyOtp.disabled = false;
                    btnVerifyOtp.textContent = 'Verify & Login';
                    showAlert('An error occurred. Please try again.', 'error');
                });
            });
        });
    </script>
    @include('admin.common.toaster')
</body>
</html>

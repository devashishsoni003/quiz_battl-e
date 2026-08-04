@if (session('toast_success') || session('success'))
    @php
        $msg = session('toast_success') ?? session('success');
    @endphp
    <div class="toast-container" id="toast-container">
        <div class="toast" id="common-toast">
            <span class="toast-icon">✓</span>
            <span class="toast-content">{{ $msg }}</span>
            <span class="toast-close" id="toast-close-btn">&times;</span>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('common-toast');
            const closeBtn = document.getElementById('toast-close-btn');
            let dismissTimeout;

            function dismissToast() {
                if (toast) {
                    toast.classList.add('fade-out');
                    setTimeout(function () {
                        const container = document.getElementById('toast-container');
                        if (container) {
                            container.remove();
                        }
                    }, 300);
                }
            }

            // Auto dismiss after 4 seconds
            dismissTimeout = setTimeout(dismissToast, 4000);

            // Manual dismiss on click
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    clearTimeout(dismissTimeout);
                    dismissToast();
                });
            }
        });
    </script>
@endif

@if (session('toast_error') || session('error'))
    @php
        $msg = session('toast_error') ?? session('error');
    @endphp
    <div class="toast-container" id="toast-container">
        <div class="toast" id="common-toast-error" style="border-left-color: var(--accent-danger, #ff2a74);">
            <span class="toast-icon" style="color: var(--accent-danger, #ff2a74);">✕</span>
            <span class="toast-content">{{ $msg }}</span>
            <span class="toast-close" id="toast-close-error-btn">&times;</span>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('common-toast-error');
            const closeBtn = document.getElementById('toast-close-error-btn');
            let dismissTimeout;

            function dismissToast() {
                if (toast) {
                    toast.classList.add('fade-out');
                    setTimeout(function () {
                        const container = document.getElementById('toast-container');
                        if (container) {
                            container.remove();
                        }
                    }, 300);
                }
            }

            // Auto dismiss after 4 seconds
            dismissTimeout = setTimeout(dismissToast, 4000);

            // Manual dismiss on click
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    clearTimeout(dismissTimeout);
                    dismissToast();
                });
            }
        });
    </script>
@endif

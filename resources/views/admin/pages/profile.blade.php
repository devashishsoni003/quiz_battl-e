@extends('admin.layouts.index')

@section('title', 'Quiz Battle - Edit Profile')

@section('content')
<!-- Cheerly Style Breadcrumb & Title (Screenshot 5) -->
<div class="cheerly-breadcrumbs">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span>/</span>
    <span class="active">Profile</span>
</div>

<div class="page-title-section" style="margin-bottom: 2rem;">
    <h1 class="page-main-heading">Edit Profile</h1>
</div>

<div class="profile-page-grid">
    <!-- Left Column: Profile Information Card (Screenshot 5) -->
    <div class="profile-card-cheerly">
        <div class="card-header-icon-title">
            <div class="header-icon-box">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div>
                <h2 class="card-header-title">Profile Information</h2>
                <p class="card-header-desc">Update your personal details and avatar.</p>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                <!-- First Name -->
                <div class="form-group-cheerly" style="margin-bottom: 0;">
                    <label class="form-label-cheerly" for="first_name">First Name<span class="req">*</span></label>
                    <input type="text" name="first_name" id="first_name" class="form-input-cheerly" value="{{ old('first_name', $user->first_name) }}" placeholder="Enter first name" required>
                    @error('first_name')
                        <div class="validation-error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="form-group-cheerly" style="margin-bottom: 0;">
                    <label class="form-label-cheerly" for="last_name">Last Name<span class="req">*</span></label>
                    <input type="text" name="last_name" id="last_name" class="form-input-cheerly" value="{{ old('last_name', $user->last_name) }}" placeholder="Enter last name" required>
                    @error('last_name')
                        <div class="validation-error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div class="form-group-cheerly">
                <label class="form-label-cheerly" for="email">Email<span class="req">*</span></label>
                <input type="email" name="email" id="email" class="form-input-cheerly" value="{{ old('email', $user->email) }}" placeholder="Enter email address" required>
                @error('email')
                    <div class="validation-error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone / Contact Number -->
            <div class="form-group-cheerly">
                <label class="form-label-cheerly" for="contact_number">Phone</label>
                <input type="text" name="contact_number" id="contact_number" class="form-input-cheerly" value="{{ old('contact_number', $user->contact_number) }}" placeholder="Enter phone number">
                @error('contact_number')
                    <div class="validation-error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- WhatsApp Number (Hidden / Secondary if present) -->
            <div class="form-group-cheerly">
                <label class="form-label-cheerly" for="whatsapp_number">WhatsApp Number</label>
                <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-input-cheerly" value="{{ old('whatsapp_number', $user->whatsapp_number) }}" placeholder="Enter WhatsApp number">
                @error('whatsapp_number')
                    <div class="validation-error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Gender & Image Removal State -->
            <input type="hidden" name="gender" value="{{ old('gender', $user->gender ?? 'male') }}">
            <input type="hidden" name="remove_image" id="remove-image-input" value="0">

            <!-- Avatar Drag & Drop Upload Zone (Screenshot 5) -->
            <div class="form-group-cheerly" style="margin-top: 1.5rem;">
                <label class="form-label-cheerly">Avatar</label>
                
                <input type="file" name="image" id="avatar-file-input" style="display: none;" accept="image/*">
                
                <div class="avatar-dropzone-cheerly" id="avatar-drop-zone">
                    <div id="avatar-preview-wrapper" style="{{ $user->image ? '' : 'display: none;' }}; margin-bottom: 1rem;">
                        <div class="avatar-preview-box">
                            <img src="{{ $user->image_url }}" alt="Avatar Preview" id="avatar-preview-img" class="avatar-preview-img-circle">
                            <button type="button" class="avatar-remove-badge" id="avatar-remove-btn" title="Remove">&times;</button>
                        </div>
                    </div>

                    <div id="avatar-placeholder-wrapper" style="{{ $user->image ? 'display: none;' : '' }}">
                        <div class="dropzone-cloud-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 16l-4-4-4 4M12 12v9"></path>
                                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path>
                                <polyline points="16 16 12 12 8 16"></polyline>
                            </svg>
                        </div>
                        <div class="dropzone-main-text">
                            Drag & drop files here or <span class="browse-link">browse</span>
                        </div>
                        <div class="dropzone-sub-text">Accepted file types: image/*</div>
                    </div>
                </div>
                @error('image')
                    <div class="validation-error-message" style="margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Save Changes Button -->
            <div style="margin-top: 1.75rem;">
                <button type="submit" class="btn-primary-cheerly">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- Right Column: Security & Authentication Cards (Screenshot 5) -->
    <div>
        <!-- Two-Factor Authentication Card -->
        <div class="profile-card-cheerly">
            <div class="card-header-icon-title">
                <div class="header-icon-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="card-header-title">Two-Factor Authentication</h2>
                    <p class="card-header-desc">Add an extra layer of security to your account.</p>
                </div>
            </div>

            <div class="cheerly-alert-box">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #6b7280; flex-shrink: 0;">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <span>Two-factor authentication is not enabled.</span>
            </div>

            <button type="button" class="btn-primary-cheerly" style="display: flex; align-items: center; gap: 0.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                <span>Enable Two-Factor Authentication</span>
            </button>
        </div>

        <!-- Active Sessions Card -->
        <div class="profile-card-cheerly">
            <div class="card-header-icon-title">
                <div class="header-icon-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <div>
                    <h2 class="card-header-title">Active Sessions</h2>
                    <p class="card-header-desc">Manage and revoke your active sessions on other browsers and devices.</p>
                </div>
            </div>

            <div class="empty-sessions-text">
                No active sessions found.
            </div>
        </div>

        <!-- Change Password Card (Screenshot 5) -->
        <div class="profile-card-cheerly">
            <div class="card-header-icon-title">
                <div class="header-icon-box">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="7.5" cy="15.5" r="5.5"></circle>
                        <path d="M21 2l-9.6 9.6"></path>
                        <path d="M15.5 7.5l3 3L22 7l-3-3"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="card-header-title">Change Password</h2>
                    <p class="card-header-desc">Ensure your account is using a secure password.</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.change_password') }}" method="POST">
                @csrf
                
                <!-- Old Password -->
                <div class="form-group-cheerly">
                    <label class="form-label-cheerly" for="old_password">Old Password<span class="req">*</span></label>
                    <input type="password" name="old_password" id="old_password" class="form-input-cheerly" placeholder="Enter Old Password" required>
                    @error('old_password')
                        <div class="validation-error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="form-group-cheerly">
                    <label class="form-label-cheerly" for="new_password">New Password<span class="req">*</span></label>
                    <input type="password" name="new_password" id="new_password" class="form-input-cheerly" placeholder="Enter New Password" required>
                    @error('new_password')
                        <div class="validation-error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group-cheerly">
                    <label class="form-label-cheerly" for="confirm_password">Confirm New Password<span class="req">*</span></label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-input-cheerly" placeholder="Enter confirm password" required>
                    @error('confirm_password')
                        <div class="validation-error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 1.5rem;">
                    <button type="submit" class="btn-primary-cheerly">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropZone = document.getElementById('avatar-drop-zone');
        const fileInput = document.getElementById('avatar-file-input');
        const previewContainer = document.getElementById('avatar-preview-wrapper');
        const previewImg = document.getElementById('avatar-preview-img');
        const removeBtn = document.getElementById('avatar-remove-btn');
        const placeholderText = document.getElementById('avatar-placeholder-wrapper');

        if (dropZone && fileInput) {
            // Trigger file selector on dropzone click
            dropZone.addEventListener('click', function (e) {
                if (e.target.closest('#avatar-remove-btn')) return;
                fileInput.click();
            });

            // Handle file input change
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const removeInput = document.getElementById('remove-image-input');
                    if (removeInput) removeInput.value = '0';

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        previewContainer.style.display = 'block';
                        placeholderText.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle remove avatar button
            if (removeBtn) {
                removeBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const removeInput = document.getElementById('remove-image-input');
                    if (removeInput) removeInput.value = '1';

                    fileInput.value = '';
                    previewImg.src = '';
                    previewContainer.style.display = 'none';
                    placeholderText.style.display = 'block';
                });
            }

            // Drag and drop handlers
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.style.borderColor = '#7c3aed';
                    dropZone.style.backgroundColor = '#f3e8ff';
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.style.borderColor = '#d1d5db';
                    dropZone.style.backgroundColor = '#fafafa';
                });
            });

            dropZone.addEventListener('drop', function (e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files.length > 0) {
                    fileInput.files = files;
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            });
        }
    });
</script>
@endpush

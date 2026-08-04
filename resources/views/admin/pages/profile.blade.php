@extends('admin.layouts.index')

@section('title', 'Quiz Battle - Admin Profile Settings')

@section('content')
<!-- Breadcrumbs -->
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / <span style="color: #ffffff; font-weight: 600;">Profile</span>
    </span>
</div>

<div class="profile-layout-container">
    @php
        $activeTab = session('active_tab') === 'password' || $errors->has('old_password') || $errors->has('new_password') || $errors->has('confirm_password') ? 'password' : 'personal';
    @endphp

    <!-- Left Tab Sidebar -->
    <div class="profile-tabs-sidebar">
        <button type="button" class="profile-tab-btn {{ $activeTab === 'personal' ? 'active' : '' }}" id="tab-btn-personal">
            <span>👤</span> Personal Information
        </button>
        <button type="button" class="profile-tab-btn {{ $activeTab === 'password' ? 'active' : '' }}" id="tab-btn-password">
            <span>🔑</span> Change Password
        </button>
    </div>

    <!-- Right Content Card -->
    <div class="profile-content-card">
        
        <!-- Tab 1: Personal Information Card -->
        <div class="profile-tab-content {{ $activeTab === 'personal' ? '' : 'tab-hidden' }}" id="tab-content-personal">
            <div class="profile-card-header">
                <span class="header-icon">👤</span>
                <h2>Personal Information</h2>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div style="display: flex; gap: 2.5rem; align-items: flex-start;">
                    <!-- Left: Form inputs (65%) -->
                    <div style="flex: 0 0 65%;">
                        <div class="form-row-2">
                            <!-- First Name -->
                            <div class="form-group-custom">
                                <label class="form-label" for="first_name">First Name<span class="req">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-input" value="{{ old('first_name', $user->first_name) }}" required>
                                @error('first_name')
                                    <div class="validation-error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="form-group-custom">
                                <label class="form-label" for="last_name">Last Name<span class="req">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-input" value="{{ old('last_name', $user->last_name) }}" required>
                                @error('last_name')
                                    <div class="validation-error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row-2">
                            <!-- Email -->
                            <div class="form-group-custom">
                                <label class="form-label" for="email">Email<span class="req">*</span></label>
                                <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="validation-error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Number -->
                            <div class="form-group-custom">
                                <label class="form-label" for="contact_number">Contact Number<span class="req">*</span></label>
                                <div class="contact-input-wrapper">
                                    <div class="contact-flag-prefix">
                                        <span class="flag">🇺🇸</span>
                                        <span>+1</span>
                                    </div>
                                    <input type="text" name="contact_number" id="contact_number" class="form-input form-input-with-prefix" value="{{ old('contact_number', $user->contact_number) }}" required>
                                </div>
                                @error('contact_number')
                                    <div class="validation-error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Gender Selector -->
                        <div class="form-group-custom">
                            <label class="form-label">Gender</label>
                            <div class="gender-selection-container">
                                @php
                                    $currentGender = old('gender', $user->gender ?? 'male');
                                @endphp
                                <label class="gender-box-option {{ $currentGender === 'male' ? 'active-option' : '' }}" id="gender-label-male">
                                    <input type="radio" name="gender" value="male" class="gender-radio" {{ $currentGender === 'male' ? 'checked' : '' }}>
                                    <span class="radio-dot"></span>
                                    <span>Male</span>
                                </label>
                                
                                <label class="gender-box-option {{ $currentGender === 'female' ? 'active-option' : '' }}" id="gender-label-female">
                                    <input type="radio" name="gender" value="female" class="gender-radio" {{ $currentGender === 'female' ? 'checked' : '' }}>
                                    <span class="radio-dot"></span>
                                    <span>Female</span>
                                </label>

                                <label class="gender-box-option {{ $currentGender === 'other' ? 'active-option' : '' }}" id="gender-label-other">
                                    <input type="radio" name="gender" value="other" class="gender-radio" {{ $currentGender === 'other' ? 'checked' : '' }}>
                                    <span class="radio-dot"></span>
                                    <span>Other</span>
                                </label>
                            </div>
                            @error('gender')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Right: Dashed Profile Image Upload Zone (35%) -->
                    <div style="flex: 0 0 35%; display: flex; justify-content: center; align-items: center; padding-top: 1.8rem;">
                        <div class="avatar-upload-container">
                            <div class="avatar-upload-box" id="avatar-drop-zone">
                                <input type="file" name="image" id="avatar-file-input" style="display: none;" accept="image/*">
                                
                                <div class="avatar-preview-wrapper" id="avatar-preview-container" style="{{ $user->image ? '' : 'display: none;' }}">
                                    <img src="{{ $user->image_url }}" alt="Avatar Preview" id="avatar-preview-img">
                                    <button type="button" class="avatar-remove-btn" id="avatar-remove-btn">&times;</button>
                                </div>
                                
                                <div class="avatar-placeholder" id="avatar-placeholder-text" style="{{ $user->image ? 'display: none;' : '' }}">
                                    <span class="upload-icon">📁</span>
                                    <span>Click to upload avatar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-submit-container">
                    <button type="submit" class="btn-profile-save">Save</button>
                </div>
            </form>
        </div>

        <!-- Tab 2: Change Password Card -->
        <div class="profile-tab-content {{ $activeTab === 'password' ? '' : 'tab-hidden' }}" id="tab-content-password">
            <div class="profile-card-header">
                <span class="header-icon">🔑</span>
                <h2>Change Password</h2>
            </div>

            <form action="{{ route('admin.profile.change_password') }}" method="POST">
                @csrf
                
                <!-- Old Password -->
                <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                    <label class="form-label" for="old_password">Old Password</label>
                    <input type="password" name="old_password" id="old_password" class="form-input" placeholder="Enter Old Password" required>
                    @error('old_password')
                        <div class="validation-error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                    <label class="form-label" for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-input" placeholder="Enter New Password" required>
                    @error('new_password')
                        <div class="validation-error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                    <label class="form-label" for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-input" placeholder="Enter confirm password" required>
                    @error('confirm_password')
                        <div class="validation-error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="form-submit-container">
                    <button type="submit" class="btn-profile-save" style="background-color: #a81c2f;">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<style>
    .tab-hidden {
        display: none !important;
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tab switching logic
        const tabBtnPersonal = document.getElementById('tab-btn-personal');
        const tabBtnPassword = document.getElementById('tab-btn-password');
        
        const tabContentPersonal = document.getElementById('tab-content-personal');
        const tabContentPassword = document.getElementById('tab-content-password');

        if (tabBtnPersonal && tabBtnPassword) {
            tabBtnPersonal.addEventListener('click', function () {
                tabBtnPersonal.classList.add('active');
                tabBtnPassword.classList.remove('active');
                
                tabContentPersonal.classList.remove('tab-hidden');
                tabContentPassword.classList.add('tab-hidden');
            });

            tabBtnPassword.addEventListener('click', function () {
                tabBtnPassword.classList.add('active');
                tabBtnPersonal.classList.remove('active');
                
                tabContentPassword.classList.remove('tab-hidden');
                tabContentPersonal.classList.add('tab-hidden');
            });
        }

        // Gender selector cards click visual highlight toggle
        const genderRadios = document.querySelectorAll('.gender-radio');
        genderRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                // Clear active states
                document.getElementById('gender-label-male').classList.remove('active-option');
                document.getElementById('gender-label-female').classList.remove('active-option');
                document.getElementById('gender-label-other').classList.remove('active-option');

                // Set current active
                const label = document.getElementById('gender-label-' + this.value);
                if (label) {
                    label.classList.add('active-option');
                }
            });
        });

        // Image upload and instant preview zone trigger logic
        const dropZone = document.getElementById('avatar-drop-zone');
        const fileInput = document.getElementById('avatar-file-input');
        const previewContainer = document.getElementById('avatar-preview-container');
        const previewImg = document.getElementById('avatar-preview-img');
        const removeBtn = document.getElementById('avatar-remove-btn');
        const placeholderText = document.getElementById('avatar-placeholder-text');

        if (dropZone && fileInput) {
            // Trigger selector on card click
            dropZone.addEventListener('click', function (e) {
                // Prevent trigger if clicking close button
                if (e.target.closest('#avatar-remove-btn')) return;
                fileInput.click();
            });

            // Handle file change
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        previewContainer.style.display = 'block';
                        placeholderText.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Handle remove button
            if (removeBtn) {
                removeBtn.addEventListener('click', function (e) {
                    e.stopPropagation(); // Prevent opening selector dialog
                    fileInput.value = ''; // Clear input selection
                    previewImg.src = '';
                    previewContainer.style.display = 'none';
                    placeholderText.style.display = 'flex';
                });
            }
        }
    });
</script>
@endpush

@extends('admin.layouts.index')

@section('title', 'Referral Settings')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">Referral Settings</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        <div class="profile-card-header">
            <span class="header-icon">⚙️</span>
            <h2>Referral Settings</h2>
        </div>

        <form action="{{ route('admin.referral-settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div style="display: flex; gap: 2.5rem; align-items: flex-start; flex-wrap: wrap;">
                <!-- Left: Form inputs -->
                <div style="flex: 1 1 60%;">

                    <div class="form-row-2">
                        <!-- Title -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="title">Title<span class="req">*</span></label>
                            <input type="text" name="title" id="title" class="form-input" value="{{ old('title', $settings->title) }}" required maxlength="255">
                            @error('title')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="status">Status<span class="req">*</span></label>
                            <select name="status" id="status" class="form-input" required style="background-color: #1e1b2e; color: #ffffff;">
                                <option value="1" {{ old('status', $settings->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $settings->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="description">Description</label>
                        <textarea name="description" id="description" class="form-input" rows="3">{{ old('description', $settings->description) }}</textarea>
                        @error('description')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row-2">
                        <!-- Reward Per Referral -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="reward_per_referral">Reward Per Referral (Coins)<span class="req">*</span></label>
                            <input type="number" name="reward_per_referral" id="reward_per_referral" class="form-input" value="{{ old('reward_per_referral', $settings->reward_per_referral) }}" required min="0">
                            @error('reward_per_referral')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New User Bonus -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="new_user_bonus">New User Bonus (Coins)<span class="req">*</span></label>
                            <input type="number" name="new_user_bonus" id="new_user_bonus" class="form-input" value="{{ old('new_user_bonus', $settings->new_user_bonus) }}" required min="0">
                            @error('new_user_bonus')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 2rem; margin-bottom: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 1.5rem;">
                        <h4 style="color: #ffffff; margin-bottom: 1rem;">Sharing Configuration</h4>
                    </div>

                    <!-- Share Title -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="share_title">Share Title</label>
                        <input type="text" name="share_title" id="share_title" class="form-input" value="{{ old('share_title', $settings->share_title) }}" maxlength="255">
                        @error('share_title')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Share Message -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="share_message">Share Message</label>
                        <textarea name="share_message" id="share_message" class="form-input" rows="3">{{ old('share_message', $settings->share_message) }}</textarea>
                        @error('share_message')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Share Link -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="share_link">Share Link (Optional custom URL)</label>
                        <input type="text" name="share_link" id="share_link" class="form-input" value="{{ old('share_link', $settings->share_link) }}" maxlength="255">
                        @error('share_link')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- Right: Image Upload -->
                <div style="flex: 0 0 35%; display: flex; flex-direction: column; align-items: center;">
                    <label class="form-label" style="width: 100%; margin-bottom: 1rem;">Banner Image (Max 2MB)</label>
                    <div class="avatar-upload-container" style="width: 100%;">
                        <div class="avatar-upload-box" id="avatar-drop-zone" style="width: 100%; aspect-ratio: 16/9; border-radius: 8px;">
                            <input type="file" name="banner_image" id="avatar-file-input" style="display: none;" accept="image/jpeg,image/png,image/jpg,image/webp">
                            
                            @php $hasImage = $settings->banner_image; @endphp
                            <div class="avatar-preview-wrapper" id="avatar-preview-container" style="{{ $hasImage ? '' : 'display: none;' }} width: 100%; height: 100%;">
                                <img src="{{ $hasImage ? $settings->banner_url : '' }}" alt="Banner Preview" id="avatar-preview-img" style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
                                <button type="button" class="avatar-remove-btn" id="avatar-remove-btn">&times;</button>
                            </div>
                            
                            <div class="avatar-placeholder" id="avatar-placeholder-text" style="{{ $hasImage ? 'display: none;' : '' }}">
                                <span class="upload-icon">📁</span>
                                <span>Click to upload image</span>
                            </div>
                        </div>
                    </div>
                    @error('banner_image')
                        <div class="validation-error-message" style="margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-submit-container" style="margin-top: 2rem;">
                <button type="submit" class="btn-profile-save">Update Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Image upload and instant preview zone trigger logic
        const dropZone = document.getElementById('avatar-drop-zone');
        const fileInput = document.getElementById('avatar-file-input');
        const previewContainer = document.getElementById('avatar-preview-container');
        const previewImg = document.getElementById('avatar-preview-img');
        const removeBtn = document.getElementById('avatar-remove-btn');
        const placeholderText = document.getElementById('avatar-placeholder-text');

        if (dropZone && fileInput) {
            dropZone.addEventListener('click', function (e) {
                if (e.target.closest('#avatar-remove-btn')) return;
                fileInput.click();
            });

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

            if (removeBtn) {
                removeBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    fileInput.value = '';
                    previewImg.src = '';
                    previewContainer.style.display = 'none';
                    placeholderText.style.display = 'flex';
                });
            }
        }
    });
</script>
@endpush

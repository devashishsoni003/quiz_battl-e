@extends('seller.layouts.index')

@section('title', 'Seller Profile Management')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('seller.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <span style="color: #ffffff; font-weight: 600;">My Profile</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        <div class="profile-card-header">
            <span class="header-icon">👤</span>
            <h2>My Profile & Store Details</h2>
        </div>

        @if(session('success'))
            <div style="background-color: #86efac; color: #14532d; padding: 10px; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display: flex; gap: 2.5rem; align-items: flex-start; flex-wrap: wrap;">
                <!-- Left: Form inputs -->
                <div style="flex: 1 1 60%;">
                    
                    <!-- Mobile Number (Read-only) -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="mobile_number">Mobile Number</label>
                        <input type="text" id="mobile_number" class="form-input" value="{{ $seller->mobile_number }}" readonly style="opacity: 0.7; background-color: #1e1b2e;">
                    </div>

                    <!-- Name -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="name">Name<span class="req">*</span></label>
                        <input type="text" name="name" id="name" class="form-input" value="{{ old('name', $seller->name) }}" required maxlength="255">
                        @error('name')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row-2">
                        <!-- WhatsApp Number -->
                        <div class="form-group-custom">
                            <label class="form-label" for="whatsapp_number">WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-input" value="{{ old('whatsapp_number', $seller->whatsapp_number) }}">
                            @error('whatsapp_number')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password (Optional) -->
                        <div class="form-group-custom">
                            <label class="form-label" for="password">Password (Optional)</label>
                            <input type="password" name="password" id="password" class="form-input" placeholder="Leave blank to keep current">
                            @error('password')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <!-- Right: Image Upload -->
                <div style="flex: 0 0 35%; display: flex; flex-direction: column; align-items: center;">
                    <label class="form-label" style="width: 100%; margin-bottom: 1rem;">Profile/Store Image (Max 2MB)</label>
                    <div class="avatar-upload-container" style="width: 100%;">
                        <div class="avatar-upload-box" id="avatar-drop-zone" style="width: 100%; aspect-ratio: 1/1; border-radius: 8px;">
                            <input type="file" name="image" id="avatar-file-input" style="display: none;" accept="image/jpeg,image/png,image/jpg,image/webp">
                            
                            @php $hasImage = $seller->image; @endphp
                            <div class="avatar-preview-wrapper" id="avatar-preview-container" style="{{ $hasImage ? '' : 'display: none;' }} width: 100%; height: 100%;">
                                <img src="{{ $hasImage ? $seller->image_url : '' }}" alt="Seller Preview" id="avatar-preview-img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                <button type="button" class="avatar-remove-btn" id="avatar-remove-btn">&times;</button>
                            </div>
                            
                            <div class="avatar-placeholder" id="avatar-placeholder-text" style="{{ $hasImage ? 'display: none;' : '' }}">
                                <span class="upload-icon">📁</span>
                                <span>Click to upload image</span>
                            </div>
                        </div>
                    </div>
                    @error('image')
                        <div class="validation-error-message" style="margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-submit-container" style="margin-top: 2rem;">
                <button type="submit" class="btn-profile-save">Save Changes</button>
                <a href="{{ route('seller.dashboard') }}" class="btn-profile-save" style="background-color: #4b5563; margin-left: 1rem; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
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

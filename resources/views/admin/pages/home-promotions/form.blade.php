@extends('admin.layouts.index')

@section('title', isset($promotion) ? 'Edit Home Promotion' : 'Add Home Promotion')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <a href="{{ route('admin.home-promotions.index') }}" style="color: #8e89a5; text-decoration: none;">Home Promotions</a> / 
        <span style="color: #ffffff; font-weight: 600;">{{ isset($promotion) ? 'Edit' : 'Add' }} Promotion</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        <div class="profile-card-header">
            <span class="header-icon">📢</span>
            <h2>{{ isset($promotion) ? 'Edit Home Promotion' : 'Add Home Promotion' }}</h2>
        </div>

        <form action="{{ isset($promotion) ? route('admin.home-promotions.update', $promotion->id) : route('admin.home-promotions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($promotion))
                @method('PUT')
            @endif
            
            <div style="display: flex; gap: 2.5rem; align-items: flex-start; flex-wrap: wrap;">
                <!-- Left: Form inputs -->
                <div style="flex: 1 1 60%;">
                    
                    <!-- Title -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="title">Title<span class="req">*</span></label>
                        <input type="text" name="title" id="title" class="form-input" value="{{ old('title', $promotion->title ?? '') }}" required>
                        @error('title')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="description">Description</label>
                        <textarea name="description" id="description" class="form-input" rows="4" style="resize: vertical; padding: 1rem;">{{ old('description', $promotion->description ?? '') }}</textarea>
                        @error('description')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row-2">
                        <!-- Button Text -->
                        <div class="form-group-custom">
                            <label class="form-label" for="button_text">Button Text<span class="req">*</span></label>
                            <input type="text" name="button_text" id="button_text" class="form-input" value="{{ old('button_text', $promotion->button_text ?? '') }}" required>
                            @error('button_text')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Link Type -->
                        <div class="form-group-custom">
                            <label class="form-label" for="link_type">Link Type<span class="req">*</span></label>
                            <select name="link_type" id="link_type" class="form-input" required style="background-color: #1e1b2e; color: #ffffff;">
                                @php $currentType = old('link_type', $promotion->link_type ?? 'none'); @endphp
                                <option value="none" {{ $currentType == 'none' ? 'selected' : '' }}>None</option>
                                <option value="quiz" {{ $currentType == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                <option value="category" {{ $currentType == 'category' ? 'selected' : '' }}>Category</option>
                                <option value="url" {{ $currentType == 'url' ? 'selected' : '' }}>URL</option>
                            </select>
                            @error('link_type')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row-2">
                        <!-- Link Value -->
                        <div class="form-group-custom">
                            <label class="form-label" for="link_value">Link Value</label>
                            <input type="text" name="link_value" id="link_value" class="form-input" value="{{ old('link_value', $promotion->link_value ?? '') }}" placeholder="ID or URL">
                            @error('link_value')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sorting -->
                        <div class="form-group-custom">
                            <label class="form-label" for="sorting">Sorting<span class="req">*</span></label>
                            <input type="number" name="sorting" id="sorting" class="form-input" value="{{ old('sorting', $promotion->sorting ?? 0) }}" required>
                            @error('sorting')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-group-custom">
                        <label class="form-label" for="status">Status<span class="req">*</span></label>
                        <select name="status" id="status" class="form-input" required style="background-color: #1e1b2e; color: #ffffff;">
                            @php $currentStatus = old('status', isset($promotion) ? $promotion->status : 1); @endphp
                            <option value="1" {{ $currentStatus == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $currentStatus == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- Right: Image Upload -->
                <div style="flex: 0 0 35%; display: flex; flex-direction: column; align-items: center; gap: 1.5rem;">
                    
                    <!-- Image 1 -->
                    <div style="width: 100%;">
                        <label class="form-label" style="width: 100%; margin-bottom: 1rem;">Promotion Image 1<span class="req">*</span> (Max 2MB)</label>
                        <div class="avatar-upload-container" style="width: 100%;">
                            <div class="avatar-upload-box" id="avatar-drop-zone" style="width: 100%; aspect-ratio: 1/1; border-radius: 8px;">
                                <input type="file" name="image" id="avatar-file-input" style="display: none;" accept="image/jpeg,image/png,image/jpg,image/webp">
                                
                                @php $hasImage = isset($promotion) && $promotion->image; @endphp
                                <div class="avatar-preview-wrapper" id="avatar-preview-container" style="{{ $hasImage ? '' : 'display: none;' }} width: 100%; height: 100%;">
                                    <img src="{{ $hasImage ? $promotion->image_url : '' }}" alt="Promo Preview" id="avatar-preview-img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                    <button type="button" class="avatar-remove-btn" id="avatar-remove-btn">&times;</button>
                                </div>
                                
                                <div class="avatar-placeholder" id="avatar-placeholder-text" style="{{ $hasImage ? 'display: none;' : '' }}">
                                    <span class="upload-icon">📁</span>
                                    <span>Click to upload image 1</span>
                                </div>
                            </div>
                        </div>
                        @error('image')
                            <div class="validation-error-message" style="margin-top: 0.5rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image 2 -->
                    <div style="width: 100%;">
                        <label class="form-label" style="width: 100%; margin-bottom: 1rem;">Promotion Image 2 (Optional, Max 2MB)</label>
                        <div class="avatar-upload-container" style="width: 100%;">
                            <div class="avatar-upload-box" id="avatar-drop-zone-2" style="width: 100%; aspect-ratio: 1/1; border-radius: 8px;">
                                <input type="file" name="image_2" id="avatar-file-input-2" style="display: none;" accept="image/jpeg,image/png,image/jpg,image/webp">
                                
                                @php $hasImage2 = isset($promotion) && $promotion->image_2; @endphp
                                <div class="avatar-preview-wrapper" id="avatar-preview-container-2" style="{{ $hasImage2 ? '' : 'display: none;' }} width: 100%; height: 100%;">
                                    <img src="{{ $hasImage2 ? $promotion->image_2_url : '' }}" alt="Promo Preview 2" id="avatar-preview-img-2" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                    <button type="button" class="avatar-remove-btn" id="avatar-remove-btn-2">&times;</button>
                                </div>
                                
                                <div class="avatar-placeholder" id="avatar-placeholder-text-2" style="{{ $hasImage2 ? 'display: none;' : '' }}">
                                    <span class="upload-icon">📁</span>
                                    <span>Click to upload image 2</span>
                                </div>
                            </div>
                        </div>
                        @error('image_2')
                            <div class="validation-error-message" style="margin-top: 0.5rem;">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-submit-container" style="margin-top: 2rem;">
                <button type="submit" class="btn-profile-save">Save Promotion</button>
                <a href="{{ route('admin.home-promotions.index') }}" class="btn-profile-save" style="background-color: #4b5563; margin-left: 1rem; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Image 1 upload and instant preview zone trigger logic
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

        // Image 2 upload and instant preview zone trigger logic
        const dropZone2 = document.getElementById('avatar-drop-zone-2');
        const fileInput2 = document.getElementById('avatar-file-input-2');
        const previewContainer2 = document.getElementById('avatar-preview-container-2');
        const previewImg2 = document.getElementById('avatar-preview-img-2');
        const removeBtn2 = document.getElementById('avatar-remove-btn-2');
        const placeholderText2 = document.getElementById('avatar-placeholder-text-2');

        if (dropZone2 && fileInput2) {
            dropZone2.addEventListener('click', function (e) {
                if (e.target.closest('#avatar-remove-btn-2')) return;
                fileInput2.click();
            });

            fileInput2.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg2.src = e.target.result;
                        previewContainer2.style.display = 'block';
                        placeholderText2.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                }
            });

            if (removeBtn2) {
                removeBtn2.addEventListener('click', function (e) {
                    e.stopPropagation();
                    fileInput2.value = '';
                    previewImg2.src = '';
                    previewContainer2.style.display = 'none';
                    placeholderText2.style.display = 'flex';
                });
            }
        }
    });
</script>
@endpush

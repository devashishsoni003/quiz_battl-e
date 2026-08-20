@extends('admin.layouts.index')

@section('title', isset($faq) ? 'Edit FAQ' : 'Add FAQ')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <a href="{{ route('admin.faqs.index') }}" style="color: #8e89a5; text-decoration: none;">FAQs</a> / 
        <span style="color: #ffffff; font-weight: 600;">{{ isset($faq) ? 'Edit' : 'Add' }} FAQ</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        <div class="profile-card-header">
            <span class="header-icon">❓</span>
            <h2>{{ isset($faq) ? 'Edit FAQ' : 'Add FAQ' }}</h2>
        </div>

        <form action="{{ isset($faq) ? route('admin.faqs.update', $faq->id) : route('admin.faqs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($faq))
                @method('PUT')
            @endif
            
            <div style="display: flex; gap: 2.5rem; align-items: flex-start; flex-wrap: wrap;">
                <!-- Left: Form inputs -->
                <div style="flex: 1 1 60%;">
                    
                    <!-- Question -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="question">Question<span class="req">*</span></label>
                        <input type="text" name="question" id="question" class="form-input" value="{{ old('question', $faq->question ?? '') }}" required placeholder="Enter the FAQ question">
                        @error('question')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Answer -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="answer">Answer<span class="req">*</span></label>
                        <textarea name="answer" id="answer" class="form-input" rows="8" required placeholder="Enter the FAQ answer">{{ old('answer', $faq->answer ?? '') }}</textarea>
                        @error('answer')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row-2">
                        <!-- Sorting -->
                        <div class="form-group-custom">
                            <label class="form-label" for="sorting">Sorting</label>
                            <input type="number" name="sorting" id="sorting" class="form-input" value="{{ old('sorting', $faq->sorting ?? 0) }}" placeholder="e.g. 1">
                            @error('sorting')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group-custom">
                            <label class="form-label" for="status">Status<span class="req">*</span></label>
                            <select name="status" id="status" class="form-input" required style="background-color: #1e1b2e; color: #ffffff;">
                                @php $currentStatus = old('status', isset($faq) ? ($faq->status ? 1 : 0) : 1); @endphp
                                <option value="1" {{ $currentStatus == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $currentStatus == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <!-- Right: Icon Image Upload -->
                <div style="flex: 0 0 35%; display: flex; flex-direction: column; align-items: center;">
                    <label class="form-label" style="width: 100%; margin-bottom: 1rem;">FAQ Icon Image (Max 2MB)</label>
                    <div class="avatar-upload-container" style="width: 100%;">
                        <div class="avatar-upload-box" id="avatar-drop-zone" style="width: 100%; aspect-ratio: 1/1; border-radius: 8px;">
                            <input type="file" name="icon" id="avatar-file-input" style="display: none;" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">
                            
                            @php $hasImage = isset($faq) && $faq->icon; @endphp
                            <div class="avatar-preview-wrapper" id="avatar-preview-container" style="{{ $hasImage ? '' : 'display: none;' }} width: 100%; height: 100%;">
                                <img src="{{ $hasImage ? $faq->icon_url : '' }}" alt="Icon Preview" id="avatar-preview-img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                <button type="button" class="avatar-remove-btn" id="avatar-remove-btn">&times;</button>
                            </div>
                            
                            <div class="avatar-placeholder" id="avatar-placeholder-text" style="{{ $hasImage ? 'display: none;' : '' }}">
                                <div class="dropzone-cloud-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                    </div>
                    @error('icon')
                        <div class="validation-error-message" style="margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-submit-container" style="margin-top: 2rem;">
                <button type="submit" class="btn-profile-save">{{ isset($faq) ? 'Update' : 'Save' }}</button>
                <a href="{{ route('admin.faqs.index') }}" class="btn-profile-save" style="background-color: #4b5563; margin-left: 1rem; text-decoration: none;">Cancel</a>
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

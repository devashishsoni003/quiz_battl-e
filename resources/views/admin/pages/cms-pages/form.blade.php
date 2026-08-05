@extends('admin.layouts.index')

@section('title', isset($page) ? 'Edit Page' : 'Add Page')

@section('content')
<div class="profile-breadcrumbs" style="margin-bottom: 2rem;">
    <span style="color: #8e89a5; font-size: 0.88rem; font-weight: 500;">
        <a href="{{ route('admin.dashboard') }}" style="color: #8e89a5; text-decoration: none;">Dashboard</a> / 
        <a href="{{ route('admin.pages.index') }}" style="color: #8e89a5; text-decoration: none;">CMS Pages</a> / 
        <span style="color: #ffffff; font-weight: 600;">{{ isset($page) ? 'Edit' : 'Add' }} Page</span>
    </span>
</div>

<div class="profile-layout-container">
    <div class="profile-content-card" style="width: 100%;">
        <div class="profile-card-header">
            <span class="header-icon">📄</span>
            <h2>{{ isset($page) ? 'Edit Page' : 'Add Page' }}</h2>
        </div>

        <form action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}" method="POST">
            @csrf
            @if(isset($page))
                @method('PUT')
            @endif
            
            <div style="display: flex; gap: 2.5rem; align-items: flex-start; flex-wrap: wrap;">
                <!-- Full Width Content -->
                <div style="flex: 1 1 100%;">
                    
                    <div class="form-row-2">
                        <!-- Title -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="title">Title<span class="req">*</span></label>
                            <input type="text" name="title" id="title" class="form-input" value="{{ old('title', $page->title ?? '') }}" required maxlength="255">
                            @error('title')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="slug">Slug<span class="req">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-input" value="{{ old('slug', $page->slug ?? '') }}" required maxlength="255">
                            <small style="color: #6b7280; font-size: 0.8rem; margin-top: 0.25rem; display: block;">Unique identifier for the URL.</small>
                            @error('slug')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Content (Rich Text) -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="content">Content<span class="req">*</span></label>
                        <!-- CKEditor uses this textarea -->
                        <textarea name="content" id="content" class="form-input" style="display: none;">{{ old('content', $page->content ?? '') }}</textarea>
                        @error('content')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row-2">
                        <!-- Meta Title -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="meta_title">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-input" value="{{ old('meta_title', $page->meta_title ?? '') }}" maxlength="255">
                            @error('meta_title')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                            <label class="form-label" for="status">Status<span class="req">*</span></label>
                            <select name="status" id="status" class="form-input" required style="background-color: #1e1b2e; color: #ffffff;">
                                @php $currentStatus = old('status', isset($page) ? $page->status : 1); @endphp
                                <option value="1" {{ $currentStatus == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $currentStatus == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="validation-error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Meta Description -->
                    <div class="form-group-custom" style="margin-bottom: 1.5rem;">
                        <label class="form-label" for="meta_description">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-input" rows="3">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                        @error('meta_description')
                            <div class="validation-error-message">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-submit-container" style="margin-top: 1rem;">
                <button type="submit" class="btn-profile-save">{{ isset($page) ? 'Update' : 'Save' }}</button>
                <a href="{{ route('admin.pages.index') }}" class="btn-profile-save" style="background-color: #4b5563; margin-left: 1rem; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor 5 Classic Build -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<style>
    /* Styling to make CKEditor match dark theme */
    .ck-editor__editable_inline {
        min-height: 300px;
        background-color: #1c1a26 !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    .ck.ck-editor__main>.ck-editor__editable {
        background: #1c1a26 !important;
    }
    .ck.ck-toolbar {
        background: #12111a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-bottom: none !important;
    }
    .ck.ck-icon, .ck.ck-button__label {
        color: #d1d5db !important;
    }
    .ck.ck-button:hover, .ck.ck-button.ck-on {
        background: #374151 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });

        // Auto-slug generation logic (only for create mode)
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        const isEditMode = {{ isset($page) ? 'true' : 'false' }};

        if (titleInput && slugInput && !isEditMode) {
            titleInput.addEventListener('input', function () {
                let title = this.value;
                let slug = title.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove invalid chars
                    .replace(/\s+/g, '-')         // Replace spaces with -
                    .replace(/-+/g, '-');         // Collapse dashes
                
                slugInput.value = slug;
            });
        }
    });
</script>
@endpush

@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Hero Section</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">CMS</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.hero.index') }}">Hero Section</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="card">
    <article class="card-header">
        <h3 class="card-title">Form Edit Hero Section</h3>
        <div class="card-tools">
            <a href="{{ route('admin.cms.hero.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </article>
    <article class="card-body">
        <form action="{{ route('admin.cms.hero.update', $hero->id) }}" method="POST" enctype="multipart/form-data" id="heroForm">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Title -->
                    <div class="form-group">
                        <label for="title">Judul <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $hero->title) }}" 
                               placeholder="Masukkan judul hero section..."
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Title 2 -->
                    <div class="form-group">
                        <label for="title2">Judul 2 (Opsional)</label>
                        <input type="text" 
                               class="form-control @error('title2') is-invalid @enderror" 
                               id="title2" 
                               name="title2" 
                               value="{{ old('title2', $hero->title2) }}" 
                               placeholder="Masukkan judul kedua hero section...">
                        @error('title2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Judul kedua akan ditampilkan dengan warna biru</small>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Masukkan deskripsi hero section..."
                                  required>{{ old('description', $hero->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Status -->
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $hero->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                        <small class="text-muted">Centang untuk mengaktifkan hero section</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Image 1 -->
                    <div class="form-group">
                        <label for="image1">Gambar 1</label>
                        
                        @if($hero->image1)
                            <div class="mb-2">
                                <p class="text-muted mb-1">Gambar saat ini:</p>
                                <img src="{{ $hero->image1_url }}" alt="Current Image 1" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                            </div>
                        @endif
                        
                        <div class="custom-file">
                            <input type="file" 
                                   class="custom-file-input @error('image1') is-invalid @enderror" 
                                   id="image1" 
                                   name="image1" 
                                   accept="image/*">
                            <label class="custom-file-label" for="image1">{{ $hero->image1 ? 'Ganti gambar...' : 'Pilih gambar...' }}</label>
                        </div>
                        @error('image1')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPEG, PNG, JPG, GIF, WEBP. Maksimal 2MB</small>
                        
                        <!-- Image Preview -->
                        <div id="image1-preview" class="mt-2" style="display: none;">
                            <p class="text-muted mb-1">Preview gambar baru:</p>
                            <img id="image1-preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Image 2 -->
                    <div class="form-group">
                        <label for="image2">Gambar 2</label>
                        
                        @if($hero->image2)
                            <div class="mb-2">
                                <p class="text-muted mb-1">Gambar saat ini:</p>
                                <img src="{{ $hero->image2_url }}" alt="Current Image 2" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                            </div>
                        @endif
                        
                        <div class="custom-file">
                            <input type="file" 
                                   class="custom-file-input @error('image2') is-invalid @enderror" 
                                   id="image2" 
                                   name="image2" 
                                   accept="image/*">
                            <label class="custom-file-label" for="image2">{{ $hero->image2 ? 'Ganti gambar...' : 'Pilih gambar...' }}</label>
                        </div>
                        @error('image2')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPEG, PNG, JPG, GIF, WEBP. Maksimal 2MB</small>
                        
                        <!-- Image Preview -->
                        <div id="image2-preview" class="mt-2" style="display: none;">
                            <p class="text-muted mb-1">Preview gambar baru:</p>
                            <img id="image2-preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i> Update Hero Section
                </button>
                <a href="{{ route('admin.cms.hero.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </article>
</section>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Image file input change handlers
        $('#image1').on('change', function() {
            previewImage(this, '#image1-preview', '#image1-preview-img');
            updateFileName(this, 'image1');
        });

        $('#image2').on('change', function() {
            previewImage(this, '#image2-preview', '#image2-preview-img');
            updateFileName(this, 'image2');
        });

        // Form validation
        $('#heroForm').on('submit', function(e) {
            let isValid = true;
            let firstError = null;

            // Validate title
            if ($('#title').val().trim() === '') {
                showFieldError('#title', 'Judul wajib diisi');
                isValid = false;
                if (!firstError) firstError = '#title';
            }

            // Validate description
            if ($('#description').val().trim() === '') {
                showFieldError('#description', 'Deskripsi wajib diisi');
                isValid = false;
                if (!firstError) firstError = '#description';
            }

            if (!isValid) {
                e.preventDefault();
                if (firstError) {
                    $(firstError).focus();
                }
                return false;
            }

            // Show loading state
            $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memperbarui...');
        });
    });

    function previewImage(input, previewContainer, previewImg) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                $(previewImg).attr('src', e.target.result);
                $(previewContainer).show();
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            $(previewContainer).hide();
        }
    }

    function updateFileName(input, fieldName) {
        const fileName = input.files[0] ? input.files[0].name : 'Pilih gambar...';
        $(`label[for="${fieldName}"]`).text(fileName);
    }

    function showFieldError(fieldSelector, message) {
        $(fieldSelector).addClass('is-invalid');
        
        // Remove existing error message
        $(fieldSelector).siblings('.invalid-feedback').remove();
        
        // Add new error message
        $(fieldSelector).after(`<div class="invalid-feedback">${message}</div>`);
    }

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush

@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah CTA Section</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.cta-section.index') }}">CTA Section</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah CTA Section</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms.cta-section.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
            <form action="{{ route('admin.cms.cta-section.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   placeholder="Masukkan judul CTA section"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Background Image -->
                        <div class="form-group">
                            <label for="background_image" class="form-label">Background Image</label>
                            <input type="file" 
                                   class="form-control-file @error('background_image') is-invalid @enderror" 
                                   id="background_image" 
                                   name="background_image" 
                                   accept="image/*"
                                   onchange="previewImage(event)">
                            <small class="form-text text-muted">
                                Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.
                            </small>
                            @error('background_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Preview -->
                        <div class="form-group">
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Status -->
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Aktif</label>
                            </div>
                            <small class="form-text text-muted">
                                CTA section yang aktif akan ditampilkan di website.
                            </small>
                        </div>

                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan CTA Section
                    </button>
                    <a href="{{ route('admin.cms.cta-section.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Image Preview Function
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}

// Form Validation
$(document).ready(function() {
    $('form').on('submit', function(e) {
        let isValid = true;
        
        // Validate title
        const title = $('#title').val().trim();
        if (title === '') {
            isValid = false;
            $('#title').addClass('is-invalid');
            if (!$('#title').next('.invalid-feedback').length) {
                $('#title').after('<div class="invalid-feedback">Title wajib diisi</div>');
            }
        } else {
            $('#title').removeClass('is-invalid');
            $('#title').next('.invalid-feedback').remove();
        }
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                title: 'Error!',
                text: 'Mohon lengkapi form yang required',
                icon: 'error'
            });
        }
    });
    
    // Real-time validation
    $('#title').on('blur', function() {
        const value = $(this).val().trim();
        if (value === '') {
            $(this).addClass('is-invalid');
            if (!$(this).next('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">Title wajib diisi</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });
});
</script>
@endpush
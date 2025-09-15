@extends('layouts.admin.app')

@section('title', 'Edit Video Section')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Video Section</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">CMS</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.cms.video-section.index') }}">Video Section</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Video Section</h3>
                    </div>
                    <form action="{{ route('admin.cms.video-section.update', $videoSection->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $videoSection->title) }}" 
                                       placeholder="Masukkan title video section"
                                       required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="subtitle">Subtitle</label>
                                <textarea class="form-control @error('subtitle') is-invalid @enderror" 
                                          id="subtitle" 
                                          name="subtitle" 
                                          rows="3" 
                                          placeholder="Masukkan subtitle video section (opsional)">{{ old('subtitle', $videoSection->subtitle) }}</textarea>
                                @error('subtitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="background_image">Background Image</label>
                                
                                @if($videoSection->background_image_url)
                                    <div class="mb-2">
                                        <label class="form-label">Gambar Saat Ini:</label><br>
                                        <img src="{{ $videoSection->background_image_url }}" 
                                             alt="Current Background" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px;">
                                    </div>
                                @endif
                                
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input @error('background_image') is-invalid @enderror" 
                                               id="background_image" 
                                               name="background_image"
                                               accept="image/*">
                                        <label class="custom-file-label" for="background_image">
                                            {{ $videoSection->background_image ? 'Ganti gambar' : 'Pilih file gambar' }}
                                        </label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, GIF. Maksimal ukuran: 2MB. Kosongkan jika tidak ingin mengubah gambar.
                                </small>
                                @error('background_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                <!-- Image Preview -->
                                <div class="mt-2" id="image-preview" style="display: none;">
                                    <label class="form-label">Preview Gambar Baru:</label><br>
                                    <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1" 
                                           {{ old('is_active', $videoSection->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Aktifkan Video Section</label>
                                </div>
                                <small class="form-text text-muted">
                                    Centang untuk mengaktifkan video section ini di homepage
                                </small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('admin.cms.video-section.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Video Section</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td>{{ $videoSection->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge {{ $videoSection->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $videoSection->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat:</strong></td>
                                <td>{{ $videoSection->formatted_created_at }}</td>
                            </tr>
                            <tr>
                                <td><strong>Diupdate:</strong></td>
                                <td>{{ $videoSection->formatted_updated_at }}</td>
                            </tr>
                            @if($videoSection->activated_at)
                            <tr>
                                <td><strong>Diaktifkan:</strong></td>
                                <td>{{ $videoSection->formatted_activated_at }}</td>
                            </tr>
                            @endif
                        </table>
                        
                        <hr>
                        
                        <h5>Petunjuk Penggunaan:</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-info-circle text-info"></i> <strong>Title:</strong> Judul utama yang akan ditampilkan di section video</li>
                            <li><i class="fas fa-info-circle text-info"></i> <strong>Subtitle:</strong> Deskripsi pendukung di bawah title (opsional)</li>
                            <li><i class="fas fa-info-circle text-info"></i> <strong>Background Image:</strong> Gambar latar belakang untuk section video (opsional)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="{{ asset('back_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Initialize file input
    bsCustomFileInput.init();
    
    // Image preview functionality
    $('#background_image').change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-img').attr('src', e.target.result);
                $('#image-preview').show();
            }
            reader.readAsDataURL(file);
        } else {
            $('#image-preview').hide();
        }
    });
});
</script>
@endpush
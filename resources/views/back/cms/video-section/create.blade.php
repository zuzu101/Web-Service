@extends('layouts.admin.app')

@section('title', 'Tambah Video Section')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Video Section</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">CMS</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.cms.video-section.index') }}">Video Section</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Video Section</h3>
                    </div>
                    <form action="{{ route('admin.cms.video-section.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
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
                                          placeholder="Masukkan subtitle video section (opsional)">{{ old('subtitle') }}</textarea>
                                @error('subtitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="background_image">Background Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input @error('background_image') is-invalid @enderror" 
                                               id="background_image" 
                                               name="background_image"
                                               accept="image/*">
                                        <label class="custom-file-label" for="background_image">Pilih file gambar</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">
                                    Format: JPG, JPEG, PNG, GIF. Maksimal ukuran: 2MB
                                </small>
                                @error('background_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                <!-- Image Preview -->
                                <div class="mt-2" id="image-preview" style="display: none;">
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
                                           {{ old('is_active') ? 'checked' : 'checked' }}>
                                    <label class="custom-control-label" for="is_active">Aktifkan Video Section</label>
                                </div>
                                <small class="form-text text-muted">
                                    Centang untuk mengaktifkan video section ini di homepage
                                </small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
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
                        <h3 class="card-title">Informasi</h3>
                    </div>
                    <div class="card-body">
                        <h5>Petunjuk Penggunaan:</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-info-circle text-info"></i> <strong>Title:</strong> Judul utama yang akan ditampilkan di section video</li>
                            <li><i class="fas fa-info-circle text-info"></i> <strong>Subtitle:</strong> Deskripsi pendukung di bawah title (opsional)</li>
                            <li><i class="fas fa-info-circle text-info"></i> <strong>Background Image:</strong> Gambar latar belakang untuk section video (opsional)</li>
                            <li><i class="fas fa-info-circle text-info"></i> <strong>Status Aktif:</strong> Menentukan apakah section ini ditampilkan di homepage</li>
                        </ul>
                        
                        <hr>
                        
                        <h5>Contoh Title yang Baik:</h5>
                        <ul class="list-unstyled text-muted">
                            <li>• "Lihat Proses Pengerjaan Teknisi Kami"</li>
                            <li>• "Video Tutorial Service Laptop"</li>
                            <li>• "Dokumentasi Proses Perbaikan"</li>
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
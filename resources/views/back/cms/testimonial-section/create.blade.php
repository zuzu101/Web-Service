@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Buat Section Testimoni</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.testimonial.index') }}">Kelola Testimoni</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.testimonial-section.index') }}">Pengaturan Section</a></li>
                <li class="breadcrumb-item active">Buat Section</li>
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
                    <h3 class="card-title">Buat Section Testimoni Baru</h3>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('admin.cms.testimonial-section.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="title">Judul Section</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', 'Apa Kata Pelanggan Kami?') }}" 
                                   placeholder="Contoh: Apa Kata Pelanggan Kami?" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subtitle">Subtitle (Opsional)</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" 
                                   value="{{ old('subtitle') }}" 
                                   placeholder="Subtitle section">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="background_image">Background Image (Opsional)</label>
                            <input type="file" name="background_image" id="background_image" class="form-control-file @error('background_image') is-invalid @enderror" accept="image/*">
                            @error('background_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</small>
                            
                            <div id="imagePreview" style="display: none;" class="mt-2">
                                <img id="preview" src="#" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 100px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktifkan Section
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Section
                            </button>
                            <a href="{{ route('admin.cms.testimonial-section.index') }}" class="btn btn-secondary">
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
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // Image preview
    document.getElementById('background_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imagePreview').style.display = 'none';
        }
    });
</script>
@endpush
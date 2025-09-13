@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Pengaturan Section Keunggulan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.advantage.index') }}">Kelola Keunggulan</a></li>
                <li class="breadcrumb-item active">Pengaturan Section</li>
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
                    <h3 class="card-title">Pengaturan Section Keunggulan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms.advantage.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali ke Keunggulan
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($advantageSection)
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Informasi</h5>
                            Anda dapat mengubah judul dan background section keunggulan di halaman website.
                        </div>

                        <form action="{{ route('admin.cms.advantage-section.update', $advantageSection->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="title">Judul Section</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title', $advantageSection->title) }}" 
                                       placeholder="Contoh: Kenapa Memilih Kami?">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="background_image">Background Image (Opsional)</label>
                                <input type="file" name="background_image" id="background_image" class="form-control-file @error('background_image') is-invalid @enderror" accept="image/*">
                                @error('background_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                @if($advantageSection->background_image)
                                    <div class="mt-2">
                                        <small class="text-muted">Background saat ini:</small><br>
                                        <img src="{{ $advantageSection->background_image_url }}" alt="Background" class="img-thumbnail" style="max-width: 200px; max-height: 100px;">
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" 
                                           {{ old('is_active', $advantageSection->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Aktifkan Section
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.cms.advantage.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian</h5>
                            Belum ada pengaturan section keunggulan. Silakan buat yang baru.
                        </div>

                        <a href="{{ route('admin.cms.advantage-section.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Section Keunggulan
                        </a>
                    @endif
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
</script>
@endpush

@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Layanan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.service.index') }}">Kelola Layanan</a></li>
                <li class="breadcrumb-item active">Edit Layanan</li>
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
                    <h3 class="card-title">Edit Layanan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms.service.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.cms.service.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Judul Layanan <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $service->title) }}" 
                                           placeholder="Masukkan judul layanan" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Deskripsi Layanan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Masukkan deskripsi layanan" 
                                              required>{{ old('description', $service->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Gambar Layanan</label>
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Format: JPG, JPEG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.
                                    </small>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Gambar Saat Ini / Preview</label>
                                    <div class="text-center">
                                        @if($service->image)
                                            <img id="currentImage" 
                                                 src="{{ $service->image_url }}" 
                                                 alt="Current Image" 
                                                 class="img-thumbnail mb-2" 
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        @endif
                                        <img id="imagePreview" 
                                             src="#" 
                                             alt="Preview Image" 
                                             class="img-thumbnail" 
                                             style="width: 150px; height: 150px; object-fit: cover; display: none;">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="is_active" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('is_active') is-invalid @enderror" 
                                            id="is_active" 
                                            name="is_active" 
                                            required>
                                        <option value="">Pilih Status</option>
                                        <option value="1" {{ old('is_active', $service->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active', $service->is_active) == '0' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.cms.service.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Preview image when file is selected
    $('#image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).show();
                $('#currentImage').hide(); // Hide current image when new one is selected
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
            $('#currentImage').show(); // Show current image if no new file selected
        }
    });
});
</script>
@endpush

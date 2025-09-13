@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Keunggulan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.advantage.index') }}">Kelola Keunggulan</a></li>
                <li class="breadcrumb-item active">Edit Keunggulan</li>
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
                    <h3 class="card-title">Edit Keunggulan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms.advantage.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.cms.advantage.update', $advantage->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="title" class="form-label">Judul Keunggulan <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $advantage->title) }}" 
                                           placeholder="Masukkan judul keunggulan" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Deskripsi Keunggulan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Masukkan deskripsi keunggulan" 
                                              required>{{ old('description', $advantage->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="icon" class="form-label">Icon Keunggulan</label>
                                    <input type="file" 
                                           class="form-control @error('icon') is-invalid @enderror" 
                                           id="icon" 
                                           name="icon" 
                                           accept="image/*">
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Format: JPG, JPEG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.
                                    </small>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Icon Saat Ini / Preview</label>
                                    <div class="text-center">
                                        @if($advantage->icon)
                                            <img id="currentIcon" 
                                                 src="{{ $advantage->icon_url }}" 
                                                 alt="Current Icon" 
                                                 class="img-thumbnail mb-2" 
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        @endif
                                        <img id="iconPreview" 
                                             src="#" 
                                             alt="Preview Icon" 
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
                                        <option value="1" {{ old('is_active', $advantage->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active', $advantage->is_active) == '0' ? 'selected' : '' }}>Nonaktif</option>
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
                        <a href="{{ route('admin.cms.advantage.index') }}" class="btn btn-secondary ms-2">
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
    // Preview icon when file is selected
    $('#icon').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#iconPreview').attr('src', e.target.result).show();
                $('#currentIcon').hide(); // Hide current icon when new one is selected
            };
            reader.readAsDataURL(file);
        } else {
            $('#iconPreview').hide();
            $('#currentIcon').show(); // Show current icon if no new file selected
        }
    });
});
</script>
@endpush

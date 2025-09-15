@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Testimoni</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.testimonial.index') }}">Kelola Testimoni</a></li>
                <li class="breadcrumb-item active">Edit Testimoni</li>
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
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Edit Testimoni: {{ $testimonial->name }}</h3>
                        <a href="{{ route('admin.cms.testimonial.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.cms.testimonial.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="name" class="form-label">Nama Customer <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $testimonial->name) }}" 
                                           placeholder="Masukkan nama customer" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                                    <select class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                        <option value="">Pilih Rating</option>
                                        <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>⭐ (1 Bintang)</option>
                                        <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>⭐⭐ (2 Bintang)</option>
                                        <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Bintang)</option>
                                        <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Bintang)</option>
                                        <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                                    </select>
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="content" class="form-label">Konten Testimoni</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" 
                                              id="content" 
                                              name="content" 
                                              rows="4" 
                                              placeholder="Masukkan isi testimoni (opsional)">{{ old('content', $testimonial->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Testimoni dapat dikosongkan jika hanya ingin menampilkan nama dan foto.</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Foto Customer</label>
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</small>
                                </div>

                                @if($testimonial->image)
                                    <div class="mb-3">
                                        <label class="form-label">Foto Saat Ini:</label><br>
                                        <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                @endif

                                <div id="imagePreview" style="display: none;">
                                    <label class="form-label">Preview Foto Baru:</label><br>
                                    <img id="preview" src="#" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Aktifkan Testimoni
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Testimoni aktif akan ditampilkan di website.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Testimoni
                        </button>
                        <a href="{{ route('admin.cms.testimonial.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
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
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
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
@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Contact Info</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">CMS</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.contact-info.index') }}">Contact Info</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="card">
    <article class="card-header">
        <h3 class="card-title">Form Edit Contact Info</h3>
        <div class="card-tools">
            <a href="{{ route('admin.cms.contact-info.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </article>
    <article class="card-body">
        <form action="{{ route('admin.cms.contact-info.update', $contactInfo->id) }}" method="POST" enctype="multipart/form-data" id="contactInfoForm">
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
                               placeholder="WhatsApp, Email, Lokasi, dll"
                               value="{{ old('title', $contactInfo->title) }}"
                               autocomplete="off">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Content -->
                    <div class="form-group">
                        <label for="content">Konten <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  rows="3"
                                  placeholder="0812-3456-7890, info@example.com, Jl. Contoh No. 123"
                                  autocomplete="off">{{ old('content', $contactInfo->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Link -->
                    <div class="form-group">
                        <label for="link">Link (Opsional)</label>
                        <input type="url" 
                               class="form-control @error('link') is-invalid @enderror" 
                               id="link" 
                               name="link" 
                               placeholder="https://wa.me/6281234567890, mailto:info@example.com, https://maps.google.com/..."
                               value="{{ old('link', $contactInfo->link) }}"
                               autocomplete="off">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            URL yang akan dibuka ketika contact info diklik. Kosongkan jika tidak diperlukan.
                        </small>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- Icon -->
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <input type="file" 
                               class="form-control @error('icon') is-invalid @enderror" 
                               id="icon" 
                               name="icon" 
                               accept="image/*">
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Format: JPG, JPEG, PNG, GIF, SVG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah icon.
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Preview Icon</label>
                        <div class="text-center">
                            <img id="iconPreview" 
                                 src="{{ $contactInfo->icon_url ?? '#' }}" 
                                 alt="Preview Icon" 
                                 class="img-thumbnail" 
                                 style="width: 150px; height: 150px; object-fit: cover; {{ $contactInfo->icon_url ? '' : 'display: none;' }}">
                        </div>
                        @if($contactInfo->icon_url)
                            <div class="text-center mt-2">
                                <small class="text-muted">Icon saat ini</small>
                            </div>
                        @endif
                    </div>
                    <!-- Status -->
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select class="form-control @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', $contactInfo->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $contactInfo->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Current Order Info -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Urutan Saat Ini:</strong> {{ $contactInfo->order }}<br>
                        Gunakan fitur "Atur Urutan" untuk mengubah posisi contact info.
                    </div>
                </div>
            </div>
            
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.cms.contact-info.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </article>
</section>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Image preview functionality
        $('#icon').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#iconPreview').attr('src', e.target.result);
                    $('#iconPreview').show();
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Promo</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.promo.index') }}">Promo</a></li>
                <li class="breadcrumb-item active">Tambah Promo</li>
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
                    <h3 class="card-title">Form Tambah Promo</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms.promo.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.cms.promo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title">Judul Diskon <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title') }}" 
                                           placeholder="Contoh: Promo Maintenance Rutin Berkala">
                                    <small class="form-text text-muted">Judul utama promo yang akan ditampilkan di card.</small>
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Discount Text (Highlight) -->
                                <div class="form-group">
                                    <label for="discount_text">Highlight Diskon</label>
                                    <input type="text" 
                                           class="form-control @error('discount_text') is-invalid @enderror" 
                                           id="discount_text" 
                                           name="discount_text" 
                                           value="{{ old('discount_text') }}" 
                                           placeholder="Hemat hingga 20%">
                                    <small class="form-text text-muted">Teks highlight yang akan muncul di badge pojok kanan atas (opsional).</small>
                                    @error('discount_text')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Deskripsi Promo <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Rawat laptop Anda secara berkala dan dapatkan diskon menarik...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Button Text -->
                                <div class="form-group">
                                    <label for="button_text">Text Tombol <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('button_text') is-invalid @enderror" 
                                           id="button_text" 
                                           name="button_text" 
                                           value="{{ old('button_text', 'Jadwalkan Sekarang') }}" 
                                           placeholder="Jadwalkan Sekarang">
                                    @error('button_text')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Image -->
                                <div class="form-group">
                                    <label for="image">Gambar Promo</label>
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*">
                                        <label class="custom-file-label" for="image">Pilih gambar...</label>
                                    </div>
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
                                    @error('image')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    
                                    <!-- Image Preview -->
                                    <div id="image-preview" class="mt-2" style="display: none;">
                                        <img id="image-preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>

                                <!-- WhatsApp Template -->
                                <div class="form-group">
                                    <label for="whatsapp_template">Template Pesan WhatsApp</label>
                                    <textarea class="form-control @error('whatsapp_template') is-invalid @enderror" 
                                              id="whatsapp_template" 
                                              name="whatsapp_template" 
                                              rows="4" 
                                              placeholder="*PROMO MAINTENANCE RUTIN*

Halo, saya tertarik dengan promo maintenance rutin...">{{ old('whatsapp_template') }}</textarea>
                                    <small class="text-muted">Template pesan yang akan dikirim via WhatsApp ketika customer klik tombol.</small>
                                    @error('whatsapp_template')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Features Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Fitur Promo</h5>
                                <div id="features-container">
                                    @if(old('features'))
                                        @foreach(old('features') as $index => $feature)
                                            <div class="input-group mb-2 feature-item">
                                                <input type="text" 
                                                       class="form-control" 
                                                       name="features[]" 
                                                       value="{{ $feature }}" 
                                                       placeholder="Contoh: Pembersihan menyeluruh sistem">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger remove-feature">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="input-group mb-2 feature-item">
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="features[]" 
                                                   placeholder="Contoh: Pembersihan menyeluruh sistem">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger remove-feature">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" id="add-feature" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Tambah Fitur
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Promo
                        </button>
                        <a href="{{ route('admin.cms.promo.index') }}" class="btn btn-secondary">
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
    // Handle file input change
    $('#image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview-img').attr('src', e.target.result);
                $('#image-preview').show();
            };
            reader.readAsDataURL(file);
            
            // Update label
            const fileName = file.name;
            $(this).next('.custom-file-label').text(fileName);
        } else {
            $('#image-preview').hide();
            $(this).next('.custom-file-label').text('Pilih gambar...');
        }
    });

    // Add feature
    $('#add-feature').on('click', function() {
        const featureHtml = `
            <div class="input-group mb-2 feature-item">
                <input type="text" 
                       class="form-control" 
                       name="features[]" 
                       placeholder="Contoh: Update software terbaru">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-feature">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        $('#features-container').append(featureHtml);
    });

    // Remove feature
    $(document).on('click', '.remove-feature', function() {
        if ($('.feature-item').length > 1) {
            $(this).closest('.feature-item').remove();
        } else {
            $(this).closest('.feature-item').find('input').val('');
        }
    });
});
</script>
@endpush
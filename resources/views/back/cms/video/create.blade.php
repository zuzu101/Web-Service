@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Video</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.video.index') }}">Video</a></li>
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
                <form action="{{ route('admin.cms.video.store') }}" method="POST">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Video</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                     <label for="createVideoTitle" class="form-label">Judul Video <span class="text-danger">*</span></label>
                     <input type="text" 
                         class="form-control @error('title') is-invalid @enderror" 
                         id="createVideoTitle" 
                         name="title" 
                         value="{{ old('title') }}" 
                         placeholder="Contoh: Lihat Proses Pengerjaan Teknisi Kami"
                         required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="createVideoDescription" class="form-label">Deskripsi Video</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="createVideoDescription" 
                                              name="description" 
                                              rows="3" 
                                              placeholder="Contoh: Video menunjukkan proses service laptop secara profesional dan transparan">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                     <label for="createVideoUrl" class="form-label">URL Video YouTube <span class="text-danger">*</span></label>
                     <input type="url" 
                         class="form-control @error('video_url') is-invalid @enderror" 
                         id="createVideoUrl" 
                         name="video_url" 
                         value="{{ old('video_url') }}" 
                         placeholder="https://www.youtube.com/watch?v=VIDEO_ID atau https://youtu.be/VIDEO_ID"
                         required>
                                    @error('video_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Masukkan URL YouTube yang valid. Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ
                                    </small>
                                    
                                    <div id="videoPreview" class="mt-3" style="display: none;">
                                        <label class="form-label">Preview Video:</label>
                                        <div class="embed-responsive embed-responsive-16by9" style="max-width: 400px;">
                                            <iframe id="previewFrame" class="embed-responsive-item" src="" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input @error('is_active') is-invalid @enderror" 
                                               type="checkbox" 
                                               id="createVideoIsActive" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="createVideoIsActive">
                                            Status Aktif
                                        </label>
                                        @error('is_active')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.cms.video.index') }}" class="btn btn-secondary">
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
document.getElementById('video_url').addEventListener('input', function(e) {
    const url = e.target.value;
    const videoPreview = document.getElementById('videoPreview');
    const previewFrame = document.getElementById('previewFrame');
    
    if (url) {
        const videoId = extractYouTubeId(url);
        if (videoId) {
            const embedUrl = `https://www.youtube.com/embed/${videoId}`;
            previewFrame.src = embedUrl;
            videoPreview.style.display = 'block';
        } else {
            videoPreview.style.display = 'none';
        }
    } else {
        videoPreview.style.display = 'none';
    }
});

function extractYouTubeId(url) {
    const patterns = [
        /youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/,
        /youtube\.com\/embed\/([a-zA-Z0-9_-]+)/,
        /youtu\.be\/([a-zA-Z0-9_-]+)/
    ];
    
    for (const pattern of patterns) {
        const match = url.match(pattern);
        if (match) {
            return match[1];
        }
    }
    
    return null;
}
</script>
@endpush
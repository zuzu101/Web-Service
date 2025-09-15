@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Atur Urutan Testimoni</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.testimonial.index') }}">Kelola Testimoni</a></li>
                <li class="breadcrumb-item active">Atur Urutan</li>
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
                        <h3 class="card-title">Atur Urutan Testimoni</h3>
                        <a href="{{ route('admin.cms.testimonial.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Petunjuk</h5>
                        Drag dan drop testimoni untuk mengubah urutan tampilan di halaman website. Urutan paling atas akan ditampilkan pertama kali.
                    </div>

                    @if($testimonials->count() > 0)
                        <div id="sortable-testimonials" class="list-group">
                            @foreach($testimonials as $testimonial)
                                <div class="list-group-item" data-id="{{ $testimonial->id }}">
                                    <div class="d-flex align-items-center">
                                        <div class="drag-handle me-3">
                                            <i class="fas fa-grip-vertical text-muted"></i>
                                        </div>
                                        <div class="flex-shrink-0 me-3">
                                            @if($testimonial->image)
                                                <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $testimonial->name }}</h6>
                                            <div class="text-warning small mb-1">
                                                {!! $testimonial->stars !!}
                                            </div>
                                            @if($testimonial->content)
                                                <p class="mb-0 text-muted small">{{ str($testimonial->content)->limit(80) }}</p>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">Urutan: {{ $testimonial->order }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            <button type="button" id="save-order" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Urutan
                            </button>
                            <a href="{{ route('admin.cms.testimonial.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Tidak Ada Data</h5>
                            Belum ada testimoni untuk diurutkan. <a href="{{ route('admin.cms.testimonial.create') }}">Tambah testimoni</a> terlebih dahulu.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.css">
<style>
    .list-group-item {
        cursor: move;
        transition: all 0.2s ease;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    
    .list-group-item.sortable-ghost {
        opacity: 0.5;
        background-color: #e9ecef;
    }
    
    .drag-handle {
        cursor: grab;
    }
    
    .drag-handle:active {
        cursor: grabbing;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
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

    document.addEventListener('DOMContentLoaded', function() {
        const sortableList = document.getElementById('sortable-testimonials');
        
        if (sortableList) {
            const sortable = Sortable.create(sortableList, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost'
            });

            // Save order button click handler
            document.getElementById('save-order').addEventListener('click', function() {
                const items = sortableList.querySelectorAll('.list-group-item');
                const order = Array.from(items).map(item => item.dataset.id);
                
                // Show loading
                const btn = this;
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                
                fetch('{{ route('admin.cms.testimonial.updateOrder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order: order
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: error.message || 'Terjadi kesalahan saat menyimpan urutan',
                        timer: 3000,
                        showConfirmButton: false
                    });
                })
                .finally(() => {
                    // Restore button
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
            });
        }
    });
</script>
@endpush
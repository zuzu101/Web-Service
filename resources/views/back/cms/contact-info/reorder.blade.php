@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Atur Urutan Contact Info</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">CMS</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.contact-info.index') }}">Contact Info</a></li>
                <li class="breadcrumb-item active">Atur Urutan</li>
            </ol>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="card">
    <article class="card-header">
        <h3 class="card-title">Drag & Drop untuk Mengatur Urutan</h3>
        <div class="card-tools">
            <a href="{{ route('admin.cms.contact-info.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </article>
    <article class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            Drag dan drop item di bawah untuk mengatur urutan tampil contact info di website.
        </div>
        
        <div id="sortable-container">
            @forelse($contactInfos as $item)
                <div class="card mb-2 sortable-item" data-id="{{ $item->id }}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="fas fa-grip-vertical text-muted drag-handle" style="cursor: move;"></i>
                            </div>
                            <div class="col-auto">
                                <i class="{{ $item->icon }} fa-2x"></i>
                            </div>
                            <div class="col">
                                <h5 class="mb-1">{{ $item->title }}</h5>
                                <p class="mb-0 text-muted">{{ $item->content }}</p>
                            </div>
                            <div class="col-auto">
                                <span class="badge badge-{{ $item->is_active ? 'success' : 'secondary' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <div class="col-auto">
                                <span class="badge badge-primary">Urutan: {{ $item->order }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Belum ada contact info yang tersedia.
                </div>
            @endforelse
        </div>
        
        @if($contactInfos->count() > 0)
            <div class="mt-3">
                <button type="button" class="btn btn-primary" id="save-order">
                    <i class="fas fa-save"></i> Simpan Urutan
                </button>
            </div>
        @endif
    </article>
</section>
@endsection

@push('css')
<style>
    .sortable-item {
        transition: all 0.3s ease;
    }
    
    .sortable-item:hover {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .sortable-item.ui-sortable-helper {
        transform: rotate(5deg);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .drag-handle:hover {
        color: #007bff !important;
    }
    
    .ui-sortable-placeholder {
        border: 2px dashed #007bff;
        background: rgba(0,123,255,0.1);
        visibility: visible !important;
        height: 80px !important;
        margin-bottom: 8px;
    }
</style>
@endpush

@push('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Initialize sortable
        $('#sortable-container').sortable({
            handle: '.drag-handle',
            placeholder: 'ui-sortable-placeholder',
            tolerance: 'pointer',
            start: function(event, ui) {
                ui.item.addClass('ui-sortable-helper');
            },
            stop: function(event, ui) {
                ui.item.removeClass('ui-sortable-helper');
            }
        });

        // Save order
        $('#save-order').click(function() {
            let order = [];
            $('#sortable-container .sortable-item').each(function(index) {
                order.push({
                    id: $(this).data('id'),
                    order: index + 1
                });
            });

            Swal.fire({
                title: 'Simpan Urutan?',
                text: "Urutan contact info akan diperbarui sesuai susunan saat ini",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.cms.contact-info.updateOrder') }}",
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        data: {
                            order: order
                        },
                        beforeSend: function() {
                            $('#save-order').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                
                                // Update order badges
                                $('#sortable-container .sortable-item').each(function(index) {
                                    $(this).find('.badge-primary').text('Urutan: ' + (index + 1));
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Terjadi kesalahan saat menyimpan urutan';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            $('#save-order').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan Urutan');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
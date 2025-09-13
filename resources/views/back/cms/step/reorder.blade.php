@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Atur Urutan Steps</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.cms.step.index') }}">Steps</a></li>
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
                    <h3 class="card-title">Drag & Drop untuk Mengatur Urutan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms.step.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Petunjuk</h5>
                        Seret dan letakkan item untuk mengubah urutan. Perubahan akan disimpan secara otomatis.
                    </div>

                    <div id="sortable-list" class="list-group">
                        @foreach($steps as $step)
                            <div class="list-group-item" data-id="{{ $step->id }}">
                                <div class="row align-items-center">
                                    <div class="col-md-1">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                    </div>
                                    <div class="col-md-2">
                                        @if($step->icon)
                                            <img src="{{ $step->icon_url }}" alt="Icon" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        <h6 class="mb-1">{{ $step->title }}</h6>
                                        <p class="mb-1 text-muted">{{ \Illuminate\Support\Str::limit($step->description, 100) }}</p>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        @if($step->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Tidak Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    #sortable-list .list-group-item {
        cursor: move;
        border: 1px solid #ddd;
        margin-bottom: 5px;
        border-radius: 4px;
    }
    
    #sortable-list .list-group-item:hover {
        background-color: #f8f9fa;
    }
    
    .ui-sortable-helper {
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        transform: rotate(2deg);
    }
    
    .ui-sortable-placeholder {
        border: 2px dashed #ccc;
        visibility: visible !important;
        background: #f8f9fa;
        height: 80px;
    }
</style>
@endpush

@push('js')
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $("#sortable-list").sortable({
            handle: ".fas.fa-grip-vertical",
            placeholder: "ui-sortable-placeholder",
            helper: "clone",
            tolerance: "pointer",
            update: function(event, ui) {
                var order = [];
                $('#sortable-list .list-group-item').each(function(index) {
                    order.push($(this).data('id'));
                });
                
                $.ajax({
                    url: '{{ route('admin.cms.step.reorder') }}',
                    method: 'POST',
                    data: {
                        order: order.map((id, index) => ({
                            id: id,
                            order_number: index + 1
                        })),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengupdate urutan.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    });
</script>
@endpush

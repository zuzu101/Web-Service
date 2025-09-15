@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Kelola Contact Info</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Contact Info</li>
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
                    <h3 class="card-title">Kelola Contact Info</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms.contact-info.reorder') }}" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-sort"></i> Atur Urutan
                        </a>
                        <a href="{{ route('admin.cms.contact-info.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Contact Info
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="contactInfoTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Icon</th>
                                    <th width="15%">Judul</th>
                                    <th width="25%">Konten</th>
                                    <th width="20%">Link</th>
                                    <th width="8%">Urutan</th>
                                    <th width="10%">Status</th>
                                    <th width="7%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Google Maps Section -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Pengaturan Google Maps
                    </h3>
                </div>
                
                <div class="card-body">
                    <form id="mapsForm" class="mb-3">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="maps_embed_url" class="form-label fw-bold">Google Maps Embed URL:</label>
                                    <textarea id="maps_embed_url" 
                                              name="maps_embed_url" 
                                              class="form-control" 
                                              rows="3"
                                              placeholder="https://www.google.com/maps/embed?pb=1!1m18!1m12!1m3!1d..."
                                              style="resize: vertical;"></textarea>
                                    <small class="form-text text-muted">
                                        <strong>Cara mendapatkan embed URL:</strong><br>
                                        1. Buka <a href="https://maps.google.com" target="_blank">Google Maps</a><br>
                                        2. Cari lokasi yang diinginkan<br>
                                        3. Klik tombol "Share" atau "Bagikan"<br>
                                        4. Pilih tab "Embed a map"<br>
                                        5. Copy URL dari tag iframe src="..."
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Aksi:</label>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan URL Maps
                                        </button>
                                        <button type="button" class="btn btn-info" id="toggle-preview-btn" data-state="show">
                                            <i class="fas fa-eye"></i> Preview Maps
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Maps Preview Container -->
                    <div id="maps-preview-container" style="display: none;">
                        <hr>
                        <h5><i class="fas fa-eye mr-1"></i> Preview Maps:</h5>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" 
                                    id="maps-preview-iframe"
                                    src="" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('back_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('back_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('back_assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('back_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('back_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('back_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
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

$(function () {
    // Load current maps URL
    loadMapsUrl();

    $('#contactInfoTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.cms.contact-info.index') }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'icon_display', name: 'icon_display', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'content', name: 'content'},
            {data: 'link', name: 'link'},
            {data: 'order', name: 'order'},
            {data: 'status', name: 'is_active'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        responsive: true,
        language: {
            url: '{{ asset('back_assets/plugins/datatables/id.json') }}'
        }
    });

    // Handle maps form submission
    $('#mapsForm').on('submit', function(e) {
        e.preventDefault();
        
        const mapsUrl = $('#maps_embed_url').val().trim();
        if (!mapsUrl) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Google Maps embed URL tidak boleh kosong.',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }

        if (!mapsUrl.includes('google.com/maps/embed')) {
            Swal.fire({
                icon: 'error',
                title: 'URL Tidak Valid!',
                text: 'Pastikan URL yang dimasukkan adalah Google Maps embed URL yang valid.',
                timer: 3000,
                showConfirmButton: false
            });
            return;
        }

        // Show loading
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: '{{ route('admin.cms.contact-info.updateMaps') }}',
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'maps_embed_url': mapsUrl
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat menyimpan Google Maps URL';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage,
                    timer: 3000,
                    showConfirmButton: false
                });
            },
            complete: function() {
                // Restore button
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Preview maps functionality
    $('#toggle-preview-btn').click(function() {
        const $btn = $(this);
        const state = $btn.data('state');
        const embedUrl = $('#maps_embed_url').val().trim();
        
        if (state === 'show') {
            // Show preview
            if (!embedUrl) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Masukkan Google Maps embed URL terlebih dahulu',
                    icon: 'warning'
                });
                return;
            }
            
            // Validate if it's a valid Google Maps embed URL
            if (!embedUrl.includes('google.com/maps/embed')) {
                Swal.fire({
                    title: 'URL Tidak Valid!',
                    text: 'Pastikan URL yang dimasukkan adalah Google Maps embed URL',
                    icon: 'error'
                });
                return;
            }
            
            // Show preview
            $('#maps-preview-iframe').attr('src', embedUrl);
            $('#maps-preview-container').slideDown(400);
            
            // Change button state
            $btn.html('<i class="fas fa-eye-slash"></i> Sembunyikan Preview')
                .removeClass('btn-info').addClass('btn-warning')
                .data('state', 'hide');
        } else {
            // Hide preview
            $('#maps-preview-container').slideUp(400);
            
            // Change button state
            $btn.html('<i class="fas fa-eye"></i> Preview Maps')
                .removeClass('btn-warning').addClass('btn-info')
                .data('state', 'show');
        }
    });
});

function loadMapsUrl() {
    $.ajax({
        url: '{{ route('admin.cms.contact-info.getMapsUrl') }}',
        type: 'GET',
        success: function(response) {
            if (response.success && response.maps_embed_url) {
                $('#maps_embed_url').val(response.maps_embed_url);
            }
        },
        error: function() {
            // If no maps URL exists, leave empty
            $('#maps_embed_url').attr('placeholder', 'Belum ada Google Maps embed URL');
        }
    });
}

function deleteContactInfo(id) {
    Swal.fire({
        title: 'Hapus Contact Info?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route('admin.cms.contact-info.destroy', ':id') }}'.replace(':id', id),
                type: 'DELETE',
                data: {
                    '_token': '{{ csrf_token() }}'
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
                        $('#contactInfoTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat menghapus data';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error'
                    });
                }
            });
        }
    });
}

function toggleStatus(id) {
    Swal.fire({
        title: 'Ubah Status Contact Info?',
        text: "Status akan diubah antara aktif dan nonaktif",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route('admin.cms.contact-info.toggleStatus', ':id') }}'.replace(':id', id),
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}'
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
                        $('#contactInfoTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat mengubah status';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error'
                    });
                }
            });
        }
    });
}
</script>
@endpush
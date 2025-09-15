@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Kelola Testimoni</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Testimoni</li>
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
                        <h3 class="card-title">Daftar Testimoni</h3>
                        <div>
                            <a href="{{ route('admin.cms.testimonial-section.index') }}" class="btn btn-secondary btn-sm me-2">
                                <i class="fas fa-cog"></i> Pengaturan Section
                            </a>
                            <a href="{{ route('admin.cms.testimonial.reorderPage') }}" class="btn btn-info btn-sm me-2">
                                <i class="fas fa-sort"></i> Atur Urutan
                            </a>
                            <a href="{{ route('admin.cms.testimonial.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Testimoni
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="testimonialTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Gambar</th>
                                    <th width="25%">Nama</th>
                                    <th width="15%">Rating</th>
                                    <th width="25%">Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
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

    $(document).ready(function() {
        // Initialize DataTable
        $('#testimonialTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.cms.testimonial.index') }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'image_display', name: 'image_display', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'stars', name: 'rating', orderable: false, searchable: false},
                {data: 'status', name: 'is_active'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true,
            language: {
                url: '{{ asset('back_assets/plugins/datatables/id.json') }}'
            }
        });
    });

function deleteTestimonial(id) {
    Swal.fire({
        title: 'Hapus Testimoni?',
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
                url: '{{ route('admin.cms.testimonial.destroy', ':id') }}'.replace(':id', id),
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
                        $('#testimonialTable').DataTable().ajax.reload();
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
        title: 'Ubah Status Testimoni?',
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
                url: '{{ route('admin.cms.testimonial.toggleStatus', ':id') }}'.replace(':id', id),
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
                        $('#testimonialTable').DataTable().ajax.reload();
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
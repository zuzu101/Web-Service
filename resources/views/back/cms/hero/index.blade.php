@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Hero Section CMS</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">CMS</a></li>
                <li class="breadcrumb-item active">Hero Section</li>
            </ol>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="card">
    <article class="card-header">
        <div class="float-right">
            <div class="btn-group">
                <a href="{{ route('admin.cms.hero.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Hero Section
                </a>
            </div>
        </div>
        <div class="float-left">
            <div class="form-inline">
                <label for="statusFilterDropdown" class="mr-2 font-weight-bold">Filter Status:</label>
                <select class="form-control" id="statusFilterDropdown">
                    <option value="">Semua</option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>
        </div>
    </article>
    <article class="card-body">
        <table class="table table-striped table-bordered" id="datatable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul</th>
                    <th>Judul 2</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </article>
</section>
@endsection

@push('js')
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

    let dataTable;
    
    $(function() {
        dataTable = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 10,
            pagingType: "simple_numbers",
            ajax: {
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                url: "{{ route('admin.cms.hero.data') }}",
                dataType: "json",
                type: "POST",
                data: function(d) {
                    d.status_filter = $('#status_filter').val();
                }
            },
            columns: [
                { data: 'no', name: 'no', className: "text-center align-middle" },
                { data: 'title', name: 'title', className: "align-middle" },
                { data: 'title2', name: 'title2', className: "align-middle" },
                { data: 'description', name: 'description', className: "align-middle" },
                { data: 'image1', name: 'image1', className: "text-center align-middle", sortable: false, searchable: false },
                { data: 'status', name: 'status', className: "text-center align-middle" },
                { data: 'created_at', name: 'created_at', className: "text-center align-middle" },
                { data: 'actions', name: 'actions', className: "align-middle", sortable: false, searchable: false },
            ]
        });

        // Filter Status
        $('#statusFilterDropdown').on('change', function() {
            let status = $(this).val();

            // Buat atau update hidden input untuk dikirim ke server
            if (!$('#status_filter').length) {
                $('body').append('<input type="hidden" id="status_filter" value="">');
            }
            $('#status_filter').val(status);

            // Reload DataTable
            dataTable.ajax.reload();
        });
    });

    function deleteHeroSection(id) {
        Swal.fire({
            title: 'Hapus Hero Section?',
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
                    url: "{{ route('admin.cms.hero.index') }}/" + id,
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            dataTable.ajax.reload();
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
            title: 'Ubah Status Hero Section?',
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
                    url: "{{ route('admin.cms.hero.index') }}/" + id + '/toggle-status',
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            dataTable.ajax.reload();
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

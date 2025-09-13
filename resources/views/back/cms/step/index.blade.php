@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Kelola Steps</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Steps</li>
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
                    <h3 class="card-title">Daftar Steps</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms.step-section.index') }}" class="btn btn-secondary btn-sm me-2">
                            <i class="fas fa-cog"></i> Pengaturan Section
                        </a>
                        <a href="{{ route('admin.cms.step.reorderPage') }}" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-sort"></i> Atur Urutan
                        </a>
                        <a href="{{ route('admin.cms.step.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Step
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Quick Edit Section Title -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form id="quickEditSectionForm" class="d-flex align-items-center">
                                @csrf
                                <label for="sectionTitle" class="form-label me-3 mb-0 fw-bold">Judul Section:</label>
                                <input type="text" 
                                       id="sectionTitle" 
                                       name="title" 
                                       class="form-control me-3" 
                                       placeholder="Contoh: 3 Langkah Mudah Layanan Kami"
                                       style="max-width: 300px;">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Judul akan tampil di halaman website
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="table-responsive">
                        <table id="stepTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Icon</th>
                                    <th width="25%">Title</th>
                                    <th width="35%">Description</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Aksi</th>
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

$(function () {
    // Load current section title
    loadSectionTitle();

    $('#stepTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.cms.step.index') }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'icon_image', name: 'icon_image', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'status_badge', name: 'status_badge', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        responsive: true,
        language: {
            url: '{{ asset('back_assets/plugins/datatables/id.json') }}'
        }
    });

    // Quick Edit Section Form
    $('#quickEditSectionForm').on('submit', function(e) {
        e.preventDefault();
        const title = $('#sectionTitle').val();
        
        if (!title.trim()) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Judul section tidak boleh kosong.',
            });
            return;
        }

        // Get current section data first
        $.get('{{ route('admin.cms.step-section.data') }}', function(sectionData) {
            let sectionId = sectionData ? sectionData.id : null;
            let url = sectionId ? 
                '{{ route('admin.cms.step-section.update', ':id') }}'.replace(':id', sectionId) :
                '{{ route('admin.cms.step-section.store') }}';
            let method = sectionId ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: {
                    _token: '{{ csrf_token() }}',
                    title: title,
                    is_active: 1
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Judul section berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui judul section.',
                    });
                }
            });
        });
    });
});

function loadSectionTitle() {
    $.get('{{ route('admin.cms.step-section.data') }}', function(data) {
        if (data && data.title) {
            $('#sectionTitle').val(data.title);
        }
    }).fail(function() {
        console.log('Could not load section title');
    });
}

function toggleStatus(id) {
    fetch(`{{ url('admin/cms/step') }}/${id}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            is_active: 'toggle'
        })
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        });
        $('#stepTable').DataTable().ajax.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat mengubah status.',
            timer: 2000,
            showConfirmButton: false
        });
    });
}

function deleteStep(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`{{ url('admin/cms/step') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                $('#stepTable').DataTable().ajax.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menghapus data.',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        }
    });
}
</script>
@endpush

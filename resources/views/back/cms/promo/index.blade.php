@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Kelola Promo</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Promo</li>
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
                    <h3 class="card-title">Kelola Promo</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.cms.promo.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Promo
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Quick Edit Section Title -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form id="quickEditSectionForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="sectionTitle" class="form-label fw-bold">Judul Section (Opsional)</label>
                                    <input type="text" 
                                           id="sectionTitle" 
                                           name="title" 
                                           class="form-control" 
                                           placeholder="Masukkan judul section promo (biarkan kosong jika tidak ingin ditampilkan)...">
                                </div>
                                <div class="mb-3">
                                    <label for="sectionSubtitle" class="form-label fw-bold">Subtitle Section (Opsional)</label>
                                    <input type="text" 
                                           id="sectionSubtitle" 
                                           name="subtitle" 
                                           class="form-control" 
                                           placeholder="Masukkan subtitle section promo (biarkan kosong jika tidak ingin ditampilkan)...">
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Info:</strong><br>
                                Judul dan subtitle bersifat opsional. Jika diisi, akan ditampilkan di section promo pada halaman utama website. Biarkan kosong jika tidak ingin menampilkan judul/subtitle.
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="table-responsive">
                        <table id="promoTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">Gambar</th>
                                    <th width="20%">Judul</th>
                                    <th width="15%">Diskon</th>
                                    <th width="25%">Fitur</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via DataTables -->
                            </tbody>
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
$(document).ready(function() {
    // Load current section title and subtitle
    loadSectionData();

    $('#promoTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.cms.promo.index') }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'image_preview', name: 'image_preview', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'discount_display', name: 'discount_text'},
            {data: 'features_preview', name: 'features_preview', orderable: false, searchable: false},
            {data: 'status_badge', name: 'status_badge', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        responsive: true,
        language: {
            url: '{{ asset('back_assets/plugins/datatables/id.json') }}'
        }
    });

    // Handle quick edit section form
    $('#quickEditSectionForm').on('submit', function(e) {
        e.preventDefault();
        
        const title = $('#sectionTitle').val().trim();
        const subtitle = $('#sectionSubtitle').val().trim();
        
        // Allow both fields to be empty - no validation required

        // Show loading
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: '{{ route('admin.cms.promo.updateSectionTitle') }}',
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'title': title,
                'subtitle': subtitle
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
                let errorMessage = 'Terjadi kesalahan saat menyimpan';
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
});

function loadSectionData() {
    $.ajax({
        url: '{{ route('admin.cms.promo.getSectionTitle') }}',
        type: 'GET',
        success: function(response) {
            if (response.success && response.data) {
                // Load actual data into input fields
                if (response.data.title) {
                    $('#sectionTitle').val(response.data.title);
                }
                if (response.data.subtitle) {
                    $('#sectionSubtitle').val(response.data.subtitle);
                }
            } else {
                // If no data exists, leave fields empty with helpful placeholders
                $('#sectionTitle').attr('placeholder', 'Masukkan judul section promo...');
                $('#sectionSubtitle').attr('placeholder', 'Masukkan subtitle section promo...');
            }
        },
        error: function() {
            // If error loading data, set default placeholders
            $('#sectionTitle').attr('placeholder', 'Masukkan judul section promo...');
            $('#sectionSubtitle').attr('placeholder', 'Masukkan subtitle section promo...');
            console.log('Error loading section data');
        }
    });
}

function toggleStatus(id) {
    fetch(`{{ url('admin/cms/promo') }}/${id}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });
            
            $('#promoTable').DataTable().ajax.reload();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat mengubah status.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

function deletePromo(id) {
    var swalInstance = window.Swal || Swal;
    if (typeof swalInstance === 'undefined') {
        if (confirm('Yakin hapus?')) {
            fetch(`{{ url('admin/cms/promo') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'Promo berhasil dihapus.');
                $('#promoTable').DataTable().ajax.reload();
            })
            .catch(error => {
                alert('Terjadi kesalahan saat menghapus data.');
            });
        }
        return;
    }
    swalInstance.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`{{ url('admin/cms/promo') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
                swalInstance.fire({
                    icon: 'success',
                    title: 'Terhapus!',
                    text: data.message || 'Promo berhasil dihapus.',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#promoTable').DataTable().ajax.reload();
            })
            .catch(error => {
                swalInstance.fire({
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
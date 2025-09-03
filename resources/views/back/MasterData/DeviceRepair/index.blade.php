@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Data Perangkat</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Data Perangkat</li>
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
                <a href="{{ route('admin.MasterData.DeviceRepair.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Perangkat</a>
            </div>
        </div>
        <div class="float-left">
            <div class="form-inline">
                <label for="statusFilterDropdown" class="mr-2 font-weight-bold">Filter Status:</label>
                <select class="form-control" id="statusFilterDropdown">
                    <option value="">Semua</option>
                    <option value="Perangkat Baru Masuk">Baru</option>
                    <option value="Sedang Diperbaiki">Dikerjakan</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>
        </div>
    </article>
    <article class="card-body">
        <table class="table table-striped table-bordered" id="datatable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Pelanggan</th>
                    <th>Merek</th>
                    <th>Model</th>
                    <th>Masalah</th>
                    <th>Nomor Seri</th>
                    <th>Catatan Teknisi</th>
                    <th>Status</th>
                    <th>Target Selesai</th>
                    <th>Estimasi Biaya</th>
                    <th>Ubah Status</th>
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
                url: "{{ route('admin.MasterData.DeviceRepair.data') }}",
                dataType: "json",
                type: "POST",
                data: function(d) {
                    d.status_filter = $('#status_filter').val();
                }
            },
            //column for DeviceRepair dengan kolom Ubah Status
            columns: [
                { data: 'no', name: 'no', className: "text-center align-middle" },
                { data: 'pelanggan_name', name: 'pelanggan_name', className: "align-middle" },
                { data: 'brand', name: 'brand', className: "align-middle" },
                { data: 'model', name: 'model', className: "align-middle" },
                { data: 'reported_issue', name: 'reported_issue', className: "align-middle" },
                { data: 'serial_number', name: 'serial_number', className: "align-middle" },
                { data: 'technician_note', name: 'technician_note', className: "align-middle" },
                { data: 'status', name: 'status', className: "align-middle" },
                { data: 'complete_in', name: 'complete_in', className: "align-middle text-center" },
                { data: 'price', name: 'price', className: "align-middle" },
                { data: 'ubah_status', name: 'ubah_status', className: "text-center align-middle", sortable: false, searchable: false },
                { data: 'actions', name: 'actions', className: "align-middle", sortable: false, searchable: false },
            ]
        });

        // Filter Status (pindahan dari Status page)
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

    function deleteDeviceRepair(id) {
        Swal.fire({
            title: 'Hapus Data Device Repair?',
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
                    url: "{{ route('admin.MasterData.DeviceRepair.index') }}/" + id,
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        dataTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus data',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }
    
    // Function updateStatus pindahan dari Status page
    function updateStatus(id, status) {
        Swal.fire({
            title: 'Ubah Status Device?',
            text: `Apakah Anda yakin ingin mengubah status ke "${status}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.MasterData.DeviceRepair.index') }}/" + id + '/update-status',
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: {
                        status: status
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Status berhasil diperbarui',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        dataTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memperbarui status',
                            icon: 'error'
                        });
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    }
</script>
@endpush
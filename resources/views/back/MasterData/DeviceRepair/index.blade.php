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
                    <th>Nomor Nota</th>
                    <th>Pelanggan</th>
                    <th>Merek</th>
                    <th>Model</th>
                    <th>Masalah</th>
                    <th>Nomor Seri</th>
                    <th>Catatan Teknisi</th>
                    <th>Status</th>
                    <th>Target Selesai</th>
                    <th>Estimasi Biaya</th>
                    <th>Metode Bayar</th>
                    <th>Bukti Transfer</th>
                    <th>Ubah Status</th>
                    <th>Nota</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </article>
</section>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="paymentModalLabel">Input Pembayaran</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    <div class="mb-3">
                        <label class="form-label"><strong>Pelanggan:</strong></label>
                        <p id="customerName" class="text-muted"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Perangkat:</strong></label>
                        <p id="deviceInfo" class="text-muted"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Total Biaya:</strong></label>
                        <p id="totalPrice" class="text-success font-weight-bold h5"></p>
                    </div>
                    <div class="mb-3">
                        <label for="paidAmount" class="form-label"><strong>Uang yang Dibayar:</strong></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" 
                                   class="form-control" 
                                   id="paidAmount" 
                                   name="paid_amount" 
                                   placeholder="0" 
                                   inputmode="numeric" 
                                   pattern="[0-9.]*" 
                                   autocomplete="off" 
                                   autocorrect="off" 
                                   spellcheck="false"
                                   required>
                        </div>
                    </div>
                    <div class="mb-3" id="changeSection" style="display: none;">
                        <label class="form-label"><strong>Kembalian:</strong></label>
                        <p id="changeAmount" class="text-info font-weight-bold h5"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="processPrint">Print</button>
                <button type="button" class="btn btn-danger" id="processPDF">PDF</button>
            </div>
        </div>
    </div>
</div>
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
    let currentNota = {};
    
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
            //column for DeviceRepair dengan kolom Ubah Status dan Nota
            columns: [
                { data: 'no', name: 'no', className: "text-center align-middle" },
                { data: 'nota_number', name: 'nota_number', className: "align-middle" },
                { data: 'pelanggan_name', name: 'pelanggan_name', className: "align-middle" },
                { data: 'brand', name: 'brand', className: "align-middle" },
                { data: 'model', name: 'model', className: "align-middle" },
                { data: 'reported_issue', name: 'reported_issue', className: "align-middle" },
                { data: 'serial_number', name: 'serial_number', className: "align-middle" },
                { data: 'technician_note', name: 'technician_note', className: "align-middle" },
                { data: 'status', name: 'status', className: "align-middle" },
                { data: 'complete_in', name: 'complete_in', className: "align-middle text-center" },
                { data: 'price', name: 'price', className: "align-middle" },
                { data: 'payment_method', name: 'payment_method', className: "align-middle text-center" },
                { data: 'transfer_proof', name: 'transfer_proof', className: "align-middle text-center", sortable: false, searchable: false },
                { data: 'ubah_status', name: 'ubah_status', className: "text-center align-middle", sortable: false, searchable: false },
                { data: 'nota_actions', name: 'nota_actions', className: "text-center align-middle", sortable: false, searchable: false },
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

        // Handle Print button click from Nota actions
        $(document).on('click', '.btn-print', function() {
            currentNota = {
                id: $(this).data('id'),
                customer: $(this).data('customer'),
                device: $(this).data('device'),
                price: parseFloat($(this).data('price')) || 0,
                action: 'print'
            };
            
            showPaymentModal();
        });

        // Handle PDF button click from Nota actions
        $(document).on('click', '.btn-pdf', function() {
            currentNota = {
                id: $(this).data('id'),
                customer: $(this).data('customer'),
                device: $(this).data('device'),
                price: parseFloat($(this).data('price')) || 0,
                action: 'pdf'
            };
            
            showPaymentModal();
        });

        // Format input nominal dengan pemisah ribuan
        $('#paidAmount').on('input', function() {
            let value = $(this).val().replace(/[^0-9]/g, ''); // Hapus semua kecuali angka
            if (value) {
                // Format dengan pemisah ribuan
                let formatted = formatNumber(parseInt(value));
                $(this).val(formatted);
            } else {
                $(this).val(''); // Clear jika tidak ada angka
            }
            
            // Calculate change
            const paidAmount = parseFloat(value) || 0;
            const totalPrice = currentNota.price || 0;
            const change = Math.max(0, paidAmount - totalPrice);
            
            if (paidAmount > 0 && paidAmount >= totalPrice) {
                $('#changeAmount').text('Rp ' + formatNumber(change));
                $('#changeSection').show();
            } else {
                $('#changeSection').hide();
            }
        });

        // Prevent non-numeric input completely
        $('#paidAmount').on('keydown', function(e) {
            // Allow: backspace, delete, tab, escape, enter, home, end, left, right
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 35, 36, 37, 39]) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X, Ctrl+Z
                (e.ctrlKey === true && $.inArray(e.keyCode, [65, 67, 86, 88, 90]) !== -1)) {
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        // Also prevent paste of non-numeric content
        $('#paidAmount').on('paste', function(e) {
            e.preventDefault();
            let paste = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
            let numericOnly = paste.replace(/[^0-9]/g, '');
            if (numericOnly) {
                let formatted = formatNumber(parseInt(numericOnly));
                $(this).val(formatted).trigger('input');
            }
        });

        // Prevent drag and drop
        $('#paidAmount').on('drop dragover', function(e) {
            e.preventDefault();
        });

        // Process Print
        $('#processPrint').click(function() {
            const paidAmountStr = $('#paidAmount').val().replace(/[^0-9]/g, ''); // Remove formatting
            const paidAmount = parseFloat(paidAmountStr) || 0;
            
            if (paidAmount < currentNota.price) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pembayaran Kurang',
                    text: 'Jumlah pembayaran harus minimal sama dengan total biaya.'
                });
                return;
            }
            
            const url = '{{ route("admin.MasterData.Nota.print", ":id") }}'.replace(':id', currentNota.id);
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.target = '_blank';
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            // Add paid amount
            const paidInput = document.createElement('input');
            paidInput.type = 'hidden';
            paidInput.name = 'paid_amount';
            paidInput.value = paidAmount;
            form.appendChild(paidInput);
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
            
            $('#paymentModal').modal('hide');
        });

        // Process PDF
        $('#processPDF').click(function() {
            const paidAmountStr = $('#paidAmount').val().replace(/[^0-9]/g, ''); // Remove formatting
            const paidAmount = parseFloat(paidAmountStr) || 0;
            
            if (paidAmount < currentNota.price) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pembayaran Kurang',
                    text: 'Jumlah pembayaran harus minimal sama dengan total biaya.'
                });
                return;
            }
            
            const url = '{{ route("admin.MasterData.Nota.pdf", ":id") }}'.replace(':id', currentNota.id);
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.target = '_blank';
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            // Add paid amount
            const paidInput = document.createElement('input');
            paidInput.type = 'hidden';
            paidInput.name = 'paid_amount';
            paidInput.value = paidAmount;
            form.appendChild(paidInput);
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
            
            $('#paymentModal').modal('hide');
        });

        // Reset modal when closed
        $('#paymentModal').on('hidden.bs.modal', function() {
            $('#paymentForm')[0].reset();
            $('#changeSection').hide();
            currentNota = {};
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

    function showPaymentModal() {
        $('#customerName').text(currentNota.customer);
        $('#deviceInfo').text(currentNota.device);
        $('#totalPrice').text('Rp ' + formatNumber(currentNota.price));
        $('#paidAmount').val('');
        $('#changeSection').hide();
        $('#paymentModal').modal('show');
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
@endpush

@extends('layouts.admin.app')

@section('header')
<header class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dashboard Laporan Service</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.MasterData.Report.index') }}">Laporan</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="container-fluid">
    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Dashboard Laporan</h6>
                </div>
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="status-filter">Status:</label>
                                <select id="status-filter" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="Perangkat Baru Masuk">Baru Masuk</option>
                                    <option value="Sedang Diperbaiki">Sedang Diperbaiki</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="brand-filter">Brand:</label>
                                <input type="text" id="brand-filter" class="form-control" placeholder="Cari brand...">
                            </div>
                            <div class="col-md-2">
                                <label for="date-from">Dari Tanggal:</label>
                                <input type="date" id="date-from" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="date-to">Sampai Tanggal:</label>
                                <input type="date" id="date-to" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label><br>
                                <button type="button" id="filter-btn" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <button type="button" id="reset-btn" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-transactions">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="completed-transactions">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="pending-transactions">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-revenue">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Lengkap Transaksi Service</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="historyTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nota</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Nomor Seri</th>
                            <th>Masalah</th>
                            <th>Status</th>
                            <th>Harga</th>
                            <th>Target Selesai</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('css')
<style>
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }

</style>
@endpush

@push('js')
<script>
$(function() {
    let table = $('#historyTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: false,
        autoWidth: false,
        pageLength: 10,
        scrollX: true,
        ajax: {
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            url: "{{ route('admin.MasterData.Report.dashboard.data') }}",
            dataType: "json",
            type: "POST",
            data: function(d) {
                return {
                    status: $('#status-filter').val(),
                    brand: $('#brand-filter').val(),
                    date_from: $('#date-from').val(),
                    date_to: $('#date-to').val(),
                    _token: '{{ csrf_token() }}'
                };
            },
            dataSrc: function(json) {
                console.log('Response data:', json); // Debug line
                // Update summary cards
                if (json.summary) {
                    $('#total-transactions').text(json.summary.total_transactions);
                    $('#completed-transactions').text(json.summary.completed_transactions);
                    $('#pending-transactions').text(json.summary.pending_transactions);
                    $('#total-revenue').text(json.summary.total_revenue);
                }
                console.log('Data array:', json.data); // Debug line
                return json.data;
            }
        },
        columns: [
            {data: 'no', name: 'no', orderable: false, searchable: false, width: '50px'},
            {data: 'nota_number', name: 'nota_number'},
            {data: 'created_date', name: 'created_date'},
            {data: 'pelanggan', name: 'pelanggan'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'brand', name: 'brand'},
            {data: 'model', name: 'model'},
            {data: 'serial_number', name: 'serial_number'},
            {data: 'reported_issue', name: 'reported_issue', 
             render: function(data) {
                 return data.length > 30 ? data.substring(0, 30) + '...' : data;
             }},
            {data: 'status', name: 'status', orderable: false},
            {data: 'price', name: 'price'},
            {data: 'complete_in', name: 'complete_in'}
        ],
            columnDefs: [
            {
                targets: [10], // Status column index
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).html(cellData);
                }
            },
            // Email column
                            { targets: 5, width: '500px', createdCell: function(td, cellData) {
                                    var txt = cellData || '';
                                    var wrapped = txt.replace(/@/g, '\u200B@');
                                    $(td).css({ 'white-space': 'normal', 'word-break': 'break-word', 'max-width': '500px' });
                                    $(td).html(wrapped).attr('title', txt);
                                }
                }
        ]
        
    });
    function debounce(func, wait) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() { func.apply(context, args); }, wait);
        };
    }

    var adjustTable = debounce(function() {
        try {
            table.columns.adjust();
            if (table.responsive && typeof table.responsive.recalc === 'function') {
                table.responsive.recalc();
            }
        } catch (e) {
            // ignore
        }
    }, 200);

    window.addEventListener('resize', adjustTable);
    window.addEventListener('orientationchange', adjustTable);
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') adjustTable();
    });

    // Some browsers don't fire meaningful resize on zoom; detect devicePixelRatio changes
    var lastDPR = window.devicePixelRatio;
    setInterval(function() {
        if (window.devicePixelRatio !== lastDPR) {
            lastDPR = window.devicePixelRatio;
            adjustTable();
        }
    }, 500);

    // Update summary cards
    function updateSummary() {
        let params = {
            status: $('#status-filter').val(),
            brand: $('#brand-filter').val(),
            date_from: $('#date-from').val(),
            date_to: $('#date-to').val(),
            _token: '{{ csrf_token() }}'
        };

        $.post("{{ route('admin.MasterData.Report.dashboard.summary') }}", params)
        .done(function(response) {
            $('#total-transactions').text(response.total_transactions);
            $('#completed-transactions').text(response.completed_transactions);
            $('#pending-transactions').text(response.pending_transactions);
            $('#total-revenue').text(response.total_revenue);
        })
        .fail(function() {
            console.log('Error loading summary data');
        });
    }

    // Filter button
    $('#filter-btn').click(function() {
        table.ajax.reload();
        updateSummary();
    });

    // Reset button
    $('#reset-btn').click(function() {
        $('#status-filter').val('');
        $('#brand-filter').val('');
        $('#date-from').val('');
        $('#date-to').val('');
        table.ajax.reload();
        updateSummary();
    });

    // Auto filter on input change
    $('#status-filter, #brand-filter, #date-from, #date-to').change(function() {
        table.ajax.reload();
        updateSummary();
    });

    // Initialize summary on page load
    updateSummary();

});

</script>
@endpush

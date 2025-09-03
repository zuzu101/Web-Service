@extends('layouts.admin.app')

@section('header')
    <header class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Preview Data Service</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.MasterData.DeviceRepair.index') }}">Data Perangkat</a>
                    </li>
                    <li class="breadcrumb-item active">Preview</li>
                </ol>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Detail Transaksi Service</h5>
        </div>
        <div class="card-body">
            {{-- Data Pelanggan --}}
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input type="text" value="{{ $deviceRepair->customers->name ?? 'N/A' }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Telepon</label>
                <input type="text" value="{{ $deviceRepair->customers->phone ?? 'N/A' }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" value="{{ $deviceRepair->customers->email ?? 'N/A' }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" value="{{ $deviceRepair->customers->address ?? 'N/A' }}" class="form-control" readonly>
            </div>

            {{-- Data Perangkat & Service --}}
            <div class="form-group">
                <label>Nomor Nota</label>
                <input type="text" value="{{ $deviceRepair->nota_number }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Status</label>
                <input type="text" value="{{ $deviceRepair->status }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Brand</label>
                <input type="text" value="{{ $deviceRepair->brand }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Model</label>
                <input type="text" value="{{ $deviceRepair->model }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Serial Number</label>
                <input type="text" value="{{ $deviceRepair->serial_number }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" value="Rp. {{ number_format($deviceRepair->price, 0, ',', '.') }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="text" value="{{ $deviceRepair->created_at->format('d M Y H:i') }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Target Selesai</label>
                <input type="text" value="{{ $deviceRepair->complete_in ? \Carbon\Carbon::parse($deviceRepair->complete_in)->format('d M Y') : 'Belum ditentukan' }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Masalah yang Dilaporkan</label>
                <textarea class="form-control" rows="3" readonly>{{ $deviceRepair->reported_issue }}</textarea>
            </div>
            @if($deviceRepair->technician_note)
            <div class="form-group">
                <label>Catatan Teknisi</label>
                <textarea class="form-control" rows="3" readonly>{{ $deviceRepair->technician_note }}</textarea>
            </div>
            @endif

            {{-- Tombol Kembali --}}
            <div class="mt-4">
                <a href="{{ route('admin.MasterData.DeviceRepair.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>
@endsection

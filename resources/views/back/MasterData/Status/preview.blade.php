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
                        <a href="{{ route('admin.MasterData.Status.index') }}">Status</a>
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
                <input type="text" value="{{ $status->customers->name ?? 'N/A' }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Telepon</label>
                <input type="text" value="{{ $status->customers->phone ?? 'N/A' }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" value="{{ $status->customers->email ?? 'N/A' }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" value="{{ $status->customers->address ?? 'N/A' }}" class="form-control" readonly>
            </div>

            {{-- Data Perangkat & Service --}}
            <div class="form-group">
                <label>Nomor Nota</label>
                <input type="text" value="{{ $status->nota_number }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Status</label>
                <input type="text" value="{{ $status->status }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Brand</label>
                <input type="text" value="{{ $status->brand }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Model</label>
                <input type="text" value="{{ $status->model }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Serial Number</label>
                <input type="text" value="{{ $status->serial_number }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" value="Rp. {{ number_format($status->price, 0, ',', '.') }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="text" value="{{ $status->created_at->format('d M Y H:i') }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Target Selesai</label>
                <input type="text" value="{{ $status->complete_in ? \Carbon\Carbon::parse($status->complete_in)->format('d M Y') : 'Belum ditentukan' }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Masalah yang Dilaporkan</label>
                <textarea class="form-control" rows="3" readonly>{{ $status->reported_issue }}</textarea>
            </div>
            @if($status->technician_note)
            <div class="form-group">
                <label>Catatan Teknisi</label>
                <textarea class="form-control" rows="3" readonly>{{ $status->technician_note }}</textarea>
            </div>
            @endif


            {{-- Tombol Kembali --}}
            <div class="mt-4">
                <a href="{{ route('admin.MasterData.Status.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

        </div>
    </div>
@endsection

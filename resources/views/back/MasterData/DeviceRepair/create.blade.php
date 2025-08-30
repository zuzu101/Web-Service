@extends('layouts.admin.app')

@section('header')
    <header class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Perangkat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.MasterData.DeviceRepair.index') }}">Perbaikan Perangkat</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Perangkat</li>
                </ol>
            </div>
        </div>
    </header>
@endsection

@section('content')
    {{-- Wrap with a grid to control the width and center the form --}}
    <div class="card">
        <div class="card-body">
            <form id="form-validation" method="POST" action="{{ route('admin.MasterData.DeviceRepair.store') }}" enctype="multipart/form-data">
                @csrf
                
                {{-- Pelanggan --}}
                <div class="form-group">
                    <label for="customer_id">Pelanggan</label>
                    <select name="customer_id" id="customer_id" class="form-control select2" required>
                        <option value=""></option>
                        @foreach(\App\Models\MasterData\Customers::all() as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach

                    </select>
                </div>

                {{-- Merk Laptop --}}
                <div class="form-group">
                    <label for="brand">Merk Laptop</label>
                    <input type="text" name="brand" class="form-control" placeholder="Cth: Asus, Lenovo, HP" required>
                </div>

                {{-- Model --}}
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" name="model" class="form-control" placeholder="Cth: ROG Strix G15, ThinkPad T480" required>
                </div>

                {{-- Serial Number --}}
                <div class="form-group">
                    <label for="serial_number">Serial Number Laptop</label>
                    <input type="text" name="serial_number" class="form-control" placeholder="Masukkan serial number (jika ada)" required>
                </div>

                {{-- Kerusakan Yang Dilaporkan --}}
                <div class="form-group">
                    <label for="reported_issue">Kerusakan Yang Dilaporkan</label>
                    <textarea name="reported_issue" class="form-control" rows="3" placeholder="Cth: Mati total, layar bergaris, keyboard error" required></textarea>
                </div>

                {{-- Catatan Teknisi --}}
                <div class="form-group">
                    <label for="technician_note">Catatan Teknisi (Opsional)</label>
                    <textarea name="technician_note" class="form-control" rows="3" placeholder="Cth: Dicurigai kerusakan pada IC power"></textarea>
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label for="status">Status Awal</label>
                    <select name="status" class="form-control" required>
                        <option value="Perangkat Baru Masuk">Perangkat Baru Masuk</option>
                        <option value="Sedang Diperbaiki">Sedang Diperbaiki</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                {{-- Estimasi Biaya --}}
                <div class="form-group">
                    <label for="price">Estimasi Biaya</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" name="price_display" id="price_display" class="form-control" placeholder="Masukkan angka saja">
                        <input type="hidden" name="price" id="price_hidden">
                    </div>
                </div>

                {{-- Target Selesai --}}
                <div class="form-group">
                    <label for="complete_in">Target Selesai</label>
                    <input type="date" name="complete_in" class="form-control">
                </div>
                
                {{-- Buttons --}}
                <div class="mt-4">
                    <button type="reset" class="btn btn-outline-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class=""></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection



@push('js')
  <script>
    $(document).ready(function() {
        // Initialize Select2 for pelanggan field
        $('#customer_id').select2({
            placeholder: 'Ketik nama pelanggan...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-4'
        });

        // Format currency input
        $('#price_display').on('input', function() {
            let value = this.value.replace(/[^\d]/g, ''); // Remove non-digits
            let formattedValue = '';
            
            if (value) {
                // Format with thousands separator
                formattedValue = parseInt(value).toLocaleString('id-ID');
                $('#price_hidden').val(value); // Store raw number for backend
            } else {
                $('#price_hidden').val('');
            }
            
            this.value = formattedValue;
        });

        // Handle paste event
        $('#price_display').on('paste', function(e) {
            setTimeout(() => {
                $(this).trigger('input');
            }, 1);
        });

        // custom validator: strip non-digits from formatted currency then compare
        $.validator.addMethod('priceMax', function(value, element, param) {
            if (!value) return true; // empty allowed here
            var raw = String(value).replace(/[^0-9]/g, '');
            if (!raw) return true;
            return Number(raw) <= Number(param);
        });

        $('#form-validation').validate({
            rules: {
                price_display: {
                    priceMax: 1000000000
                }
            },
            messages: {
                price_display: {
                    priceMax: 'Harga terlalu besar. Maksimal 1.000.000.000'
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        })

        $('#descriptionInput').summernote({
            height: 300, // Change the height here
        })
    })
  </script>
@endpush

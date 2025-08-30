@extends('layouts.admin.app')

@section('header')
    <header class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Perbaharui Perangkat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.MasterData.DeviceRepair.index') }}">Perangkat</a>
                    </li>
                    <li class="breadcrumb-item active">Perbaharui Perangkat</li>
                </ol>
            </div>
        </div>
    </header>
@endsection

@section('content')
    {{-- Wrap with a grid to control the width and center the form --}}
            <div class="card">
                <div class="card-body">
                    <form id="form-validation" method="POST" action="{{ route('admin.MasterData.DeviceRepair.update', $deviceRepair) }}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        
                        {{-- Pelanggan --}}
                        <div class="form-group">
                            <label for="customer_id">Pelanggan</label>
                            <select name="customer_id" id="customer_id" class="form-control select2" required>
                                <option value="">Ketik nama pelanggan...</option>
                                @foreach(\App\Models\MasterData\Customers::all() as $customer)
                                    <option value="{{ $customer->id }}" {{ $deviceRepair->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Merk Laptop --}}
                        <div class="form-group">
                            <label for="brand">Merk Laptop</label>
                            <input type="text" name="brand" value="{{ old('brand', $deviceRepair->brand) }}" class="form-control" placeholder="Cth: Asus, Lenovo, HP" required>
                        </div>

                        {{-- Model --}}
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" name="model" value="{{ old('model', $deviceRepair->model) }}" class="form-control" placeholder="Cth: ROG Strix G15, ThinkPad T480" required>
                        </div>

                        {{-- Serial Number --}}
                        <div class="form-group">
                            <label for="serial_number">Serial Number Laptop</label>
                            <input type="text" name="serial_number" value="{{ old('serial_number', $deviceRepair->serial_number) }}" class="form-control" placeholder="Masukkan serial number (jika ada)" required>
                        </div>

                        {{-- Kerusakan Yang Dilaporkan --}}
                        <div class="form-group">
                            <label for="reported_issue">Kerusakan Yang Dilaporkan</label>
                            <textarea name="reported_issue" class="form-control" rows="3" placeholder="Cth: Mati total, layar bergaris, keyboard error" required>{{ old('reported_issue', $deviceRepair->reported_issue) }}</textarea>
                        </div>

                        {{-- Catatan Teknisi --}}
                        <div class="form-group">
                            <label for="technician_note">Catatan Teknisi (Opsional)</label>
                            <textarea name="technician_note" class="form-control" rows="3" placeholder="Cth: Dicurigai kerusakan pada IC power">{{ old('technician_note', $deviceRepair->technician_note) }}</textarea>
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Perangkat Baru Masuk" {{ old('status', $deviceRepair->status) == 'Perangkat Baru Masuk' ? 'selected' : '' }}>Perangkat Baru Masuk</option>
                                <option value="Sedang Diperbaiki" {{ old('status', $deviceRepair->status) == 'Sedang Diperbaiki' ? 'selected' : '' }}>Sedang Diperbaiki</option>
                                <option value="Selesai" {{ old('status', $deviceRepair->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        {{-- Estimasi Biaya --}}
                        <div class="form-group">
                            <label for="price">Estimasi Biaya</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" name="price_display" id="price_display" class="form-control" 
                                       value="{{ old('price_display', ($deviceRepair->price ? number_format((float)$deviceRepair->price, 0, ',', '.') : '')) }}" 
                                       placeholder="Masukkan angka saja">
                                <input type="hidden" name="price" id="price_hidden" value="{{ old('price', $deviceRepair->price) }}">
                            </div>
                        </div>

                        {{-- Target Selesai --}}
                        <div class="form-group">
                            <label for="complete_in">Target Selesai</label>
                            <input type="date" name="complete_in" value="{{ old('complete_in', ($deviceRepair->complete_in ? $deviceRepair->complete_in->format('Y-m-d') : '')) }}" class="form-control">
                        </div>
                        
                        {{-- Buttons --}}
                        <div class="mt-4">
                            <a href="{{ route('admin.MasterData.DeviceRepair.index') }}" class="btn btn-outline-secondary">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
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
            theme: 'bootstrap-5'
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
        // custom validator for formatted currency
        $.validator.addMethod('priceMax', function(value, element, param) {
            if (!value) return true;
            var raw = String(value).replace(/[^0-9]/g, '');
            if (!raw) return true;
            return Number(raw) <= Number(param);
        });

        $('#form-validation').validate({
            rules: {
                price_display: {
                    priceMax: 999999999999
                }
            },
            messages: {
                price_display: {
                    priceMax: 'Harga terlalu besar. Maksimal 999.999.999.999'
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

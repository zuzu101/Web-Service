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
                                <option value="">Pilih pelanggan atau ketik nama baru...</option>
                                @foreach(\App\Models\MasterData\Customers::all() as $customer)
                                    <option value="{{ $customer->id }}" {{ $deviceRepair->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                Pilih dari daftar pelanggan yang sudah ada, atau ketik nama baru untuk menambah pelanggan baru.
                            </small>
                        </div>

                        {{-- Merk Laptop --}}
                        <div class="form-group">
                            <label for="brand">Merk Laptop</label>
                            <select name="brand" id="brand" class="form-control select2" required>
                                <option value="">Pilih merk laptop...</option>
                                @if(isset($brands) && $brands->count())
                                    @foreach($brands as $brandOption)
                                        <option value="{{ $brandOption }}" {{ old('brand', $deviceRepair->brand) == $brandOption ? 'selected' : '' }}>{{ $brandOption }}</option>
                                    @endforeach
                                @else
                                    {{-- Fallback brands jika database kosong --}}
                                    <option value="Asus" {{ old('brand', $deviceRepair->brand) == 'Asus' ? 'selected' : '' }}>Asus</option>
                                    <option value="Acer" {{ old('brand', $deviceRepair->brand) == 'Acer' ? 'selected' : '' }}>Acer</option>
                                    <option value="Lenovo" {{ old('brand', $deviceRepair->brand) == 'Lenovo' ? 'selected' : '' }}>Lenovo</option>
                                    <option value="HP" {{ old('brand', $deviceRepair->brand) == 'HP' ? 'selected' : '' }}>HP</option>
                                    <option value="Dell" {{ old('brand', $deviceRepair->brand) == 'Dell' ? 'selected' : '' }}>Dell</option>
                                    <option value="Toshiba" {{ old('brand', $deviceRepair->brand) == 'Toshiba' ? 'selected' : '' }}>Toshiba</option>
                                    <option value="Samsung" {{ old('brand', $deviceRepair->brand) == 'Samsung' ? 'selected' : '' }}>Samsung</option>
                                    <option value="Apple" {{ old('brand', $deviceRepair->brand) == 'Apple' ? 'selected' : '' }}>Apple (MacBook)</option>
                                    <option value="MSI" {{ old('brand', $deviceRepair->brand) == 'MSI' ? 'selected' : '' }}>MSI</option>
                                    <option value="Alienware" {{ old('brand', $deviceRepair->brand) == 'Alienware' ? 'selected' : '' }}>Alienware</option>
                                @endif
                                <option value="Lainnya" {{ old('brand', $deviceRepair->brand) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                {{-- Jika brand yang ada tidak dalam daftar, tambahkan sebagai option --}}
                                @if(isset($deviceRepair) && $deviceRepair->brand && 
                                    (!isset($brands) || !$brands->contains($deviceRepair->brand)) && 
                                    !in_array($deviceRepair->brand, ['Asus', 'Acer', 'Lenovo', 'HP', 'Dell', 'Toshiba', 'Samsung', 'Apple', 'MSI', 'Alienware', 'Lainnya']))
                                    <option value="{{ $deviceRepair->brand }}" selected>{{ $deviceRepair->brand }}</option>
                                @endif
                            </select>
                            <small class="form-text text-muted">
                                Pilih merk dari daftar atau ketik merk baru untuk menambahkannya ke database.
                            </small>
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

                        {{-- Payment Method --}}
                        <div class="form-group">
                            <label for="payment_method">Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="">Pilih metode pembayaran...</option>
                                <option value="cash" {{ old('payment_method', $deviceRepair->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="transfer" {{ old('payment_method', $deviceRepair->payment_method) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                        </div>

                        {{-- Transfer Proof (Only show when transfer is selected) --}}
                        <div class="form-group" id="transfer_proof_group" style="{{ old('payment_method', $deviceRepair->payment_method) == 'transfer' ? 'display: block;' : 'display: none;' }}">
                            <label for="transfer_proof">Bukti Transfer</label>
                            @if($deviceRepair->transfer_proof)
                                <div class="mb-2">
                                    <small class="text-muted">File saat ini: </small>
                                    <a href="{{ Storage::url($deviceRepair->transfer_proof) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        Lihat Bukti Transfer
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="transfer_proof" id="transfer_proof" class="form-control-file" accept="image/*,.pdf">
                            <small class="form-text text-muted">
                                Upload bukti transfer (gambar atau PDF). Maksimal 2MB. Kosongkan jika tidak ingin mengganti.
                            </small>
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
            theme: 'bootstrap-5',
            tags: true, // Allow creating new options
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: 'new:' + term, // Prefix with 'new:' to identify new customers
                    text: term + ' (Pelanggan Baru)',
                    newTag: true
                };
            },
            templateResult: function (data) {
                if (data.newTag) {
                    return $('<span><i class="fa fa-plus-circle text-success"></i> ' + data.text + '</span>');
                }
                return data.text;
            }
        });

        // Initialize Select2 for brand field
        $('#brand').select2({
            placeholder: 'Pilih merk laptop...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            tags: true, // Allow creating new options
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term + ' (Merk Baru)',
                    newTag: true
                };
            },
            templateResult: function (data) {
                if (data.newTag) {
                    return $('<span><i class="fa fa-plus-circle text-success"></i> ' + data.text + '</span>');
                }
                return data.text;
            }
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

        // Handle payment method change
        $('#payment_method').on('change', function() {
            if ($(this).val() === 'transfer') {
                $('#transfer_proof_group').slideDown();
                // Don't make required in edit mode, as they might already have one
            } else {
                $('#transfer_proof_group').slideUp();
                $('#transfer_proof').val('');
            }
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

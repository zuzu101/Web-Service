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
                        <option value="">Pilih pelanggan atau ketik nama baru...</option>
                        @foreach(\App\Models\MasterData\Customers::all() as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
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
                                <option value="{{ $brandOption }}" {{ old('brand') == $brandOption ? 'selected' : '' }}>{{ $brandOption }}</option>
                            @endforeach
                        @else
                            {{-- Fallback brands jika database kosong --}}
                            <option value="Asus">Asus</option>
                            <option value="Acer">Acer</option>
                            <option value="Lenovo">Lenovo</option>
                            <option value="HP">HP</option>
                            <option value="Dell">Dell</option>
                            <option value="Toshiba">Toshiba</option>
                            <option value="Samsung">Samsung</option>
                            <option value="Apple">Apple (MacBook)</option>
                            <option value="MSI">MSI</option>
                            <option value="Alienware">Alienware</option>
                        @endif
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <small class="form-text text-muted">
                        Pilih merk dari daftar atau ketik merk baru untuk menambahkannya ke database.
                    </small>
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

                {{-- Payment Method --}}
                <div class="form-group">
                    <label for="payment_method">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="">Pilih metode pembayaran...</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>

                {{-- Transfer Proof (Only show when transfer is selected) --}}
                <div class="form-group" id="transfer_proof_group" style="display: none;">
                    <label for="transfer_proof">Bukti Transfer</label>
                    <input type="file" name="transfer_proof" id="transfer_proof" class="form-control-file" accept="image/*,.pdf">
                    <small class="form-text text-muted">
                        Upload bukti transfer (gambar atau PDF). Maksimal 2MB.
                    </small>
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
            theme: 'bootstrap-4',
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
            theme: 'bootstrap-4',
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

        // custom validator: strip non-digits from formatted currency then compare
        $.validator.addMethod('priceMax', function(value, element, param) {
            if (!value) return true; // empty allowed here
            var raw = String(value).replace(/[^0-9]/g, '');
            if (!raw) return true;
            return Number(raw) <= Number(param);
        });

        // Handle payment method change
        $('#payment_method').on('change', function() {
            if ($(this).val() === 'transfer') {
                $('#transfer_proof_group').slideDown();
                $('#transfer_proof').attr('required', true);
            } else {
                $('#transfer_proof_group').slideUp();
                $('#transfer_proof').removeAttr('required').val('');
            }
        });

        // Show transfer proof field if transfer was selected (for validation errors)
        if ($('#payment_method').val() === 'transfer') {
            $('#transfer_proof_group').show();
            $('#transfer_proof').attr('required', true);
        }

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

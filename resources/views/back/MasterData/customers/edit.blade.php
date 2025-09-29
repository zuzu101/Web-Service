@extends('layouts.admin.app')

@section('header')
    <header class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Perbaharui Pelanggan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.MasterData.customers.index') }}">Pelanggan</a>
                    </li>
                    <li class="breadcrumb-item active">Perbaharui Pelanggan</li>
                </ol>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="form-validation" method="POST" action="{{ route('admin.MasterData.customers.update', $customer) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                
                {{-- Display Global Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                {{-- Nama --}}
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama pelanggan" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Telepon --}}
                <div class="form-group">
                    <label for="phone">Telepon</label>
                    <input type="tel" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control @error('phone') is-invalid @enderror" placeholder="Masukkan nomor telepon" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="form-group">
                    <label for="province_id">Provinsi</label>
                    <select name="province_id" id="province_id" class="form-control select2 @error('province_id') is-invalid @enderror">
                        <option value="">Pilih Provinsi...</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}" {{ old('province_id', $customer->province_id) == $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="regency_id">Kabupaten/Kota</label>
                    <select name="regency_id" id="regency_id" class="form-control select2 @error('regency_id') is-invalid @enderror" {{ $regencies->isEmpty() ? 'disabled' : '' }}>
                        <option value="">Pilih Kabupaten/Kota...</option>
                        @foreach($regencies as $regency)
                            <option value="{{ $regency->id }}" {{ old('regency_id', $customer->regency_id) == $regency->id ? 'selected' : '' }}>
                                {{ $regency->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('regency_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                                    <!-- District Field -->
                    <div class="mb-3">
                        <label for="district_id" class="form-label">Kecamatan</label>
                        <select name="district_id" id="district_id" class="form-control">
                            <option value="">Pilih Kecamatan...</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district_id', $customer->district_id) == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('district_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Village Field -->
                    <div class="mb-3">
                        <label for="village_id" class="form-label">Desa/Kelurahan </label>
                        <select name="village_id" id="village_id" class="form-control">
                            <option value="">Pilih Desa/Kelurahan... </option>
                            @foreach ($villages as $village)
                                <option value="{{ $village->id }}" {{ old('village_id', $customer->village_id) == $village->id ? 'selected' : '' }}>
                                    {{ $village->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('village_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    </select>
                    @error('village_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Detail Alamat --}}
                <div class="form-group">
                    <label for="street_address">Detail Alamat</label>
                    <textarea name="street_address" id="street_address" class="form-control @error('street_address') is-invalid @enderror" rows="3" placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 02, Perumahan ABC">{{ old('street_address', $customer->street_address) }}</textarea>
                    <small class="form-text text-muted">Masukkan detail alamat seperti nama jalan, nomor rumah, RT/RW, komplek, dll.</small>
                    @error('street_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat Lama (Hidden, untuk backup) --}}
                <input type="hidden" name="address" id="old_address" value="{{ old('address', $customer->address) }}">

                {{-- Status --}}
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">Pilih Status</option>
                        <option value="1" {{ (old('status', $customer->status) == '1') ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ (old('status', ''.$customer->status) == '0') ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.MasterData.customers.index') }}" class="btn btn-outline-secondary">
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-4',
                width: '100%'
            });

        // Embed all data as JavaScript variables
        const regenciesData = @json(\App\Models\Region\Regency::with('province')->get()->groupBy('province_id'));
        const districtsData = @json(\App\Models\Region\District::with('regency')->get()->groupBy('regency_id'));
        const villagesData = @json(\App\Models\Region\Village::with('district')->get()->groupBy('district_id'));

        // Province change handler
        $('#province_id').on('change', function() {
            const provinceId = $(this).val();
            const regencySelect = $('#regency_id');
            const districtSelect = $('#district_id');
            const villageSelect = $('#village_id');
            
            // Clear regency, district, and village
            regencySelect.empty().append('<option value="">Pilih Kabupaten/Kota...</option>');
            districtSelect.empty().append('<option value="">Pilih Kecamatan... </option>').prop('disabled', true);
            villageSelect.empty().append('<option value="">Pilih Desa/Kelurahan... </option>').prop('disabled', true);
            
            if (provinceId && regenciesData[provinceId]) {
                // Populate regencies
                regenciesData[provinceId].forEach(function(regency) {
                    regencySelect.append('<option value="' + regency.id + '">' + regency.name + '</option>');
                });
                regencySelect.prop('disabled', false);
            } else {
                regencySelect.prop('disabled', true);
            }
        });

        // Regency change handler
        $('#regency_id').on('change', function() {
            const regencyId = $(this).val();
            const districtSelect = $('#district_id');
            const villageSelect = $('#village_id');
            
            // Clear districts and villages
            districtSelect.empty().append('<option value="">Pilih Kecamatan... </option>');
            villageSelect.empty().append('<option value="">Pilih Desa/Kelurahan... </option>').prop('disabled', true);
            
            if (regencyId && districtsData[regencyId]) {
                // Populate districts
                districtsData[regencyId].forEach(function(district) {
                    districtSelect.append('<option value="' + district.id + '">' + district.name + '</option>');
                });
                districtSelect.prop('disabled', false);
            } else {
                districtSelect.prop('disabled', true);
            }
        });

        // District change handler
        $('#district_id').on('change', function() {
            const districtId = $(this).val();
            const villageSelect = $('#village_id');
            
            // Clear villages
            villageSelect.empty().append('<option value="">Pilih Desa/Kelurahan... </option>');
            
            if (districtId && villagesData[districtId]) {
                // Populate villages
                villagesData[districtId].forEach(function(village) {
                    villageSelect.append('<option value="' + village.id + '">' + village.name + '</option>');
                });
                villageSelect.prop('disabled', false);
            } else {
                villageSelect.prop('disabled', true);
            }
        });            // Auto-load existing data
            @if($customer->province_id)
                $('#province_id').trigger('change');
                setTimeout(function() {
                    $('#regency_id').val('{{ $customer->regency_id }}').trigger('change');
                    setTimeout(function() {
                        $('#district_id').val('{{ $customer->district_id }}');
                    }, 100);
                }, 100);
            @endif
        });
    </script>
@endpush

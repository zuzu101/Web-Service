@extends('layouts.admin.app')

@section('header')
    <header class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Pelanggan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.MasterData.customers.index') }}">Pelanggan</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Pelanggan</li>
                </ol>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="form-validation" method="POST" action="{{ route('admin.MasterData.customers.store') }}" enctype="multipart/form-data">
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
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Telepon --}}
                <div class="form-group">
                    <label for="phone">Telepon</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="form-group">
                    <label for="province_id">Provinsi <span class="text-danger">*</span></label>
                    <select name="province_id" id="province_id" class="form-control select2 @error('province_id') is-invalid @enderror" required>
                        <option value="">Pilih Provinsi...</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="regency_id">Kabupaten/Kota <span class="text-danger">*</span></label>
                    <select name="regency_id" id="regency_id" class="form-control select2 @error('regency_id') is-invalid @enderror" required disabled>
                        <option value="">Pilih Kabupaten/Kota...</option>
                    </select>
                    @error('regency_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="district_id">Kecamatan</label>
                    <select name="district_id" id="district_id" class="form-control select2 @error('district_id') is-invalid @enderror" disabled>
                        <option value="">Pilih Kecamatan... (Opsional)</option>
                    </select>
                    <small class="form-text text-muted">Opsional - pilih jika ingin lebih detail</small>
                    @error('district_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="village_id">Desa/Kelurahan</label>
                    <select name="village_id" id="village_id" class="form-control select2 @error('village_id') is-invalid @enderror" disabled>
                        <option value="">Pilih Desa/Kelurahan... (Opsional)</option>
                    </select>
                    <small class="form-text text-muted">Opsional - pilih jika ingin lebih detail</small>
                    @error('village_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Detail Alamat --}}
                <div class="form-group">
                    <label for="street_address">Detail Alamat</label>
                    <textarea name="street_address" id="street_address" class="form-control @error('street_address') is-invalid @enderror" rows="3" placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 02, Perumahan ABC">{{ old('street_address') }}</textarea>
                    <small class="form-text text-muted">Masukkan detail alamat seperti nama jalan, nomor rumah, RT/RW, komplek, dll.</small>
                    @error('street_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat Lama (Hidden, untuk backup) --}}
                <input type="hidden" name="address" id="old_address" value="{{ old('address') }}">

                {{-- Status --}}
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">Pilih Status</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="reset" class="btn btn-outline-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
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
        const regenciesData = @json(\App\Models\Regency::with('province')->get()->groupBy('province_id'));
        const districtsData = @json(\App\Models\District::with('regency')->get()->groupBy('regency_id'));
        const villagesData = @json(\App\Models\Village::with('district')->get()->groupBy('district_id'));

        // Province change handler
        $('#province_id').on('change', function() {
            const provinceId = $(this).val();
            const regencySelect = $('#regency_id');
            const districtSelect = $('#district_id');
            const villageSelect = $('#village_id');
            
            // Clear regency, district, and village
            regencySelect.empty().append('<option value="">Pilih Kabupaten/Kota...</option>');
            districtSelect.empty().append('<option value="">Pilih Kecamatan... (Opsional)</option>').prop('disabled', true);
            villageSelect.empty().append('<option value="">Pilih Desa/Kelurahan... (Opsional)</option>').prop('disabled', true);
            
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
            districtSelect.empty().append('<option value="">Pilih Kecamatan... (Opsional)</option>');
            villageSelect.empty().append('<option value="">Pilih Desa/Kelurahan... (Opsional)</option>').prop('disabled', true);
            
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
            villageSelect.empty().append('<option value="">Pilih Desa/Kelurahan... (Opsional)</option>');
            
            if (districtId && villagesData[districtId]) {
                // Populate villages
                villagesData[districtId].forEach(function(village) {
                    villageSelect.append('<option value="' + village.id + '">' + village.name + '</option>');
                });
                villageSelect.prop('disabled', false);
            } else {
                villageSelect.prop('disabled', true);
            }
        });

        // Restore old values if validation fails
        @if(old('province_id'))
            $('#province_id').trigger('change');
            setTimeout(function() {
                $('#regency_id').val('{{ old('regency_id') }}').trigger('change');
                setTimeout(function() {
                    $('#district_id').val('{{ old('district_id') }}').trigger('change');
                    setTimeout(function() {
                        $('#village_id').val('{{ old('village_id') }}');
                    }, 100);
                }, 100);
            }, 100);
        @endif
    });
</script>
@endpush

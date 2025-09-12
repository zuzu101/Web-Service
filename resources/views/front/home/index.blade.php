<x-client.layout>
    <header id="hero">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center text-lg-start">
                
                <section class="col-lg-7 animate-on-scroll fade-in-left">
                    <h1 class="header-1 color-navy fw-bold mb-0">Service Laptop</h1>
                    <h1 class="header-1 color-accent fw-bold mb-4">Cepat, Jujur, dan Bergaransi</h1>
                    <img src="{{ asset('images\HeroImage.png') }}" class="img-fluid d-lg-none hero-img" alt="Teknisi sedang bekerja">
                    <p class="body-1 color-navy fw-normal mb-4 ">Kami siap membantu mengatasi berbagai masalah pada perangkat Anda, mulai dari laptop standar hingga laptop gaming, dengan layanan profesional dan terpercaya. Percayakan kepada ahlinya!</p>
                    <a href="https://wa.me/6287823330830?text={{ urlencode('Halo, Saya mau konsultasi mengenai layanan ini. mohon bantuannya...') }}" target="_blank" class="btn btn-secondary mb-2">
                        <i class="fab fa-whatsapp me-2"></i>Hubungi Kami Sekarang
                    </a>
                </section>

                <section class="col-lg-5 d-none d-lg-block animate-on-scroll fade-in-right">
                    <img src="{{ asset('images\HeroImage.png') }}" class="img-fluid mb-32 mx-auto d-block hero-img" alt="Teknisi sedang bekerja">
                </section>

            </div>
        </div>
    </header>

    <section id="keunggulan" style="background-image: url('{{ asset('images/Bgkeunggulan.png') }}'); background-size: cover;">
        <div class="container">
            <h2 class="header-2 color-navy fw-bold mb-5 text-center">Kenapa Memilih Kami?</h2>
            <div class="row gy-4">
                <div class="col-6 col-md-6 col-lg-3">
                    <div class="keunggulan-item-box animate-on-scroll fade-in-up">
                        <div class="keunggulan-ic-container flex-shrink-0 me-2 ">
                            <img src="{{ asset('images/garansi.png') }}" class="img-fluid" alt="garansi">
                        </div> 
                        <div>
                            <h3 class="body-1 color-navy fw-bold mb-2">Garansi Service</h3>
                            <p class="body-1 color-navy mb-0">Garansi hingga 30 hari setelah service.</p>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-lg-3">
                    <div class="keunggulan-item-box animate-on-scroll fade-in-up delay-1">
                        <div class="keunggulan-ic-container flex-shrink-0 me-2 ">
                            <img src="{{ asset('images/teknisi.png') }}" class="img-fluid" alt="teknisi">
                        </div>
                        <div>
                            <h3 class="body-1 color-navy fw-bold mb-2">Teknisi Berpengalaman</h3>
                            <p class="body-1 color-navy mb-0">Dikerjakan oleh teknisi profesional.</p>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-lg-3">
                    <div class="keunggulan-item-box animate-on-scroll fade-in-up delay-2">
                        <div class="keunggulan-ic-container flex-shrink-0 me-2">
                            <img src="{{ asset('images/gear.png') }}" class="img-fluid" alt="sparepart">
                        </div>
                        <div>
                            <h3 class="body-1 color-navy fw-bold mb-2">Sparepart Original</h3>
                            <p class="body-1 color-navy mb-0">Hanya menggunakan komponen original.</p>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-lg-3">
                    <div class="keunggulan-item-box animate-on-scroll fade-in-up delay-3">
                        <div class="keunggulan-ic-container flex-shrink-0 me-2">
                            <img src="{{ asset('images/konsul.png') }}" class="img-fluid" alt="konsultasi">
                        </div>
                        <div>
                            <h3 class="body-1 color-navy fw-bold mb-2">Gratis Cek & Konsultasi</h3>
                            <p class="body-1 color-navy mb-0">Konsultasi bebas biaya, langsung WA.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan">
        <div class="container">
            <h2 class="header-2 color-navy fw-bold mb-2 text-center animate-on-scroll fade-in-up">Semua Kebutuhan Service dalam Satu Tempat</h2>
            <p class="body-1 color-navy fw-normal mb-5 text-center animate-on-scroll fade-in-up delay-1">Solusi lengkap untuk semua masalah perangkat elektronik Anda</p>

            <div class="glide-layanan animate-on-scroll fade-in-up delay-2">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        <li class="glide__slide">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('images/hardware.png') }}" class="card-img-top" alt="Service Hardware">
                                <div class="card-body text-center">
                                    <h3 class="card-title header-4 color-navy fw-semibold mb-2">Service Hardware</h3>
                                    <p class="body-1-card color-navy">Ganti LCD, keyboard, upgrade RAM/SSD, dll.</p>
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('images/software.png') }}" class="card-img-top" alt="Service Software">
                                <div class="card-body text-center">
                                    <h3 class="card-title header-4 color-navy fw-semibold mb-2">Service Software</h3>
                                    <p class="body-1-card color-navy">Install ulang, recovery data, pasang antivirus.</p>
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('images/clean.png') }}" class="card-img-top" alt="Maintenance & Cleaning">
                                <div class="card-body text-center">
                                    <h3 class="card-title header-4 color-navy fw-semibold mb-2">Maintenance & Cleaning</h3>
                                    <p class="body-1-card color-navy">Bersihkan laptop dari debu, thermal paste, dll.</p>
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('images/printer.png') }}" class="card-img-top" alt="Service Printer & PC">
                                <div class="card-body text-center">
                                    <h3 class="card-title header-4 color-navy fw-semibold mb-2">Service Printer & PC</h3>
                                    <p class="body-1-card color-navy">Untuk printer rumah/kantor, juga PC rakitan.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                <div class="glide__bullets" data-glide-el="controls[nav]">
                    <button class="glide__bullet" data-glide-dir="=0"></button>
                    <button class="glide__bullet" data-glide-dir="=1"></button>
                    <button class="glide__bullet" data-glide-dir="=2"></button>
                    <button class="glide__bullet" data-glide-dir="=3"></button>
                </div>
            </div>
        </div>
    </section>
 
    <section id="alur" style="background-image: url('{{ asset('images/BGalur.png') }}');">
        <div class="container">
            <div class="row gx-4 gy-4 animate-on-scroll fade-in-left"> 
                <div class="col-lg-4">
                    <h2 class="header-2 color-neutral fw-bold mb-3">3 Langkah Mudah Layanan Kami</h2>
                    <p class="body-1 color-neutral fw-normal">Ikuti alur sederhana kami untuk mendapatkan layanan perbaikan yang cepat dan efisien.</p>
                </div>

                <div class="col-lg-8">
                    <div class="row aligm-items-start gx-4 gy-4">

                        <div class="col-md-4 mb-3 animate-on-scroll fade-in-up">
                            <div class="card border-0 text-center h-100">
                                <div class="card-body p-4">
                                    <div class="justify-content-center d-flex mb-2">
                                        <img src="{{ asset('images\konsultasi.png') }}" class="img-fluid mb-2" alt="konsultasi">
                                    </div>
                                    <h4 class="header-4 color-accent fw-semibold mb-3">Konsultasi Kerusakan</h4>
                                    <p class="body-1-card color-navy">Hubungi kami dan sampaikan masalah yang terjadi pada perangkat Anda</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3 animate-on-scroll fade-in-up delay-1">
                            <div class="card border-0 text-center h-100">
                                <div class="card-body p-4">
                                    <div class="justify-content-center d-flex mb-2">
                                        <img src="{{ asset('images\pengerjaan.png') }}" class="img-fluid mb-2" alt="pengerjaan teknisi">
                                    </div>
                                    <h4 class="header-4 color-accent fw-semibold mb-3">Pengerjaan Teknisi</h4>
                                    <p class="body-1-card color-navy">Teknisi ahli kami akan segera menganalisa dan memperbaiki masalahnya.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3 animate-on-scroll fade-in-up delay-2">
                            <div class="card border-0 text-center h-100">
                                <div class="card-body p-4">
                                    <div class="justify-content-center d-flex mb-2">
                                        <img src="{{ asset('images\selesai.png') }}" class="img-fluid mb-2" alt="unit siap diambil">
                                    </div>
                                    <h4 class="header-4 color-accent fw-semibold mb-3">Unit Siap Diambil</h4>
                                    <p class="body-1-card color-navy">Kami akan menghubungi Anda jika perangkat sudah selesai diperbaiki.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="proses">
        <div class="container">
            <div class="row gx-4 gy-4 justify-content-center">
                <div class="col-lg-6 col-md-6 animate-on-scroll fade-in-left">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <h4 class="card-title header-4 color-navy fw-semibold mb-4 text-center">Lihat Proses Pengerjaan Teknisi Kami</h4>
                            <div class="embed-responsive embed-responsive-16by9 justify-content-center d-flex mb-2">
                                <iframe class="embed-responsive-item mb-3" src="https://www.youtube.com/embed/OBBMF_9oD5g?si=G8AqVrmW8rOFdgIJ" allowfullscreen></iframe>
                            </div>
                            <p class="body-1-card color-navy text-center mb-0">Video menunjukkan proses service laptop secara profesional dan transparan</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 animate-on-scroll fade-in-right">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <h4 class="card-title header-4 color-navy fw-semibold mb-4 text-center">Lihat Proses Pengerjaan Teknisi Kami</h4>
                            <div class="embed-responsive embed-responsive-16by9 justify-content-center d-flex mb-2">
                                <iframe class="embed-responsive-item mb-3" src="https://www.youtube.com/embed/3edtMfPl_kM?si=InXH8nmx5KUx2XbN" allowfullscreen></iframe>
                            </div>
                            <p class="body-1-card color-navy text-center mb-0">Video menunjukkan proses service laptop secara profesional dan transparan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="promo">
        <div class="container">
            <h2 class="header-2 color-navy fw-bold mb-2 text-center">Promo Spesial Bulan Ini</h2>
            <p class="body-1 color-navy fw-normal mb-5 text-center">Penawaran Terbatas Untuk Anda!</p>
            <div class="row gx-4 gy-4 justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <div class="card shadow">
                        <img class="card-img-top" src="{{ asset('images\diskon1.png') }}" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="header-2 color-navy fw-bold text-center mb-3">Hemat hingga 20% untuk Maintenance Rutin</h4>
                            <p class="body-1-card color-navy text-center mb-3">Rawat laptop Anda secara berkala dan dapatkan diskon menarik untuk setiap kunjungan ke-2 dan seterusnya.</p>
                            <ul class="body-1-card color-navy mb-5">
                                <li>Pembersihan menyeluruh sistem</li>
                                <li>Update software terbaru</li>
                                <li>Optimasi performa</li>
                                <li>Garansi layanan 30 hari</li>
                            </ul>
                            <div class="d-grid">
                                <a href="https://wa.me/6287823330830?text={{ urlencode('*PROMO MAINTENANCE RUTIN*

Halo, saya tertarik dengan promo maintenance rutin yang menawarkan hemat hingga 20%.

Saya ingin mengetahui lebih lanjut tentang:
• Pembersihan menyeluruh sistem
• Update software terbaru
• Optimasi performa
• Garansi layanan 30 hari

Mohon informasi jadwal dan estimasi biaya. Terima kasih!') }}" target="_blank" class="btn btn-primary mb-0">Jadwalkan Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="card shadow">
                        <img class="card-img-top" src="{{ asset('images\diskon2.png') }}" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="header-2 color-navy fw-bold mb-3 text-center">Voucher Khusus untuk Perusahaan</h4>
                            <p class="body-1-card color-navy mb-3 text-center">Kami menyediakan voucher service dan layanan on-site untuk kebutuhan kantor dan perusahaan Anda.</p>
                            <ul class="body-1-card color-navy mb-5">
                                <li>Layanan on-site gratis</li>
                                <li>Harga khusus untuk bulk service</li>
                                <li>Support teknis 24/7</li>
                                <li>Maintenance kontrak tahunan</li>
                            </ul>
                            <div class="d-grid">
                                <a href="https://wa.me/6287823330830?text={{ urlencode('*VOUCHER PERUSAHAAN*

Halo, saya mewakili perusahaan yang tertarik dengan voucher khusus untuk layanan corporate.

Kami membutuhkan informasi tentang:
• Layanan on-site gratis
• Harga khusus untuk bulk service
• Support teknis 24/7
• Maintenance kontrak tahunan

Mohon tim corporate menghubungi kami untuk diskusi lebih lanjut. Terima kasih!') }}" target="_blank" class="btn btn-primary mb-0">Hubungi Tim Corporate</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimoni"style="background-image: url('{{ asset('images/BGtesti.png') }}'); ">
        <div class="container">
            <h2 class="header-2 color-neutral fw-bold mb-5 text-center animate-on-scroll fade-in-up">Apa Kata Pelanggan Kami?</h2>

            <div class="glide-testimoni animate-on-scroll fade-in-up delay-1">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        <li class="glide__slide">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('images/sari.png') }}" class="card-img-top" alt="Testimoni Sari">
                                <div class="card-body text-center">
                                    <div class="text-warning mb-2">
                                        <i class="fas fa-star me-1"></i><i class="fas fa-star me-1"></i><i class="fas fa-star me-1"></i><i class="fas fa-star me-1"></i><i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="card-title header-4 color-navy fw-semibold mb-1">Sari Indrawati</h4>
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('images/rizky.png') }}" class="card-img-top" alt="Testimoni Rizky">
                                <div class="card-body text-center">
                                    <div class="text-warning mb-2">
                                        <i class="fas fa-star me-1"></i><i class="fas fa-star me-1"></i><i class="fas fa-star me-1"></i><i class="fas fa-star me-1"></i><i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="card-title header-4 color-navy fw-semibold mb-1">Rizky Pratama</h4>
                                </div>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('images/athar.png') }}" class="card-img-top" alt="Testimoni Athar">
                                <div class="card-body text-center">
                                    <div class="text-warning mb-2">
                                        <i class="fas fa-star me-1"></i><i class="fas fa-star me-1"></i><i class="fas fa-star me-1"></i><i class="fas fa-star me-1"></i><i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="card-title header-4 color-navy fw-semibold mb-1">Athar Hilman</h4>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-arrow-left"></i></button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-arrow-right"></i></button>
                </div>
                <div class="glide__bullets" data-glide-el="controls[nav]">
                    <button class="glide__bullet" data-glide-dir="=0"></button>
                    <button class="glide__bullet" data-glide-dir="=1"></button>
                    <button class="glide__bullet" data-glide-dir="=2"></button>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang-kami">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-lg-6 d-none d-lg-block animate-on-scroll fade-in-left">
                    <img src="{{ asset('images\aboutUS.png') }}" class="img-fluid tim-img" alt="Tim Teknisi">
                </div>
                <div class="col-lg-6 animate-on-scroll fade-in-right">
                    <h2 class="header-2 color-navy fw-bold mb-3">Tentang Kami</h2>
                    <img src="{{ asset('images\aboutUS.png') }}" class="img-fluid d-lg-none tim-img mb-3" alt="Teknisi sedang bekerja">
                    <p class="body-1 color-navy">Kami adalah tim teknisi laptop profesional yang berdedikasi untuk memberikan layanan terbaik sejak 2010. Dengan pengalaman bertahun-tahun dan ribuan laptop yang telah kami tangani, kami mengutamakan kejujuran, transparansi, dan kualitas.</p>
                    <p class="body-1 color-navy">Kami percaya bahwa laptop Anda bukan sekadar alat kerja, tapi aset penting yang harus dijaga. Setiap perangkat memiliki cerita dan memori berharga bagi pemiliknya. Itulah mengapa kami memperlakukan setiap perbaikan dengan penuh perhatian dan profesionalisme.</p>
                    <p class="body-1 color-navy">Tim kami terdiri dari teknisi bersertifikat yang terus mengikuti perkembangan teknologi terbaru. Kami menggunakan alat diagnostik mutakhir dan komponen berkualitas tinggi untuk memastikan laptop Anda kembali berfungsi optimal.</p>
                    <ul class="body-1-card color-navy mb-3">
                        <li><b>Kejujuran - </b>Diagnosa masalah yang transparan tanpa biaya tersembunyi.</li>
                        <li><b>Profesionalisme - </b>Teknisi bersertifikasi dengan pelatihan berkala.</li>
                        <li><b>Garansi - </b>Jaminan 90 hari untuk setiap perbaikan.</li>
                        <li><b>Efisiensi - </b>Waktu perbaikan cepat tanpa mengorbankan kualitas.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="cta-penutup" style="background-image: url('{{ asset('images/BGalur.png') }}'); ">
        <div class="container text-center">
            <h1 class="header-2 fw-bold mb-4">Jangan tunggu kerusakan makin parah, segera hubungi kami sekarang!</h1>
        </div>
    </section>

    <section id="kontak">
        <div class="container">
            <h2 class="header-2 color-navy fw-bold mb-1 text-center">Hubungi Kami</h2>
            <p class="body-1 color-navy fw-normal mb-5 text-center">Hubungi kami untuk pemesanan layanan service atau kunjungi workshop kami untuk perbaikan langsung</p>
            <div class="row gy-5 justify-content-center">
                <div class="col-lg-5 animate-on-scroll fade-in-left">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="header-4 color-navy fw-semibold text-center mb-5">Formulir Pemesanan Service</h3>
                            <form id="service-order-form" method="POST" action="{{ route('front.service-order.store') }}">
                                @csrf
                                
                                {{-- Baris Nama dan Nomor HP --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label color-navy fw-medium">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control" id="name" required placeholder="Contoh: Rizky Maulana">
                                        <div class="invalid-feedback" id="error-name"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label color-navy fw-medium">Nomor HP / WhatsApp</label>
                                        <input type="tel" name="phone" class="form-control" id="phone" required placeholder="Contoh: 081234567890">
                                        <div class="invalid-feedback" id="error-phone"></div>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label color-navy fw-medium">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" required placeholder="Contoh: rizky@mail.com">
                                    <div class="invalid-feedback" id="error-email"></div>
                                </div>

                                <p class="body-1 color-navy fw-semibold mb-3 mt-3">Alamat</p>

                                {{-- Baris Alamat (Provinsi, Kabupaten/Kota) --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="province_id" class="form-label color-navy fw-medium">Provinsi</label>
                                        <select name="province_id" id="province_id" class="form-select" required>
                                            <option value="">Pilih Provinsi...</option>
                                            @if(isset($provinces))
                                                @foreach($provinces as $province)
                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="invalid-feedback" id="error-province_id"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="regency_id" class="form-label color-navy fw-medium">Kabupaten/Kota</label>
                                        <select name="regency_id" id="regency_id" class="form-select" required disabled>
                                            <option value="">Pilih Kabupaten/Kota...</option>
                                        </select>
                                        <div class="invalid-feedback" id="error-regency_id"></div>
                                    </div>
                                </div>

                                {{-- Baris Alamat (Kecamatan, Kelurahan/Desa) --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="district_id" class="form-label color-navy fw-medium">Kecamatan</label>
                                        <select name="district_id" id="district_id" class="form-select" disabled>
                                            <option value="">Pilih Kecamatan... (Opsional)</option>
                                        </select>
                                        <div class="invalid-feedback" id="error-district_id"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="village_id" class="form-label color-navy fw-medium">Desa/Kelurahan</label>
                                        <select name="village_id" id="village_id" class="form-select" disabled>
                                            <option value="">Pilih Desa/Kelurahan... (Opsional)</option>
                                        </select>
                                        <div class="invalid-feedback" id="error-village_id"></div>
                                    </div>
                                </div>
                                
                                {{-- Detail Alamat --}}
                                <div class="mb-3">
                                    <label for="street_address" class="form-label color-navy fw-medium">Detail alamat</label>
                                    <textarea name="street_address" class="form-control" id="street_address" rows="3" required placeholder="Tulis nama jalan, nomor rumah, RT/RW, blok, patokan, dll."></textarea>
                                    <div class="invalid-feedback" id="error-street_address"></div>
                                </div>

                                {{-- Hidden field untuk alamat lengkap --}}
                                <input type="hidden" name="address" id="address_hidden" value="">

                                <p class="body-1 color-navy fw-semibold mb-3 mt-3">Detail Perangkat</p>

                                {{-- Baris Merk dan Model Perangkat --}}
                                <div class="row">
                                    <div class="col-md-6 mb-0">
                                        <label for="brand" class="form-label color-navy fw-medium">Merk Perangkat</label>
                                        <select name="brand" id="brand" class="form-select" required>
                                            <option value="">Pilih merk Perangkat</option>
                                            @if(isset($brands) && $brands->count())
                                                @foreach($brands as $brandOption)
                                                    <option value="{{ $brandOption }}">{{ $brandOption }}</option>
                                                @endforeach
                                            @else
                                                {{-- Fallback to common brands if DB has none --}}
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
                                    </div>
                                    <div class="col-md-6 mb-0">
                                        <label for="model" class="form-label color-navy fw-medium">Model / Series</label>
                                        <input type="text" name="model" class="form-control" id="model" required placeholder="Contoh: Vivobook A416MA">
                                        <div class="invalid-feedback" id="error-model"></div>
                                    </div>
                                    <small class="form-text" style="color: #9ca3af; font-size: 0.8rem;"> Jika Merk perangkat anda tidak ada, Pilih Opsi Lainnya.
                                    </small>
                                </div>

                                {{-- Nomor Seri --}}
                                <div class="mb-3 mt-3">
                                    <label for="serial_number" class="form-label color-navy fw-medium">Nomor Seri Perangkat</label>
                                    <input type="text" name="serial_number" class="form-control" id="serial_number" required placeholder="Contoh: SN1234567890">
                                    <div class="invalid-feedback" id="error-serial_number"></div>
                                    <small class="form-text text-muted" style="font-size: 0.8rem;">Biasanya terdapat di bagian bawah laptop atau dalam menu About This PC/Mac</small>
                                </div>
                                
                                {{-- Keluhan --}}
                                <div class="mb-3">
                                    <label for="reported_issue" class="form-label color-navy fw-medium">Keluhan / Kerusakan</label>
                                    <textarea name="reported_issue" class="form-control" id="reported_issue" rows="3" required placeholder="Contoh: Laptop tiba-tiba mati total saat digunakan"></textarea>
                                    <div class="invalid-feedback" id="error-reported_issue"></div>
                                    <small class="form-text" style="color: #9ca3af; font-size: 0.8rem;"> Jelaskan sedetail mungkin masalah yang dialami
                                    </small>
                                </div>

                                {{-- Tombol Submit --}}
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary" id="submit-btn">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim Permintaan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 animate-on-scroll fade-in-right">
                    <h3 class="header-4 color-navy fw-semibold mb-4">Informasi Kontak</h3>
                    <div class="d-flex mb-3">
                        <i class="fab fa-whatsapp fa-2x color-accent me-2"></i>
                        <div>
                            <h4 class="header-4 color-navy fw-semibold mb-1">WhatsApp</h4>
                            <a href="https://wa.me/6281234567890" target="_blank" class="body-1-card text-decoration-none color-navy">+62 812-3456-7890</a>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="far fa-envelope fa-2x color-accent me-2"></i>
                        <div>
                            <h4 class="header-4 color-navy fw-semibold mb-1">Email</h4>
                            <p class="body-1-card color-navy mb-0">support@servicelaptop.com</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class="fas fa-map-marker-alt fa-2x color-accent me-3"></i>
                        <div>
                            <h4 class="header-4 color-navy fw-semibold mb-1">Lokasi</h4>
                            <p class="body-1-card color-navy mb-3">
                                Jalan traktor 123 dekat cicukang belakang kantor PU ujung berung, Kec. Arcamanik, Kota Bandung, Jawa Barat 42094
                            </p>
                        </div>
                    </div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8093.253222490186!2d107.67920589074849!3d-6.915002802991967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dda5a21cc6bb%3A0xb7248e14780c4720!2sCV%20Lingkar%20Rasio%20Teknologi!5e0!3m2!1sid!2sid!4v1755229414217!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
    
    @push('css')
        @vite(['resources/css/client/pages/home/styles.css'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new Glide('.glide-layanan', {
                    type: 'carousel',
                    startAt: 0,
                    perView: 3,
                    gap: 5,
                    autoplay: 3500,
                    hoverpause: true,
                    breakpoints: {
                        992: { perView: 2 },
                        768: { perView: 1 }
                    }
                }).mount();

                new Glide('.glide-testimoni', {
                    type: 'carousel',
                    startAt: 0,
                    perView: 3,
                    gap: 8,
                    autoplay: 3500,
                    hoverpause: true,
                    breakpoints: {
                        992: { perView: 2 },
                        768: { perView: 1 }
                    }
                }).mount();
            });
            // Animasi On-Scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, {
                threshold: 0.1 
            });

            const elementsToAnimate = document.querySelectorAll('.animate-on-scroll');
            elementsToAnimate.forEach((el) => observer.observe(el));

            // Service Order Form Handler
            const serviceOrderForm = document.getElementById('service-order-form');
            const submitBtn = document.getElementById('submit-btn');

            if (serviceOrderForm) {
                serviceOrderForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Clear previous errors
                    clearErrors();
                    
                    // Show confirmation dialog
                    Swal.fire({
                        title: 'Konfirmasi Pengiriman',
                        text: 'Apakah Anda yakin ingin mengirim permintaan service ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: 'Ya, Kirim!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            submitForm();
                        }
                    });
                });
            }

            function submitForm() {
                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
                
                // Get form data
                const formData = new FormData(serviceOrderForm);
                
                // Submit via AJAX
                fetch(serviceOrderForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 422) {
                            // Validation error
                            return response.json().then(errorData => {
                                throw { type: 'validation', errors: errorData.errors };
                            });
                        } else {
                            throw { type: 'server', message: 'Server error occurred' };
                        }
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // If server provided a WhatsApp URL, offer to open it
                        if (data.wa_url) {
                            Swal.fire({
                                title: 'Permintaan Terkirim',
                                html: `
                                    <p>${data.message}</p>
                                    <p class="mt-2"><strong>Nomor Nota: ${data.nota_number}</strong></p>
                                    <p class="text-muted">Anda dapat melanjutkan transaksi lewat WhatsApp.</p>
                                `,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Buka WhatsApp',
                                cancelButtonText: 'Tutup',
                                confirmButtonColor: '#25D366'
                            }).then((res) => {
                                if (res.isConfirmed) {
                                    window.open(data.wa_url, '_blank');
                                }
                                serviceOrderForm.reset();
                            });
                        } else {
                            // Show simple success
                            Swal.fire({
                                title: 'Berhasil!',
                                html: `
                                    <p>${data.message}</p>
                                    <p class="mt-2"><strong>Nomor Nota: ${data.nota_number}</strong></p>
                                    <p class="text-muted">Simpan nomor nota ini untuk referensi Anda.</p>
                                `,
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                serviceOrderForm.reset();
                            });
                        }
                    } else {
                        // Show error message
                        Swal.fire({
                            title: 'Gagal!',
                            text: data.message || 'Terjadi kesalahan saat mengirim permintaan.',
                            icon: 'error',
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Handle validation errors
                    if (error.type === 'validation') {
                        showValidationErrors(error.errors);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                            icon: 'error',
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .finally(() => {
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Permintaan';
                });
            }

            function showValidationErrors(errors) {
                Object.keys(errors).forEach(field => {
                    const errorElement = document.getElementById(`error-${field}`);
                    const inputElement = document.getElementById(field) || document.querySelector(`[name="${field}"]`);
                    
                    if (errorElement && inputElement) {
                        errorElement.textContent = errors[field][0];
                        errorElement.style.display = 'block';
                        inputElement.classList.add('is-invalid');
                    }
                });
                
                // Scroll to first error
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }

            function clearErrors() {
                // Clear all error messages
                document.querySelectorAll('[id^="error-"]').forEach(element => {
                    element.textContent = '';
                    element.style.display = 'none';
                });
                
                // Remove invalid classes
                document.querySelectorAll('.is-invalid').forEach(element => {
                    element.classList.remove('is-invalid');
                });
            }

            // IndoRegion Cascading Dropdown Handler
            const regenciesData = @json(\App\Models\Regency::with('province')->get()->groupBy('province_id'));
            const districtsData = @json(\App\Models\District::with('regency')->get()->groupBy('regency_id'));
            const villagesData = @json(\App\Models\Village::with('district')->get()->groupBy('district_id'));

            // Province change handler
            document.getElementById('province_id').addEventListener('change', function() {
                const provinceId = this.value;
                const regencySelect = document.getElementById('regency_id');
                const districtSelect = document.getElementById('district_id');
                const villageSelect = document.getElementById('village_id');
                
                // Clear regency, district, and village
                regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota...</option>';
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan... (Opsional)</option>';
                villageSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan... (Opsional)</option>';
                
                // Disable dependent dropdowns
                regencySelect.disabled = true;
                districtSelect.disabled = true;
                villageSelect.disabled = true;
                
                if (provinceId && regenciesData[provinceId]) {
                    // Populate regencies
                    regenciesData[provinceId].forEach(function(regency) {
                        regencySelect.innerHTML += `<option value="${regency.id}">${regency.name}</option>`;
                    });
                    regencySelect.disabled = false;
                }
                updateAddressField();
            });

            // Regency change handler
            document.getElementById('regency_id').addEventListener('change', function() {
                const regencyId = this.value;
                const districtSelect = document.getElementById('district_id');
                const villageSelect = document.getElementById('village_id');
                
                // Clear districts and villages
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan... (Opsional)</option>';
                villageSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan... (Opsional)</option>';
                
                // Disable dependent dropdowns
                districtSelect.disabled = true;
                villageSelect.disabled = true;
                
                if (regencyId && districtsData[regencyId]) {
                    // Populate districts
                    districtsData[regencyId].forEach(function(district) {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    });
                    districtSelect.disabled = false;
                }
                updateAddressField();
            });

            // District change handler
            document.getElementById('district_id').addEventListener('change', function() {
                const districtId = this.value;
                const villageSelect = document.getElementById('village_id');
                
                // Clear villages
                villageSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan... (Opsional)</option>';
                villageSelect.disabled = true;
                
                if (districtId && villagesData[districtId]) {
                    // Populate villages
                    villagesData[districtId].forEach(function(village) {
                        villageSelect.innerHTML += `<option value="${village.id}">${village.name}</option>`;
                    });
                    villageSelect.disabled = false;
                }
                updateAddressField();
            });

            // Village change handler
            document.getElementById('village_id').addEventListener('change', function() {
                updateAddressField();
            });

            // Street address change handler
            document.getElementById('street_address').addEventListener('input', function() {
                updateAddressField();
            });

            // Function to update hidden address field with combined address
            function updateAddressField() {
                const provinceSelect = document.getElementById('province_id');
                const regencySelect = document.getElementById('regency_id');
                const districtSelect = document.getElementById('district_id');
                const villageSelect = document.getElementById('village_id');
                const streetAddress = document.getElementById('street_address').value;
                const hiddenAddress = document.getElementById('address_hidden');
                
                let addressParts = [];
                
                if (streetAddress) {
                    addressParts.push(streetAddress);
                }
                
                if (villageSelect.value && villageSelect.selectedOptions[0]) {
                    addressParts.push(villageSelect.selectedOptions[0].text);
                }
                
                if (districtSelect.value && districtSelect.selectedOptions[0]) {
                    addressParts.push(districtSelect.selectedOptions[0].text);
                }
                
                if (regencySelect.value && regencySelect.selectedOptions[0]) {
                    addressParts.push(regencySelect.selectedOptions[0].text);
                }
                
                if (provinceSelect.value && provinceSelect.selectedOptions[0]) {
                    addressParts.push(provinceSelect.selectedOptions[0].text);
                }
                
                hiddenAddress.value = addressParts.join(', ');
            }
        </script>
    @endpush

    <!-- WhatsApp Chatbot Section -->
    <section id="whatsapp-chatbot">
        <!-- Floating WhatsApp Button -->
        <div id="wa-float-btn" title="Chat WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </div>

        <!-- Chatbot Modal -->
        <div id="wa-chatbot-modal">
            <div id="wa-chatbot-header">
                <div>
                    <div style="font-size: 1.1rem;">LASO</div>
                    <div style="font-size: 0.8rem; opacity: 0.8;">LaptopService Assistant</div>
                </div>
                <button id="wa-chatbot-close" title="Tutup">&times;</button>
            </div>
            
            <div id="wa-chatbot-messages">
                <!-- Messages will be added here dynamically -->
            </div>

            <div class="chat-input-form" id="chat-input-area" style="display: none;">
                <form id="chat-data-form">
                    <div id="chat-form-fields"></div>
                    <button type="submit" class="chat-send-btn" id="default-submit-btn">Kirim Data</button>
                </form>
            </div>
        </div>

        <!-- Chatbot JavaScript -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const waBtn = document.getElementById('wa-float-btn');
            const waModal = document.getElementById('wa-chatbot-modal');
            const waClose = document.getElementById('wa-chatbot-close');
            const messagesContainer = document.getElementById('wa-chatbot-messages');
            const chatInputArea = document.getElementById('chat-input-area');
            const chatFormFields = document.getElementById('chat-form-fields');
            const chatDataForm = document.getElementById('chat-data-form');
            
            // State management with localStorage persistence
            let currentStep = 'start';
            let userInputs = {};
            
            // Load saved state from localStorage
            function loadChatState() {
                try {
                    const savedState = localStorage.getItem('chatbot_state');
                    const savedMessages = localStorage.getItem('chatbot_messages');
                    
                    if (savedState) {
                        const state = JSON.parse(savedState);
                        currentStep = state.currentStep || 'start';
                        userInputs = state.userInputs || {};
                        console.log('Loaded chat state:', state);
                    }
                    
                    if (savedMessages && savedMessages.trim() !== '') {
                        const messages = JSON.parse(savedMessages);
                        if (messages && messages.trim() !== '') {
                            messagesContainer.innerHTML = messages;
                            console.log('Loaded saved messages');
                            return true; // Has existing messages
                        }
                    }
                } catch (error) {
                    console.log('Error loading chat state:', error);
                    // Reset to default if error
                    currentStep = 'start';
                    userInputs = {};
                    clearChatState(); // Clear corrupted data
                }
                return false; // No existing messages
            }
            
            // Save state to localStorage
            function saveChatState() {
                try {
                    const state = {
                        currentStep: currentStep,
                        userInputs: userInputs
                    };
                    localStorage.setItem('chatbot_state', JSON.stringify(state));
                    
                    // Only save messages if container has content
                    if (messagesContainer && messagesContainer.innerHTML.trim()) {
                        localStorage.setItem('chatbot_messages', JSON.stringify(messagesContainer.innerHTML));
                    }
                    console.log('Chat state saved');
                } catch (error) {
                    console.log('Error saving chat state:', error);
                    // If localStorage is full or corrupted, clear it
                    if (error.name === 'QuotaExceededError') {
                        clearChatState();
                    }
                }
            }
            
            // Clear saved state (only on manual reset)
            function clearChatState() {
                try {
                    localStorage.removeItem('chatbot_state');
                    localStorage.removeItem('chatbot_messages');
                    console.log('Chat state cleared');
                } catch (error) {
                    console.log('Error clearing chat state:', error);
                }
            }
            
            // Emergency function to force reset chatbot (for debugging)
            window.resetChatbot = function() {
                console.log('Force resetting chatbot...');
                clearChatState();
                messagesContainer.innerHTML = '';
                currentStep = 'start';
                userInputs = {};
                chatInputArea.style.display = 'none';
                
                // Close chatbot first
                closeChatbot();
                
                // Re-initialize with fresh state after short delay
                setTimeout(() => {
                    openChatbot();
                }, 500);
            };
            
            // Initialize
            waBtn.onclick = () => { 
                toggleChatbot();
            };
            waClose.onclick = () => { 
                closeChatbot();
            };
            
            // Toggle chatbot function
            function toggleChatbot() {
                if (waModal.style.display === 'flex') {
                    closeChatbot();
                } else {
                    openChatbot();
                }
            }
            
            // Open chatbot with animation
            function openChatbot() {
                waModal.style.display = 'flex';
                waModal.style.opacity = '0';
                waModal.style.transform = 'translateY(20px) scale(0.95)';
                
                // Trigger opening animation
                setTimeout(() => {
                    waModal.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                    waModal.style.opacity = '1';
                    waModal.style.transform = 'translateY(0) scale(1)';
                }, 10);
                
                klikWa();
                initializeChat();
            }
            
            // Close chatbot with animation
            function closeChatbot() {
                waModal.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                waModal.style.opacity = '0';
                waModal.style.transform = 'translateY(20px) scale(0.95)';
                
                // Hide modal after animation
                setTimeout(() => {
                    waModal.style.display = 'none';
                    waModal.style.transition = '';
                }, 300);
                
                // Save current state when closing
                saveChatState();
            }

            function klikWa() {
                let csrf_token = document.querySelector("meta[name=csrf-token]");
                if (csrf_token) {
                    fetch("/klik-wa", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrf_token.getAttribute("content")
                        },
                        body: JSON.stringify({})
                    }).catch(error => {
                        console.log('klik-wa route not found, continuing anyway'); // Route optional
                    });
                }
            }

            function initializeChat() {
                console.log('Initializing chat...');
                
                // Load existing state first
                const hasExistingMessages = loadChatState();
                
                // If no existing messages, start fresh
                if (!hasExistingMessages) {
                    console.log('No existing messages, starting fresh chat');
                    messagesContainer.innerHTML = ''; // Clear any corrupted content
                    
                    setTimeout(() => {
                        addBotMessage('Halo! Saya LASO, asisten virtual LaptopService 👋');
                        setTimeout(() => {
                            addBotMessage('Saya siap membantu Anda dengan layanan service laptop profesional. Ada yang bisa saya bantu?', true, [
                                {text: 'Service Laptop', action: 'service_laptop'},
                                {text: 'Hubungi Langsung', action: 'direct_contact'}
                            ]);
                        }, 1500);
                    }, 500);
                } else {
                    console.log('Found existing messages, restoring chat');
                    // Re-attach event listeners to existing buttons
                    reattachButtonListeners();
                }
                
                // Always scroll to bottom when opening
                setTimeout(() => {
                    scrollToBottom();
                }, 100);
            }
            
            // Function to reattach event listeners to existing option buttons
            function reattachButtonListeners() {
                const optionButtons = document.querySelectorAll('.chat-option-btn');
                optionButtons.forEach(btn => {
                    const action = btn.dataset.action;
                    const text = btn.textContent;
                    btn.onclick = () => handleOptionClick(action, text);
                });
                
                // Re-apply animations to restored messages
                const messages = document.querySelectorAll('.chat-message');
                messages.forEach((msg, index) => {
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateY(10px)';
                    setTimeout(() => {
                        msg.style.opacity = '1';
                        msg.style.transform = 'translateY(0)';
                    }, index * 100); // Stagger animation
                });
            }

            function addBotMessage(text, hasOptions = false, options = []) {
                const messageDiv = document.createElement('div');
                messageDiv.className = 'chat-message bot';
                
                const bubbleDiv = document.createElement('div');
                bubbleDiv.className = 'chat-bubble bot';
                bubbleDiv.innerHTML = text;
                
                if (hasOptions && options.length > 0) {
                    const optionsDiv = document.createElement('div');
                    optionsDiv.className = 'chat-options';
                    options.forEach(option => {
                        const btn = document.createElement('button');
                        btn.className = 'chat-option-btn';
                        btn.textContent = option.text;
                        btn.dataset.action = option.action;
                        btn.onclick = () => handleOptionClick(option.action, option.text);
                        optionsDiv.appendChild(btn);
                    });
                    bubbleDiv.appendChild(optionsDiv);
                }
                
                messageDiv.appendChild(bubbleDiv);
                messagesContainer.appendChild(messageDiv);
                
                // Trigger animation
                setTimeout(() => {
                    messageDiv.style.opacity = '1';
                    messageDiv.style.transform = 'translateY(0)';
                }, 50);
                
                scrollToBottom();
                
                // Save state after adding message
                saveChatState();
            }

            function addUserMessage(text) {
                const messageDiv = document.createElement('div');
                messageDiv.className = 'chat-message user';
                
                const bubbleDiv = document.createElement('div');
                bubbleDiv.className = 'chat-bubble user';
                bubbleDiv.textContent = text;
                
                messageDiv.appendChild(bubbleDiv);
                messagesContainer.appendChild(messageDiv);
                
                // Trigger animation
                setTimeout(() => {
                    messageDiv.style.opacity = '1';
                    messageDiv.style.transform = 'translateY(0)';
                }, 50);
                
                scrollToBottom();
                
                // Save state after adding message
                saveChatState();
            }

            function handleOptionClick(action, selectedText) {
                // Add user selection as message
                addUserMessage(selectedText);
                
                // Remove all option buttons
                document.querySelectorAll('.chat-options').forEach(el => el.remove());
                
                if (action === 'service_laptop') {
                    setTimeout(() => {
                        addBotMessage('Sip! Mari kita bantu service laptop Anda. Pertama, apa keluhan atau masalah pada laptop Anda?');
                        showInputForm('reported_issue');
                    }, 1000);
                } else if (action === 'direct_contact') {
                    setTimeout(() => {
                        addBotMessage('Baik! Silakan hubungi kami langsung melalui WhatsApp untuk konsultasi lebih lanjut.');
                        sendToWhatsApp('Halo, saya ingin konsultasi mengenai layanan service laptop.');
                    }, 1000);
                } else if (action === 'promo_maintenance') {
                    setTimeout(() => {
                        addBotMessage('🎉 Promo Maintenance Rutin! Hemat hingga 20% untuk perawatan berkala:\n\n• Pembersihan menyeluruh sistem\n• Update software terbaru\n• Optimasi performa\n• Garansi layanan 30 hari\n\nMau langsung booking maintenance atau lanjut service biasa?', true, [
                            {text: '📅 Booking Maintenance', action: 'booking_maintenance'},
                            {text: '🔧 Lanjut Service Biasa', action: 'skip_promo'}
                        ]);
                    }, 1000);
                } else if (action === 'promo_corporate') {
                    setTimeout(() => {
                        addBotMessage('🏢 Voucher Perusahaan! Khusus untuk kebutuhan kantor:\n\n• Layanan on-site gratis\n• Harga khusus untuk bulk service\n• Support teknis 24/7\n• Maintenance kontrak tahunan\n\nMau konsultasi corporate atau lanjut service individu?', true, [
                            {text: '💼 Konsultasi Corporate', action: 'corporate_consultation'},
                            {text: '👤 Service Individu', action: 'skip_promo'}
                        ]);
                    }, 1000);
                } else if (action === 'booking_maintenance') {
                    setTimeout(() => {
                        addBotMessage('Mantap! Mari kita booking maintenance rutin. Apa keluhan atau yang ingin di-maintenance?');
                        showInputForm('reported_issue');
                        userInputs.serviceType = 'maintenance';
                    }, 1000);
                } else if (action === 'corporate_consultation') {
                    setTimeout(() => {
                        addBotMessage('Terima kasih! Untuk konsultasi corporate, saya akan hubungkan dengan tim khusus kami.');
                        sendToWhatsApp('*KONSULTASI CORPORATE*\n\nHalo, saya mewakili perusahaan yang tertarik dengan voucher khusus untuk layanan corporate.\n\nKami membutuhkan informasi tentang:\n• Layanan on-site gratis\n• Harga khusus untuk bulk service\n• Support teknis 24/7\n• Maintenance kontrak tahunan\n\nMohon tim corporate menghubungi kami untuk diskusi lebih lanjut. Terima kasih!');
                    }, 1000);
                } else if (action === 'skip_promo') {
                    setTimeout(() => {
                        addBotMessage('Oke, mari kita lanjut untuk service laptop. Apa keluhan atau masalah pada laptop Anda?');
                        showInputForm('reported_issue');
                    }, 1000);
                } else if (action === 'laptop_on' || action === 'laptop_partially' || action === 'laptop_off') {
                    let conditionText = '';
                    let responseMessage = '';
                    
                    if (action === 'laptop_on') {
                        conditionText = 'Masih menyala normal';
                        responseMessage = 'Bagus sekali! Laptop yang masih menyala memudahkan proses diagnosis dan biasanya lebih cepat selesai 👍';
                    } else if (action === 'laptop_partially') {
                        conditionText = 'Menyala tapi bermasalah';
                        responseMessage = 'Oke, laptop masih hidup tapi ada gangguannya ya. Ini sebenarnya kondisi yang baik untuk diperbaiki 💪';
                    } else {
                        conditionText = 'Tidak bisa menyala';
                        responseMessage = 'Hmm, laptop mati total memang tricky. Tapi tenang, teknisi kami sudah berpengalaman puluhan tahun menangani kasus seperti ini! 🔧';
                    }
                    
                    userInputs.condition = conditionText;
                    
                    setTimeout(() => {
                        addBotMessage(responseMessage);
                        setTimeout(() => {
                            addBotMessage('Sekarang, laptop merek apa yang bermasalah?');
                            showInputForm('brand');
                        }, 1500);
                    }, 1000);
                } else if (action === 'show_promo_maintenance') {
                    setTimeout(() => {
                        addBotMessage('🎉 Promo Maintenance Rutin!\n\nHemat hingga 20% untuk perawatan berkala laptop Anda:\n• Pembersihan menyeluruh sistem\n• Update software terbaru\n• Optimasi performa\n• Garansi layanan 30 hari\n\nApakah Anda tertarik dengan promo ini?', true, [
                            {text: '✅ Ya, Tertarik!', action: 'interested_maintenance'},
                            {text: '⏭️ Tidak, Lanjut Service', action: 'continue_to_name'}
                        ]);
                    }, 1000);
                } else if (action === 'show_promo_corporate') {
                    setTimeout(() => {
                        addBotMessage('🏢 Voucher Perusahaan!\n\nLayanan khusus untuk kebutuhan kantor:\n• Layanan on-site gratis\n• Harga khusus untuk bulk service\n• Support teknis 24/7\n• Maintenance kontrak tahunan\n\nApakah ini untuk kebutuhan perusahaan?', true, [
                            {text: '✅ Ya, Untuk Perusahaan', action: 'corporate_interest'},
                            {text: '👤 Tidak, Service Pribadi', action: 'continue_to_name'}
                        ]);
                    }, 1000);
                } else if (action === 'interested_maintenance') {
                    userInputs.serviceType = 'maintenance';
                    setTimeout(() => {
                        addBotMessage('Bagus! Kami akan catat minat Anda untuk maintenance rutin. Mari lanjut dengan data Anda:');
                        setTimeout(() => {
                            addBotMessage('maaf nih LASO lupa nanya, nama kakak siapa yah?');
                            showInputForm('name');
                        }, 1000);
                    }, 1000);
                } else if (action === 'corporate_interest') {
                    userInputs.serviceType = 'corporate';
                    setTimeout(() => {
                        addBotMessage('Terima kasih! Untuk layanan corporate, tim khusus kami akan menghubungi Anda. Mari kita ambil kontak Anda dulu:');
                        setTimeout(() => {
                            addBotMessage('Siapa nama Anda atau nama perusahaan?');
                            showInputForm('name');
                        }, 1000);
                    }, 1000);
                } else if (action === 'continue_to_name') {
                    setTimeout(() => {
                        addBotMessage('maaf nih LASO lupa nanya, nama kakak siapa yah?');
                        showInputForm('name');
                    }, 1000);
                } else if (action === 'send_whatsapp') {
                    // Langsung redirect ke WhatsApp tanpa delay berlebihan
                    console.log('=== Tombol Kirim ke WA diklik ===');
                    sendToWhatsApp();
                } else if (action === 'copy_message') {
                    // Copy message to clipboard as fallback
                    let message = userInputs.finalMessage || '';
                    if (userInputs.notaNumber) {
                        message += `\n\n*📋 NOMOR NOTA: ${userInputs.notaNumber}*\n`;
                        message += `_Simpan nomor nota ini untuk melacak status pengerjaan laptop Anda di website kami_`;
                    }
                    
                    navigator.clipboard.writeText(message).then(() => {
                        addBotMessage('✅ Pesan berhasil disalin! Silakan paste di WhatsApp manual ke: 087823330830');
                    }).catch(() => {
                        addBotMessage('❌ Gagal copy otomatis. Silakan hubungi WhatsApp: 087823330830');
                    });
                }
            }

            function showInputForm(inputType) {
                let placeholder = '';
                
                switch(inputType) {
                    case 'reported_issue': placeholder = 'Contoh: Laptop tiba-tiba mati total saat digunakan'; break;
                    case 'name': placeholder = 'Masukan nama Anda'; break;
                    case 'phone': placeholder = 'Contoh: 081234567890'; break;
                    case 'brand': placeholder = 'Pilih merek laptop Anda'; break;
                    case 'model': placeholder = 'Masukan type anda'; break;
                    case 'address': placeholder = 'Contoh: Jl. Melati No. 10, RT 03 RW 02, Bandung'; break;
                }
                
                let inputHTML = '';
                if (inputType === 'reported_issue' || inputType === 'address') {
                    inputHTML = `<textarea class="chat-input" placeholder="${placeholder}" id="chat-${inputType}" rows="3" required></textarea>`;
                } else if (inputType === 'brand') {
                    // For brand, show dropdown with data from API
                    inputHTML = `<select class="chat-input" id="chat-${inputType}" required>
                        <option value="">${placeholder}</option>
                        <option value="loading">Loading...</option>
                    </select>`;
                } else {
                    inputHTML = `<input type="text" class="chat-input" placeholder="${placeholder}" id="chat-${inputType}" required>`;
                }
                
                // Special handling for model input - add additional buttons
                let additionalButtons = '';
                if (inputType === 'model') {
                    additionalButtons = `
                        <div class="model-input-options" style="margin-top: 15px; display: flex; gap: 10px; justify-content: center;">
                            <button type="button" class="btn" id="unknown-model-btn" style="
                                background-color: #dc3545; 
                                color: white; 
                                border: none; 
                                padding: 10px 20px; 
                                border-radius: 25px; 
                                font-size: 14px;
                                font-weight: 500;
                                cursor: pointer;
                                transition: all 0.3s ease;
                                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                min-width: 100px;
                            " onmouseover="this.style.backgroundColor='#c82333'; this.style.transform='translateY(-1px)'" 
                               onmouseout="this.style.backgroundColor='#dc3545'; this.style.transform='translateY(0)'">
                                Ngga Tau
                            </button>
                            <button type="submit" class="btn" style="
                                background-color: #007bff; 
                                color: white; 
                                border: none; 
                                padding: 10px 20px; 
                                border-radius: 25px; 
                                font-size: 14px;
                                font-weight: 500;
                                cursor: pointer;
                                transition: all 0.3s ease;
                                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                min-width: 100px;
                            " onmouseover="this.style.backgroundColor='#0056b3'; this.style.transform='translateY(-1px)'" 
                               onmouseout="this.style.backgroundColor='#007bff'; this.style.transform='translateY(0)'">
                                Kirim Data
                            </button>
                        </div>`;
                }
                
                chatFormFields.innerHTML = `
                    <input type="hidden" name="input_type" value="${inputType}">
                    ${inputHTML}
                    ${additionalButtons}
                `;
                chatInputArea.style.display = 'block';
                
                // Hide/show default submit button based on input type
                const defaultSubmitBtn = document.getElementById('default-submit-btn');
                if (inputType === 'model') {
                    // For model input, hide default button since we have custom buttons
                    defaultSubmitBtn.style.display = 'none';
                } else {
                    // For other inputs, show default button
                    defaultSubmitBtn.style.display = 'block';
                }
                
                // If brand dropdown, setup brands with static data
                if (inputType === 'brand') {
                    setupBrands();
                }
                
                // Add event listener for "Ngga Tau" button if this is model input
                if (inputType === 'model') {
                    const unknownBtn = document.getElementById('unknown-model-btn');
                    if (unknownBtn) {
                        unknownBtn.addEventListener('click', function() {
                            // Open YouTube link in new tab
                            window.open('https://www.youtube.com/watch?v=XpgJ8GNt030&t=4s', '_blank');
                            
                            // Add a bot message explaining what to do
                            addBotMessage('Saya sudah membuka video tutorial untuk membantu Anda menemukan type laptop. Setelah menonton, silakan kembali dan masukkan type laptop Anda.');
                        });
                    }
                }
            }

            // Function to setup brands dropdown with database data
            function setupBrands() {
                const brandSelect = document.getElementById('chat-brand');
                brandSelect.innerHTML = '<option value="">Pilih merek laptop Anda</option>';
                
                // Add brands from database
                @foreach($brands as $brand)
                    brandSelect.innerHTML += '<option value="{{ $brand }}">{{ $brand }}</option>';
                @endforeach
                
                // Add "Lainnya" option
                brandSelect.innerHTML += '<option value="Lainnya">Lainnya</option>';
            }
            }

            chatDataForm.onsubmit = function(e) {
                e.preventDefault();
                const fd = new FormData(chatDataForm);
                const inputType = fd.get('input_type');
                let value;
                
                // Handle different input types
                if (inputType === 'brand') {
                    value = document.getElementById(`chat-${inputType}`).value;
                } else {
                    value = document.getElementById(`chat-${inputType}`).value.trim();
                }
                
                if (!value) {
                    alert('Form wajib diisi!');
                    return;
                }
                
                userInputs[inputType] = value;
                
                // Save state after user input
                saveChatState();
                
                // Add user message
                addUserMessage(value);
                
                // Hide input form
                chatInputArea.style.display = 'none';
                
                // Continue conversation flow
                continueConversation(inputType);
            };

            function continueConversation(lastInput) {
                setTimeout(() => {
                    if (lastInput === 'reported_issue') {
                        addBotMessage('Wah, saya paham situasinya. Sekarang laptop Anda kondisinya bagaimana?', true, [
                            {text: '💚 Masih Bisa Menyala Normal', action: 'laptop_on'},
                            {text: '🟡 Menyala Tapi Ada Masalah', action: 'laptop_partially'},
                            {text: '🔴 Tidak Bisa Menyala Sama Sekali', action: 'laptop_off'}
                        ]);
                    } else if (lastInput === 'brand') {
                        addBotMessage('Good! Tipe atau seri berapa laptop Anda? Ini penting untuk persiapan spare part dan tools khusus 🔧');
                        showInputForm('model');
                    } 
                    else if (lastInput === 'model') {
                        addBotMessage('Sebelum kita lanjut, mungkin Anda tertarik dengan promo spesial kami? 🎉', true, [
                            {text: 'Maintenance Rutin (Hemat 20%)', action: 'show_promo_maintenance'},
                            {text: 'Voucher Perusahaan', action: 'show_promo_corporate'},
                            {text: 'Tidak, Lanjut Aja', action: 'continue_to_name'}
                        ]);

                    } else if (lastInput === 'name') {
                        addBotMessage(`Hai ${userInputs.name}! Senang bisa bantu Anda hari ini 😊\n\nNomor WhatsApp berapa yang aktif untuk koordinasi nanti?`);
                        showInputForm('phone');
                    } else if (lastInput === 'phone') {
                        addBotMessage('Mantap! Workshop kami buka setiap hari jam 08.00-20.00. Alamat ada di Google Maps dengan nama "LaptopService". \n\nSebentar ya, saya buatkan ringkasan ordernya...');
                        
                        // Generate nota number and save to database after phone input
                        setTimeout(async () => {
                            try {
                                console.log('Saving data to database after phone input...');
                                const saveResult = await saveChatbotDataToDatabase();
                                console.log('Database save result:', saveResult);
                                
                                if (saveResult.success && saveResult.nota_number) {
                                    userInputs.notaNumber = saveResult.nota_number;
                                    addBotMessage(`✅ Data Anda berhasil tersimpan!\n\n📋 **Nomor Nota: ${saveResult.nota_number}**\n\nSimpan nomor nota ini untuk melacak status pengerjaan laptop Anda.`);
                                    
                                    // Continue with final message generation
                                    setTimeout(async () => {
                                        await generateFinalWhatsAppMessage();
                                    }, 2000);
                                } else {
                                    console.error('Database save failed:', saveResult.message);
                                    // Still continue with final message even if save fails
                                    await generateFinalWhatsAppMessage();
                                }
                            } catch (error) {
                                console.error('Error during database save:', error);
                                // Still continue with final message even if save fails
                                await generateFinalWhatsAppMessage();
                            }
                        }, 2000);
                    }
                }, 1000);
            }

            // Debug function to test database save manually
            async function testDatabaseSave() {
                console.log('Testing database save with userInputs:', userInputs);
                const result = await saveChatbotDataToDatabase();
                console.log('Database save result:', result);
                return result;
            }

            async function generateFinalWhatsAppMessage() {
                console.log('=== generateFinalWhatsAppMessage started ===');
                console.log('Current userInputs:', userInputs);
                
                let message = '';
                
                // Header based on service type
                if (userInputs.serviceType === 'maintenance') {
                    message = `*BOOKING MAINTENANCE RUTIN (HEMAT 20%)*\n\n`;
                } else if (userInputs.serviceType === 'corporate') {
                    message = `*KONSULTASI LAYANAN CORPORATE*\n\n`;
                } else {
                    message = `*PEMESANAN SERVICE LAPTOP*\n\n`;
                }
                
                message += `*Nama:* ${userInputs.name}\n`;
                message += `*WhatsApp:* ${userInputs.phone}\n`;
                message += `*Merek Laptop:* ${userInputs.brand}\n`;
                message += `*Model/Type:* ${userInputs.model}\n`;
                message += `*Keluhan:* ${userInputs.reported_issue}\n`;
                
                if (userInputs.condition) {
                    message += `*Kondisi Saat Ini:* ${userInputs.condition}\n`;
                }
                
                // Add promo section based on service type
                if (userInputs.serviceType === 'maintenance') {
                    message += `\n*PROMO MAINTENANCE RUTIN YANG DIPILIH:*\n`;
                    message += `- Hemat hingga 20% untuk perawatan berkala\n`;
                    message += `- Pembersihan menyeluruh sistem\n`;
                    message += `- Update software terbaru\n`;
                    message += `- Optimasi performa\n`;
                    message += `- Garansi layanan 30 hari\n`;
                    message += `*Promo ini berlaku untuk kunjungan ke-2 dan seterusnya*\n`;
                } else if (userInputs.serviceType === 'corporate') {
                    message += `\n*PAKET CORPORATE YANG DIMINATI:*\n`;
                    message += `- Layanan on-site gratis\n`;
                    message += `- Harga khusus untuk bulk service\n`;
                    message += `- Support teknis 24/7\n`;
                    message += `- Maintenance kontrak tahunan\n`;
                    message += `*Tim corporate kami akan segera menghubungi untuk penawaran khusus*\n`;
                } else {
                    message += `\n*LAYANAN REGULAR SERVICE*\n`;
                    message += `- Teknisi berpengalaman\n`;
                    message += `- Sparepart original\n`;
                    message += `- Garansi service\n`;
                    message += `- Gratis cek & konsultasi`;
                }
                
                // Add nota number BEFORE confirmation message if available
                if (userInputs.notaNumber) {
                    message += `\n\n*NOMOR NOTA: ${userInputs.notaNumber}*\n`;
                    message += `_Simpan nomor nota ini untuk melacak status pengerjaan laptop Anda di website kami_\n`;
                }
                
                message += `\n_Mohon konfirmasi untuk memproses order Anda. Tim kami akan segera menghubungi untuk koordinasi lebih lanjut. Terima kasih!_`;
                
                addBotMessage('Sempurna! Saya sudah siapkan ringkasan ordernya dengan estimasi berdasarkan kondisi laptop Anda', true, [
                    {text: 'Kirim ke WhatsApp', action: 'send_whatsapp'},
                    {text: 'Copy Pesan', action: 'copy_message'}
                ]);
                
                // Store message for WhatsApp
                userInputs.finalMessage = message;
            }

            async function sendToWhatsApp(message) {
                console.log('=== sendToWhatsApp function called ===');
                console.log('Input message parameter:', message);
                console.log('userInputs with nota:', JSON.stringify(userInputs, null, 2));
                
                // Add a visual indicator that the function is working
                const buttons = document.querySelectorAll('.chat-btn');
                buttons.forEach(btn => {
                    if (btn.textContent.includes('Kirim ke WhatsApp')) {
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuka WhatsApp...';
                        btn.disabled = true;
                    }
                });
                
                // No need to save database again, already saved after phone input
                // Proceed directly to WhatsApp
                console.log('Calling proceedToWhatsApp...');
                proceedToWhatsApp(message);
            }
            
            function proceedToWhatsApp(message) {
                console.log('=== proceedToWhatsApp function called ===');
                console.log('Input message:', message);
                console.log('userInputs.finalMessage:', userInputs.finalMessage);
                console.log('userInputs.notaNumber:', userInputs.notaNumber);
                
                if (!message && userInputs.finalMessage) {
                    message = userInputs.finalMessage;
                }
                
                // No need to add nota number here - already included in generateFinalWhatsAppMessage
                
                if (!message || message.trim() === '') {
                    console.error('No message to send to WhatsApp!');
                    alert('Error: Tidak ada pesan untuk dikirim ke WhatsApp');
                    return;
                }
                
                const waNumber = '6287823330830';
                const waUrl = 'https://wa.me/' + waNumber + '?text=' + encodeURIComponent(message);
                
                console.log('Final WhatsApp message length:', message.length);
                console.log('Final WhatsApp message:', message);
                console.log('WhatsApp URL:', waUrl);
                
                // Try multiple methods to open WhatsApp in new tab
                try {
                    console.log('Attempting to open WhatsApp in new tab...');
                    
                    // Method 1: Use window.open with _blank (primary method)
                    const newWindow = window.open(waUrl, '_blank', 'noopener,noreferrer');
                    
                    if (newWindow) {
                        console.log('WhatsApp window opened successfully via window.open');
                    } else {
                        console.log('window.open blocked by popup blocker, trying temporary link...');
                        // Method 2: Create and click a temporary link (fallback for popup blockers)
                        const tempLink = document.createElement('a');
                        tempLink.href = waUrl;
                        tempLink.target = '_blank';
                        tempLink.rel = 'noopener noreferrer';
                        document.body.appendChild(tempLink);
                        tempLink.click();
                        document.body.removeChild(tempLink);
                        console.log('WhatsApp opened via temporary link');
                    }
                    
                    // Reset chat after short delay
                    setTimeout(() => {
                        waModal.style.display = 'none';
                        resetChat();
                    }, 1000);
                    
                } catch (error) {
                    console.error('Error opening WhatsApp:', error);
                    
                    // Method 3: Final fallback - still try to open in new tab
                    try {
                        console.log('Trying final fallback method...');
                        const finalLink = document.createElement('a');
                        finalLink.href = waUrl;
                        finalLink.target = '_blank';
                        finalLink.rel = 'noopener noreferrer';
                        finalLink.style.display = 'none';
                        document.body.appendChild(finalLink);
                        
                        // Simulate click event
                        const clickEvent = new MouseEvent('click', {
                            view: window,
                            bubbles: true,
                            cancelable: true
                        });
                        finalLink.dispatchEvent(clickEvent);
                        
                        document.body.removeChild(finalLink);
                        console.log('WhatsApp opened via final fallback method');
                        
                        // Reset chat after short delay
                        setTimeout(() => {
                            waModal.style.display = 'none';
                            resetChat();
                        }, 1000);
                        
                    } catch (finalError) {
                        console.error('All methods failed:', finalError);
                        alert('Gagal membuka WhatsApp. Silakan coba tombol "Hubungi Langsung" atau hubungi customer service manual.');
                    }
                }
            }

            // New function for saving chatbot data to database
            async function saveChatbotDataToDatabase() {
                console.log('=== saveChatbotDataToDatabase function called ===');
                console.log('Complete userInputs object:', JSON.stringify(userInputs, null, 2));
                
                // Validate required data first
                const requiredFields = ['name', 'phone', 'brand', 'model', 'reported_issue'];
                const missingFields = requiredFields.filter(field => !userInputs[field] || userInputs[field].trim() === '');
                
                if (missingFields.length > 0) {
                    console.error('Missing required data fields:', missingFields);
                    console.error('Current userInputs state:', userInputs);
                    return { 
                        success: false, 
                        message: `Data tidak lengkap. Field yang diperlukan: ${missingFields.join(', ')}` 
                    };
                }
                
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    console.log('CSRF token element:', csrfToken);
                    console.log('CSRF token value:', csrfToken ? csrfToken.getAttribute('content') : 'NOT FOUND');
                    
                    if (!csrfToken || !csrfToken.getAttribute('content')) {
                        console.error('CSRF token not found or empty');
                        return { success: false, message: 'CSRF token tidak ditemukan' };
                    }

                    // Use FormData instead of JSON to avoid CSRF issues
                    const formData = new FormData();
                    formData.append('_token', csrfToken.getAttribute('content')); // Laravel standard CSRF field
                    formData.append('name', userInputs.name.trim());
                    formData.append('phone', userInputs.phone.trim());
                    formData.append('email', '-');
                    formData.append('address', '-');
                    formData.append('brand', userInputs.brand.trim());
                    formData.append('model', userInputs.model.trim());
                    formData.append('serial_number', '-');
                    formData.append('reported_issue', userInputs.reported_issue.trim());
                    formData.append('service_type', userInputs.serviceType || 'regular');
                    formData.append('condition', userInputs.condition || '-');
                    
                    // Create detailed technician note based on service type
                    let techNote = 'Pemesanan via Chatbot LASO';
                    if (userInputs.serviceType === 'maintenance') {
                        techNote += ' - PROMO MAINTENANCE RUTIN (Hemat 20%)';
                    } else if (userInputs.serviceType === 'corporate') {
                        techNote += ' - LAYANAN CORPORATE (Tim khusus akan menghubungi)';
                    } else {
                        techNote += ' - Service Regular';
                    }
                    formData.append('technician_note', techNote);

                    console.log('Prepared form data for submission');
                    console.log('CSRF token being sent:', csrfToken.getAttribute('content'));
                    console.log('Making fetch request to:', '{{ route("front.chatbot-order.store") }}');

                    const response = await fetch('{{ route("front.chatbot-order.store") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    console.log('Response status:', response.status);
                    console.log('Response ok:', response.ok);
                    
                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Response error:', errorText);
                        return { success: false, message: `Server error: ${response.status}` };
                    }
                    
                    const result = await response.json();
                    console.log('Response result:', result);
                    return result;

                } catch (error) {
                    console.error('Error saving to database:', error);
                    return { success: false, message: error.message };
                }
            }

            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            function resetChat() {
                currentStep = 'start';
                userInputs = {};
                messagesContainer.innerHTML = '';
                chatInputArea.style.display = 'none';
                chatDataForm.reset();
                // Clear localStorage when manually resetting
                clearChatState();
            }
            
            // Add manual reset button functionality (optional)
            function manualResetChat() {
                resetChat();
                // Re-initialize with fresh state
                setTimeout(() => {
                    addBotMessage('Halo! Saya LASO, asisten virtual LaptopService 👋');
                    setTimeout(() => {
                        addBotMessage('Saya siap membantu Anda dengan layanan service laptop profesional. Ada yang bisa saya bantu?', true, [
                            {text: 'Service Laptop', action: 'service_laptop'},
                            {text: 'Hubungi Langsung', action: 'direct_contact'}
                        ]);
                    }, 1500);
                }, 500);
            }
            
            // Detect page refresh and clear state
            window.addEventListener('beforeunload', function() {
                // Set a flag that we're refreshing
                sessionStorage.setItem('page_refreshing', 'true');
            });
            
            // Check if page was refreshed on load
            window.addEventListener('load', function() {
                if (sessionStorage.getItem('page_refreshing')) {
                    // Page was refreshed, clear chat state
                    clearChatState();
                    sessionStorage.removeItem('page_refreshing');
                }
            });
        });
        
        // IndoRegion Server-side Form System  
        $(document).ready(function() {
            // Province change handler - reload page with regency data
            $('#province_id').on('change', function() {
                const provinceId = $(this).val();
                if (provinceId) {
                    // Show regency group immediately
                    $('#regency-group').slideDown(300);
                    
                    // Create form to reload with regency data
                    const form = $('<form>', {
                        method: 'GET',
                        action: '{{ url("/") }}'
                    });
                    
                    form.append($('<input>', {
                        type: 'hidden',
                        name: 'province_id',
                        value: provinceId
                    }));
                    
                    // Add current form data to preserve it
                    const name = $('#name').val();
                    const phone = $('#phone').val();
                    const email = $('#email').val();
                    
                    if (name) form.append($('<input>', {type: 'hidden', name: 'name', value: name}));
                    if (phone) form.append($('<input>', {type: 'hidden', name: 'phone', value: phone}));
                    if (email) form.append($('<input>', {type: 'hidden', name: 'email', value: email}));
                    
                    $('body').append(form);
                    form.submit();
                } else {
                    hideFieldsAfter('regency-group');
                }
                updateAddressField();
            });
            
            // Regency change handler - reload page with district data
            $('#regency_id').on('change', function() {
                const regencyId = $(this).val();
                const provinceId = $('#province_id').val();
                
                if (regencyId) {
                    // Show district group and street address immediately
                    $('#district-group').slideDown(300);
                    $('#street-address-group').slideDown(300);
                    
                    // Create form to reload with district data
                    const form = $('<form>', {
                        method: 'GET',
                        action: '{{ url("/") }}'
                    });
                    
                    form.append($('<input>', {type: 'hidden', name: 'province_id', value: provinceId}));
                    form.append($('<input>', {type: 'hidden', name: 'regency_id', value: regencyId}));
                    
                    // Add current form data to preserve it
                    const name = $('#name').val();
                    const phone = $('#phone').val();
                    const email = $('#email').val();
                    const streetAddress = $('#street_address').val();
                    
                    if (name) form.append($('<input>', {type: 'hidden', name: 'name', value: name}));
                    if (phone) form.append($('<input>', {type: 'hidden', name: 'phone', value: phone}));
                    if (email) form.append($('<input>', {type: 'hidden', name: 'email', value: email}));
                    if (streetAddress) form.append($('<input>', {type: 'hidden', name: 'street_address', value: streetAddress}));
                    
                    $('body').append(form);
                    form.submit();
                } else {
                    hideFieldsAfter('district-group');
                }
                updateAddressField();
            });
            
            // District change handler
            $('#district_id').on('change', function() {
                updateAddressField();
            });
            
            // Street address change handler
            $('#street_address').on('input', function() {
                updateAddressField();
            });
            
            // Populate preserved form data from URL parameters
            @if(request()->has('name'))
                $('#name').val('{{ request("name") }}');
            @endif
            @if(request()->has('phone'))
                $('#phone').val('{{ request("phone") }}');
            @endif
            @if(request()->has('email'))
                $('#email').val('{{ request("email") }}');
            @endif
            @if(request()->has('street_address'))
                $('#street_address').val('{{ request("street_address") }}');
            @endif
            
            function hideFieldsAfter(fieldId) {
                const fields = ['regency-group', 'district-group', 'street-address-group'];
                const currentIndex = fields.indexOf(fieldId);
                
                for (let i = currentIndex; i < fields.length; i++) {
                    const field = $('#' + fields[i]);
                    field.slideUp(300);
                    
                    // Reset field values
                    if (fields[i] === 'regency-group') {
                        $('#regency_id').val('').prop('disabled', true);
                    } else if (fields[i] === 'district-group') {
                        $('#district_id').val('').prop('disabled', true);
                    } else if (fields[i] === 'street-address-group') {
                        $('#street_address').val('');
                    }
                }
            }
            
            function updateAddressField() {
                const province = $('#province_id option:selected').text();
                const regency = $('#regency_id option:selected').text();
                const district = $('#district_id option:selected').text();
                const streetAddress = $('#street_address').val();
                
                let fullAddress = '';
                
                if (streetAddress) {
                    fullAddress = streetAddress;
                }
                if (district && district !== 'Pilih Kecamatan... (Opsional)') {
                    fullAddress += (fullAddress ? ', ' : '') + district;
                }
                if (regency && regency !== 'Pilih Kabupaten/Kota...') {
                    fullAddress += (fullAddress ? ', ' : '') + regency;
                }
                if (province && province !== 'Pilih Provinsi...') {
                    fullAddress += (fullAddress ? ', ' : '') + province;
                }
                
                $('#address').val(fullAddress);
            }
            
            // Initialize address field on page load
            updateAddressField();
        });
        </script>
    </section>
</x-client.layout>
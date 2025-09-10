<x-client.layout>
    <x-slot name="title">Lacak Pengerjaan Servis</x-slot>

    <header id="hero" style="background-image: url('{{ asset('images/BGstatus.png') }}');">
        <div class="container">
            <div class="row align-items: center justify-content-center text-center text-lg-start">
                
                <section class="col-lg-7 animate-on-scroll fade-in-left">
                    <h1 class="header-1 color-navy fw-bold mb-4">Lacak Pengerjaan Servis Anda</h1>

                    <img src="{{ asset('images/HeroStatus.png') }}" class="img-fluid d-lg-none hero-img mb-4" alt="Teknisi sedang bekerja">

                    <p class="body-1 color-navy fw-normal mb-4">Masukkan nomor nota servis Anda di bawah ini untuk melihat status pengerjaan perangkat Anda secara real-time.</p>

                    <form action="{{ route('front.cek-status') }}#hasil" method="GET">
                        <div class="input-group">
                            <input class="form-control form-control-lg" type="search" name="no_servis" placeholder="Contoh : NOTA-202509-205" aria-label="Search" value="{{ request('no_servis') }}" required>
                            <button class="btn btn-primary px-4" type="submit">
                                <i class="fas fa-search"></i> Cek Status
                            </button>
                        </div>
                    </form>

                </section>

                <section class="col-lg-5 d-none d-lg-block animate-on-scroll fade-in-right">
                    <img src="{{ asset('images/HeroStatus.png') }}" class="img-fluid mb-32 mx-auto d-block hero-img" alt="Teknisi sedang bekerja">
                </section>

            </div>
        </div>
    </header>

    <section id="hasil" class="animate-on-scroll fade-in-up" @if(!$searched) style="display: none;" @endif>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    @if($searched)
                        @if($notFound)
                            {{-- Pesan Nota Tidak Ditemukan --}}
                            <div class="text-center">
                                <h2 class="header-2 color-navy fw-bold mb-4">Nota Tidak Ditemukan</h2>
                                <div class="alert alert-warning" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Nomor nota "<strong>{{ request('no_servis') }}</strong>" tidak ditemukan dalam sistem.
                                    <br>Pastikan nomor nota yang Anda masukkan sudah benar.
                                </div>
                            </div>
                        @else
                            {{-- Judul dan Sub-judul Section --}}
                            <h2 class="header-2 color-navy fw-bold text-center mb-4">Hasil Pencarian</h2>

                            {{-- Kartu Hasil Lacak --}}
                            <div class="result-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="header-4 color-navy mb-1">Hasil Lacak: <span class="fw-bold text-navy">#{{ $servis->nota_number }}</span></h5>
                                        <p class="body-1 color-navy mb-0">
                                            Pelanggan: {{ $servis->customers->name }} - {{ $servis->brand }} {{ $servis->model }}
                                        </p>
                                    </div>
                                    @php
                                        $currentStatus = $servis->status ?: 'Perangkat Baru Masuk';
                                        $statusClass = '';
                                        switch($currentStatus) {
                                            case 'Selesai':
                                                $statusClass = 'status-badge bg-success';
                                                break;
                                            case 'Sedang Diperbaiki':
                                                $statusClass = 'status-badge bg-warning';
                                                break;
                                            case 'Perangkat Baru Masuk':
                                                $statusClass = 'status-badge bg-secondary';
                                                break;
                                            default:
                                                $statusClass = 'status-badge bg-secondary';
                                        }
                                    @endphp
                                    <span class="{{ $statusClass }}">{{ $currentStatus }}</span>  
                                </div>

                                <hr class="my-3">

                                <div>
                                    <h6 class="header-4 color-navy mb-3">Detail & Catatan</h6>
                                    <div class="detail-section">
                                        <strong>Kerusakan Dilaporkan:</strong>
                                        <p class="">{{ $servis->reported_issue }}</p>
                                    </div>
                                    <div class="detail-section mt-3">
                                        <strong>Catatan Teknisi:</strong>
                                        <p class="">{{ $servis->technician_note ?? 'Belum ada catatan dari teknisi.' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </section>


    @push('css')
        @vite(['resources/css/client/pages/cekstatus/style.css'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css">
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/glide.min.js"></script>
        <script>
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
        </script>
    @endpush
    
</x-client.layout>
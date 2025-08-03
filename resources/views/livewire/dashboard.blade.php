<div>
    {{-- CSS Kustom yang sudah disederhanakan --}}
    @push('styles')
        <style>
            /* Card utama yang membungkus semuanya */
            .main-content-card .card-body {
                padding: 0;
            }

            /* Mengatur indikator carousel */
            .carousel-indicators [data-bs-target] {
                background-color: #5D87FF;
            }

            /* Style untuk kotak fitur di dalam card utama */
            .feature-box {
                border-radius: 12px;
                padding: 1.5rem;
                text-align: center;
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
                border: 1px solid #e9ecef;
            }

            .feature-box:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
            }

            .feature-box img {
                max-width: 120px;
                height: auto;
                margin-bottom: 1rem;
            }

            .feature-box.materi {
                background-color: #e8f7ff;
            }

            .feature-box.soal {
                background-color: #eaf7e9;
            }

            .feature-box.lms {
                background-color: #fff4e8;
            }

            /* Style sapaan */
            .welcome-greeting h4 {
                font-weight: 600;
            }

            .welcome-greeting p {
                color: #5a6a85;
                font-size: 1.1rem;
            }
        </style>
    @endpush

    {{-- Sapaan Pengguna (di luar card) --}}
    <div class="welcome-greeting mb-4">
        {{-- <h4>Hi {{ auth()->user()->name }} 👋</h4> --}}
        <p>Siap belajar hari ini?</p>
    </div>

    {{-- Card Tunggal untuk Semua Konten --}}
    <div class="card shadow-sm main-content-card">
        <div class="card-body">

            {{-- Bagian 1: Carousel Banner --}}
            <div id="welcomeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="5000">
                        <img src="{{ asset('assets/img/banner/Banner.png') }}" class="d-block w-100" alt="Banner 1">
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <img src="{{ asset('assets/img/banner/Banner (1).png') }}" class="d-block w-100" alt="Banner 2">
                    </div>
                    <div class="carousel-item" data-bs-interval="5000">
                        <img src="{{ asset('assets/img/banner/Banner (2).png') }}" class="d-block w-100" alt="Banner 3">
                    </div>
                </div>
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
            </div>

            {{-- Bagian 2 & 3: Konten di bawah Carousel --}}
            <div class="p-4">
                {{-- Menu Utama (Materi, Soal, LMS) --}}
                <div class="row g-4">
                    <div class="col-lg-4 col-md-12">
                        <a href="#" class="text-decoration-none text-dark">
                            <img src="{{ asset('assets/img/card/image.png') }}" alt="" srcset="">
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <a href="#" class="text-decoration-none text-dark">
                            <img src="{{ asset('assets/img/card/image1.png') }}" alt="" srcset="">
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <a href="#" class="text-decoration-none text-dark">
                            <img src="{{ asset('assets/img/card/image2.png') }}" alt="" srcset="">
                        </a>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Call to Action (SUDAH DIPERBAIKI) --}}
                <div class="text-center">
                    <h4 class="fw-bold">Yuk mulai, capai karirmu!</h4>
                    <a href="{{ route('students.packages.index') }}"
                        class="btn btn-primary btn-lg mt-3 px-4 rounded-full">Mulai Sekarang</a>

                    {{-- Gambar dipindahkan ke bawah tombol --}}
                    <img src="{{ asset('assets/img/card/pro/Non profit.png') }}" alt="Mulai Sekarang"
                        style="max-width: 180px;" class="mt-4 d-block mx-auto">
                </div>
            </div>
        </div>
    </div>
</div>

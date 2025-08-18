<div>
    @if ($step == 1)
        {{-- =============================================== --}}
        {{--              LANGKAH 1: PILIH FORMASI             --}}
        {{-- =============================================== --}}
        <h3 class="fw-bolder mb-4">Pilih Formasi</h3>
        <div class="row">
            @forelse ($formations as $formation)
                <div class="col-md-6 col-lg-4" wire:key="formation-{{ $formation->id }}">
                    <div class="card border shadow-sm hover-scale-up">
                        <img src="{{ $formation->image ? Storage::url($formation->image) : 'https://via.placeholder.com/350x200?text=No+Image' }}"
                            class="card-img-top" alt="{{ $formation->name }}" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">{{ $formation->name }}</h5>
                            <p class="card-text text-muted">{{ $formation->short_description }}</p>
                            <span class="badge bg-light-primary text-primary mb-3">
                                Tersedia {{ $formation->positions_count }} Posisi Jabatan
                            </span>
                            <div class="d-grid">
                                <button class="btn btn-primary" wire:click="selectFormation({{ $formation->id }})">Pilih
                                    Formasi</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Belum ada formasi yang tersedia.</p>
            @endforelse
        </div>
    @elseif ($step == 2)
        {{-- =============================================== --}}
        {{--              LANGKAH 2: PILIH POSISI              --}}
        {{-- =============================================== --}}
        <div class="d-flex align-items-center mb-4">
            <button class="btn btn-outline-secondary me-3" wire:click="goBack"><i class="ti ti-arrow-left"></i></button>
            <h3 class="fw-bolder mb-0">Formasi {{ $selectedFormation->name }}</h3>
        </div>
        <div class="row">
            @forelse ($selectedFormation->positions as $position)
                <div class="col-md-6 col-lg-4" wire:key="pos-{{ $position->id }}">
                    <div class="card border shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">{{ $position->name }}</h5>
                            <p class="fs-4 text-muted">Mulai dari:</p>
                            <h4 class="fw-bolder text-primary">Rp
                                {{ number_format($position->price_mandiri, 0, ',', '.') }}</h4>
                            <div class="d-grid mt-3">
                                <button class="btn btn-primary" wire:click="selectPosition({{ $position->id }})">Pilih
                                    Jabatan</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Belum ada posisi yang tersedia untuk formasi ini.</p>
            @endforelse
        </div>
    @elseif ($step == 3)
        {{-- =============================================== --}}
        {{--      LANGKAH 3: TAMPILAN SESUAI SCREENSHOT      --}}
        {{-- =============================================== --}}
        <div class="d-flex align-items-center mb-4">
            {{-- Tombol kembali --}}
            <a href="#" class="btn btn-outline-secondary me-3" wire:click.prevent="goBack">
                <i class="ti ti-arrow-left"></i>
            </a>
            <h3 class="fw-bolder mb-0">Pilih Paket Belajarmu</h3>
        </div>

        <div class="row justify-content-center g-4">
            {{-- Kartu Paket Aplikasi --}}
            <div class="col-md-6 col-lg-5">
                <div class="card package-card mandiri h-100 d-flex flex-column">
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3">
                            <span class="package-tag mandiri-tag">Akses Mandiri</span>
                        </div>
                        <h4 class="fw-bolder text-center">Paket Aplikasi</h4>
                        <p class="text-muted text-center small mb-4">Paket ini cocok untuk anda yang ingin belajar
                            mandiri dengan materi dan soal lengkap</p>

                        <div class="text-center my-3">
                            <p class="price-original text-muted">Rp. 500.000,00</p>
                            <h2 class="price-current text-primary-mandiri fw-bolder">Rp 275.000</h2>
                        </div>

                        <ul class="list-unstyled package-features">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ti ti-circle-check text-success me-2"></i>
                                <span>Akses Penuh Selama 6 Bulan Tanpa Batas</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ti ti-circle-check text-success me-2"></i>
                                <span>Full Akses Paket Materi</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ti ti-circle-check text-success me-2"></i>
                                <span>Full Akses Paket Soal</span>
                            </li>
                            <li class="d-flex align-items-center text-muted">
                                <i class="ti ti-circle-x text-danger me-2"></i>
                                <span>Tidak termasuk Sesi Bimbel</span>
                            </li>
                        </ul>

                        <div class="d-grid mt-auto">
                            {{-- Anda mungkin perlu menyesuaikan method `checkout` di komponen Livewire Anda --}}
                            <button class="btn btn-outline-primary-mandiri btn-lg"
                                wire:click="checkout('mandiri')">Pilih Paket Aplikasi</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Paket Bimbel --}}
            <div class="col-md-6 col-lg-5">
                <div class="card package-card bimbingan h-100 d-flex flex-column">
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3">
                            <span class="package-tag bimbingan-tag">Paling Lengkap</span>
                        </div>
                        <h4 class="fw-bolder text-center">Paket Bimbel</h4>
                        <p class="text-muted text-center small mb-4">Dapatkan pengalaman belajar Pengawas Perikanan
                            dengan
                            akses penuh ke semua fitur</p>

                        <div class="text-center my-3">
                            <p class="price-original text-muted">Rp. 2.500.000,00</p>
                            <h2 class="price-current text-primary fw-bolder">Rp 1.225.000</h2>
                        </div>

                        <ul class="list-unstyled package-features">
                            <li class="d-flex align-items-center mb-2">
                                <i class="ti ti-circle-check text-success me-2"></i>
                                <span>Akses Penuh Selama 6 Bulan Tanpa Batas</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ti ti-circle-check text-success me-2"></i>
                                <span>Full Akses Paket Materi</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ti ti-circle-check text-success me-2"></i>
                                <span>Full Akses Paket Soal</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="ti ti-circle-check text-success me-2"></i>
                                <span>Full Akses Paket Bimbel</span>
                            </li>
                        </ul>

                        <div class="d-grid mt-auto">
                            {{-- Anda mungkin perlu menyesuaikan method `checkout` di komponen Livewire Anda --}}
                            <button class="btn btn-primary btn-lg" wire:click="checkout('bimbingan')">Pilih Paket
                                Bimbel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
    <style>
        .hover-scale-up {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .hover-scale-up:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
        }

        .package-toggle {
            display: flex;
            border-radius: 50px;
            background-color: #f0f2f5;
            padding: 5px;
            max-width: 300px;
        }

        .package-toggle button {
            flex: 1;
            padding: 10px 15px;
            border: none;
            background-color: transparent;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #5a6a85;
        }

        .package-toggle button.active {
            background-color: #fff;
            color: #5D87FF;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Variabel Warna untuk kemudahan kustomisasi */
        :root {
            --mandiri-primary: #28a745;
            /* Warna hijau utama */
            --mandiri-bg: #e9f7ec;
            /* Warna background hijau muda */
            --bimbingan-primary: #0d6efd;
            /* Warna biru utama (Bootstrap default) */
            --bimbingan-bg: #e7f3ff;
            /* Warna background biru muda */
            --card-border-radius: 1rem;
            /* Radius sudut kartu */
        }

        /* Styling umum untuk kedua kartu paket */
        .package-card {
            border-width: 1px;
            border-style: solid;
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* Styling untuk Tag di atas judul (Akses Mandiri / Paling Lengkap) */
        .package-tag {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.8rem;
            border-radius: 50px;
            /* Membuat bentuk pil */
            font-size: 0.8rem;
            font-weight: 600;
            color: #fff;
        }

        /* Menambahkan titik/dot sebelum teks tag */
        .package-tag::before {
            content: '';
            display: block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #fff;
            margin-right: 8px;
        }

        /* Styling harga */
        .price-original {
            text-decoration: line-through;
            font-size: 1rem;
        }

        .price-current {
            font-size: 2.25rem;
            /* Ukuran font harga diskon */
            line-height: 1;
        }

        /* Styling daftar fitur */
        .package-features {
            padding-left: 1rem;
            /* Sedikit indentasi untuk fitur */
        }

        .package-features .ti {
            font-size: 1.25rem;
            /* Ukuran ikon ceklis/silang */
        }

        /*
        |--------------------------------------------------------------------------
        | Kustomisasi Spesifik per Paket
        |--------------------------------------------------------------------------
        */

        /* == Paket Aplikasi (Mandiri - Hijau) == */
        .package-card.mandiri {
            border-color: var(--mandiri-primary);
            background-color: var(--mandiri-bg);
        }

        .mandiri-tag {
            background-color: var(--mandiri-primary);
        }

        .text-primary-mandiri {
            color: var(--mandiri-primary) !important;
        }

        /* Mengubah tombol outline menjadi solid seperti di gambar */
        .package-card.mandiri .btn-outline-primary-mandiri {
            background-color: var(--mandiri-primary);
            border-color: var(--mandiri-primary);
            color: #fff;
            font-weight: 600;
        }

        .package-card.mandiri .btn-outline-primary-mandiri:hover {
            background-color: #23903c;
            /* Warna hijau sedikit lebih gelap saat hover */
            border-color: #23903c;
            color: #fff;
        }


        /* == Paket Bimbel (Bimbingan - Biru) == */
        .package-card.bimbingan {
            border-color: var(--bimbingan-primary);
            background-color: var(--bimbingan-bg);
        }

        .bimbingan-tag {
            background-color: var(--bimbingan-primary);
        }

        .package-card.bimbingan .btn-primary {
            background-color: var(--bimbingan-primary);
            border-color: var(--bimbingan-primary);
            font-weight: 600;
        }

        .package-card.bimbingan .btn-primary:hover {
            background-color: #0b5ed7;
            /* Warna biru sedikit lebih gelap saat hover */
            border-color: #0a58ca;
        }
    </style>
@endpush

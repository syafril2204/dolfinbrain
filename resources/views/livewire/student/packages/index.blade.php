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
                            <span class="badge bg-light-primary text-primary mb-3">Tersedia
                                {{ $formation->positions_count }} Posisi Jabatan</span>
                            <div class="d-grid"><button class="btn btn-primary"
                                    wire:click="selectFormation({{ $formation->id }})">Pilih Formasi</button></div>
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
                            <div class="d-grid mt-3"><button class="btn btn-primary"
                                    wire:click="selectPosition({{ $position->id }})">Pilih Jabatan</button></div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Belum ada posisi yang tersedia untuk formasi ini.</p>
            @endforelse
        </div>
    @elseif ($step == 3 && !empty($mandiriPackage))
        {{-- =============================================== --}}
        {{--        LANGKAH 3: TAMPILAN KARTU DINAMIS         --}}
        {{-- =============================================== --}}
        <div class="d-flex align-items-center mb-4">
            <a href="#" class="btn btn-outline-secondary me-3" wire:click.prevent="goBack"><i
                    class="ti ti-arrow-left"></i></a>
            <h3 class="fw-bolder mb-0"> Pilih Paket Terbaik untuk Masa Depanmu {{ $selectedPosition->name }}</h3>
        </div>
        <div class="row justify-content-center g-4">
            {{-- Kartu Paket Aplikasi (Mandiri) --}}
            <div class="col-md-6 col-lg-5">
                <div class="card package-card mandiri h-100 d-flex flex-column">
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3"><span class="package-tag mandiri-tag">Akses Mandiri</span></div>
                        <h4 class="fw-bolder text-center">Paket Aplikasi</h4>
                        <p class="text-muted text-center small mb-4">Pilihan Tepat untuk Pejuang Mandiri yang Serius!
                        </p>
                        <div class="text-center my-3">
                            <p class="price-original text-muted"><s>Rp.
                                    {{ number_format($mandiriPackage['original_price'], 0, ',', '.') }}</s></p>
                            <h2 class="price-current text-primary-mandiri fw-bolder">Rp
                                {{ number_format($mandiriPackage['price'], 0, ',', '.') }}</h2>
                        </div>
                        <ul class="list-unstyled package-features">
                            @foreach ($mandiriPackage['features'] as $feature)
                                <li
                                    class="d-flex align-items-center mb-2 @if (!$feature['included']) text-muted @endif">
                                    <i
                                        class="ti {{ $feature['included'] ? 'ti-circle-check text-success' : 'ti-circle-x text-danger' }} me-2"></i>
                                    <span>{{ $feature['text'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="d-grid mt-auto">
                            @if ($hasMandiriPackage)
                                <button class="btn btn-secondary btn-lg" disabled>Anda Sudah Memiliki Paket Ini</button>
                            @else
                                <button class="btn btn-outline-primary-mandiri btn-lg"
                                    wire:click="checkout('mandiri')">Pilih Paket Aplikasi</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- Kartu Paket Bimbel --}}
            <div class="col-md-6 col-lg-5">
                <div class="card package-card bimbingan h-100 d-flex flex-column">
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3"><span class="package-tag bimbingan-tag">Paling Lengkap</span>
                        </div>
                        <h4 class="fw-bolder text-center">Paket Bimbel</h4>
                        <p class="text-muted text-center small mb-4">Paket Khusus untuk Sukses Tanpa Ragu!</p>
                        <div class="text-center my-3">
                            @if (!$bimbinganPackage['is_upgrade'])
                                <p class="price-original text-muted"><s>Rp.
                                        {{ number_format($bimbinganPackage['original_price'], 0, ',', '.') }}</s></p>
                            @endif
                            <h2 class="price-current text-primary fw-bolder">Rp
                                {{ number_format($bimbinganPackage['price'], 0, ',', '.') }}</h2>
                        </div>
                        <ul class="list-unstyled package-features">
                            @foreach ($bimbinganPackage['features'] as $feature)
                                <li
                                    class="d-flex align-items-center mb-2 @if (!$feature['included']) text-muted @endif">
                                    <i
                                        class="ti {{ $feature['included'] ? 'ti-circle-check text-success' : 'ti-circle-x text-danger' }} me-2"></i>
                                    <span>{{ $feature['text'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="d-grid mt-auto">
                            @if ($hasBimbelPackage)
                                <button class="btn btn-secondary btn-lg" disabled>Anda Sudah Memiliki Paket Ini</button>
                            @elseif ($bimbinganPackage['is_upgrade'])
                                <div class="alert alert-success text-center small">Harga Spesial Upgrade!</div>
                                <button class="btn btn-success btn-lg" wire:click="checkout('bimbingan')">Upgrade ke
                                    Paket Bimbel</button>
                            @else
                                <button class="btn btn-primary btn-lg" wire:click="checkout('bimbingan')">Pilih Paket
                                    Bimbel</button>
                            @endif
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

        .package-card {
            border-radius: 1rem;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .package-card.bimbingan {
            border-width: 2px;
            border-color: var(--bs-primary) !important;
        }

        .package-tag {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
        }

        .mandiri-tag {
            background-color: #e8f7ff;
            color: #539bff;
        }

        .bimbingan-tag {
            background-color: var(--bs-primary);
            color: #fff;
        }

        .price-original {
            text-decoration: line-through;
        }

        .text-primary-mandiri {
            color: #539bff;
        }

        .btn-outline-primary-mandiri {
            --bs-btn-color: #539bff;
            --bs-btn-border-color: #539bff;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #539bff;
            --bs-btn-hover-border-color: #539bff;
        }
    </style>
@endpush

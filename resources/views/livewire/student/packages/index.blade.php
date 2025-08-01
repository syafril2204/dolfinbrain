<div>
    {{-- Header & Informasi Jabatan (tidak berubah) --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Beli Paket</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Beli Paket</li>
                </ol>
            </nav>
        </div>
    </div>
    @if ($currentPosition)
        <div class="alert alert-light-primary border-primary d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6 class="mb-1">Anda akan membeli paket untuk jabatan:</h6>
                <p class="mb-0 fs-4 fw-semibold">{{ $currentPosition->formation->name }} - {{ $currentPosition->name }}
                </p>
            </div>
            <button class="btn btn-primary" wire:click="openChangePositionModal">Ganti Jabatan</button>
        </div>
    @else
        <div class="alert alert-light-warning border-warning text-center mb-4">
            <h6 class="mb-1">Anda belum memilih jabatan.</h6>
            <p class="mb-0">Silakan pilih jabatan terlebih dahulu untuk melihat harga paket.</p>
            <button class="btn btn-warning mt-2" wire:click="openChangePositionModal">Pilih Jabatan Sekarang</button>
        </div>
    @endif

    {{-- [BAGIAN DIPERBARUI] Pilihan Paket dengan 3 Kartu --}}
    <div class="row">
        {{-- Paket Gratis --}}
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card border shadow-sm w-100">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="text-center">
                        <span class="badge bg-light-secondary text-secondary rounded-pill">Akses Mandiri</span>
                        <h4 class="fw-semibold mt-3">Paket Gratis</h4>
                        <p class="text-muted">Paket untuk anda yang ingin mencoba belajar di Dolfin Brain</p>
                        <h2 class="fw-bolder text-primary my-4">Gratis</h2>
                    </div>

                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-2"><i class="ti ti-check text-success me-2"></i> Latihan
                            Soal Gratis</li>
                        <li class="d-flex align-items-center mb-2"><i class="ti ti-x text-danger me-2"></i> Akses Penuh
                        </li>
                        <li class="d-flex align-items-center mb-2"><i class="ti ti-x text-danger me-2"></i> Tidak
                            termasuk Materi</li>
                        <li class="d-flex align-items-center"><i class="ti ti-x text-danger me-2"></i> Tidak termasuk
                            Sesi Bimbel</li>
                    </ul>

                    <a href="#" class="btn btn-primary w-100 mt-auto">Coba Gratis Sekarang</a>
                </div>
            </div>
        </div>

        {{-- Paket Aplikasi (Mandiri) --}}
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card border border-success shadow-sm w-100">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="text-center">
                        <span class="badge bg-light-success text-success rounded-pill">Akses Mandiri</span>
                        <h4 class="fw-semibold mt-3">Paket Aplikasi</h4>
                        <p class="text-muted">Paket ini cocok untuk anda yang ingin belajar mandiri dengan materi dan
                            soal lengkap</p>
                        <div class="my-4">
                            @if ($currentPosition && $currentPosition->price_mandiri > 0)
                                <del class="text-danger">Rp
                                    {{ number_format($currentPosition->price_mandiri * 1.2, 0, ',', '.') }}</del>
                            @endif
                            <h2 class="fw-bolder text-success">
                                @if ($currentPosition)
                                    Rp {{ number_format($currentPosition->price_mandiri, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </h2>
                        </div>
                    </div>

                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-2"><i class="ti ti-check text-success me-2"></i> Akses
                            Penuh Selama 6 Bulan Tanpa Batas</li>
                        <li class="d-flex align-items-center mb-2"><i class="ti ti-check text-success me-2"></i> Full
                            Akses Paket Materi</li>
                        <li class="d-flex align-items-center mb-2"><i class="ti ti-check text-success me-2"></i> Full
                            Akses Paket Soal</li>
                        <li class="d-flex align-items-center"><i class="ti ti-x text-danger me-2"></i> Tidak termasuk
                            Sesi Bimbel</li>
                    </ul>

                    @if (auth()->user()->lastPendingTransaction->package_type == 'mandiri' &&
                            now() <= auth()->user()->lastPendingTransaction->expired_at)
                        <a href="{{ route('students.packages.instruction', auth()->user()->lastPendingTransaction->reference) }}"
                            class="btn btn-success w-100 mt-auto" @if (!$currentPosition) disabled @endif
                            wire:navigate>
                            Selesaikan Pembayaran
                        </a>
                    @else
                        <a href="{{ route('students.packages.checkout', ['package_type' => 'mandiri']) }}"
                            class="btn btn-success w-100 mt-auto" @if (!$currentPosition) disabled @endif
                            wire:navigate>
                            Pilih Paket Aplikasi
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Paket Bimbel (Bimbingan) --}}
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card border border-primary shadow w-100">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="text-center">
                        <span class="badge bg-primary rounded-pill">Paling Lengkap</span>
                        <h4 class="fw-semibold mt-3">Paket Bimbel</h4>
                        <p class="text-muted">Dapatkan pengalaman belajar dengan akses penuh ke semua fitur</p>
                        <div class="my-4">
                            @if ($currentPosition && $currentPosition->price_bimbingan > 0)
                                <del class="text-danger">Rp
                                    {{ number_format($currentPosition->price_bimbingan * 1.2, 0, ',', '.') }}</del>
                            @endif
                            <h2 class="fw-bolder text-primary">
                                @if ($currentPosition)
                                    Rp {{ number_format($currentPosition->price_bimbingan, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </h2>
                        </div>
                    </div>

                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-center mb-2"><i class="ti ti-check text-success me-2"></i> Akses
                            Penuh Selama 6 Bulan Tanpa Batas</li>
                        <li class="d-flex align-items-center mb-2"><i class="ti ti-check text-success me-2"></i> Full
                            Akses Paket Materi</li>
                        <li class="d-flex align-items-center mb-2"><i class="ti ti-check text-success me-2"></i> Full
                            Akses Paket Soal</li>
                        <li class="d-flex align-items-center"><i class="ti ti-check text-success me-2"></i> Full Akses
                            Paket Bimbel</li>
                    </ul>

                    <a href="{{ route('students.packages.checkout', ['package_type' => 'bimbingan']) }}"
                        class="btn btn-primary w-100 mt-auto" @if (!$currentPosition) disabled @endif
                        wire:navigate>
                        Pilih Paket Bimbel
                    </a>
                </div>
            </div>
        </div>
    </div>
    @if ($isModalOpen)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ganti Formasi & Jabatan</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($step == 1)
                            <h6>Pilih Kategori Formasi</h6>
                            @foreach ($formations as $formation)
                                <div class="card card-body border mb-2"
                                    wire:click="selectFormation({{ $formation->id }})" style="cursor: pointer;">
                                    {{ $formation->name }}
                                </div>
                            @endforeach
                        @elseif ($step == 2 && $selectedFormation)
                            <a href="#" wire:click.prevent="backToFormationSelection"
                                class="mb-3 d-inline-block"><i class="ti ti-arrow-left"></i> Kembali</a>
                            <h6>Pilih Jabatan: {{ $selectedFormation->name }}</h6>
                            @foreach ($selectedFormation->positions as $position)
                                <div class="form-check card card-body border mb-2">
                                    <input class="form-check-input" type="radio" value="{{ $position->id }}"
                                        wire:model="new_position_id" id="pos-{{ $position->id }}">
                                    <label class="form-check-label w-100"
                                        for="pos-{{ $position->id }}">{{ $position->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @if ($step == 2)
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                            <button type="button" class="btn btn-primary" wire:click="changePosition"
                                @if (!$new_position_id) disabled @endif>Simpan Jabatan</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

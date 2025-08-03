<div>
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Paket Saya</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Paket Saya</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    {{-- Paket yang Sedang Aktif --}}
    @if ($activePosition)
        <h5 class="mb-3 fw-semibold">Paket yang Sedang Aktif</h5>
        <div class="card card-body bg-light-primary border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bolder mb-1">{{ $activePosition->formation->name }} - {{ $activePosition->name }}</h6>
                    <span class="badge bg-primary">{{ Str::ucfirst($activePackageType) }}</span>
                </div>
                <span class="text-primary fw-bold"><i class="ti ti-player-play me-1"></i> Sedang Digunakan</span>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h5 class="mt-2">Anda Belum Memiliki Paket Aktif</h5>
            <p class="text-muted">Silakan pilih jabatan pada saat pendaftaran atau beli paket baru.</p>
            <a href="{{ route('student.packages.index') }}" class="btn btn-primary mt-2">Lihat Pilihan Paket</a>
        </div>
    @endif

    {{-- Paket Lainnya --}}
    @if ($otherPurchasedPositions->isNotEmpty())
        <hr class="my-4">
        <h5 class="mb-3 fw-semibold">Paket Lain yang Anda Miliki</h5>

        <div class="row">
            @foreach ($otherPurchasedPositions as $position)
                <div class="col-md-6" wire:key="{{ $position->id }}">
                    <div class="card card-body border">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bolder mb-1">{{ $position->formation->name }} - {{ $position->name }}</h6>
                                <span
                                    class="badge bg-secondary">{{ Str::ucfirst($position->pivot->package_type) }}</span>
                            </div>
                            <button class="btn btn-sm btn-outline-primary"
                                wire:click="setActivePackage({{ $position->id }})">
                                Aktifkan Paket Ini
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

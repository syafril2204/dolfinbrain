<div>
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

    <div class="row">
        @if ($purchasedPositions->isNotEmpty())
            @foreach ($purchasedPositions as $position)
                @php
                    $progress = $position->calculateProgressForUser(Auth::user());
                    $isActive = Auth::id() && Auth::user()->position_id == $position->id;
                @endphp

                <div class="col-md-6 col-lg-4 d-flex align-items-stretch" wire:key="purchased-{{ $position->id }}">
                    <div class="card w-100 shadow-sm border">
                        <img src="{{ $position->formation->image ? Storage::url($position->formation->image) : 'https://via.placeholder.com/350x200?text=Formation+Image' }}"
                            class="card-img-top" alt="{{ $position->formation->name }}"
                            style="height: 180px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bolder">{{ $position->formation->name }}</h5>
                            <p class="mb-2">{{ $position->name }}</p>

                            @if ($position->pivot->package_type == 'bimbingan')
                                <span class="badge bg-light-success text-success align-self-start mb-3">Paket
                                    Bimbel</span>
                            @else
                                <span class="badge bg-light-primary text-primary align-self-start mb-3">Paket
                                    Aplikasi</span>
                            @endif

                            <div class="progress-section mt-auto">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-1">Progres Belajar</p>
                                    <p class="mb-1 fw-bold">{{ $progress }}%</p>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;"
                                        aria-valuenow="{{ $progress }}"></div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                @if ($isActive)
                                    <span class="btn btn-success disabled"><i class="ti ti-player-play me-1"></i> Sedang
                                        Aktif</span>
                                @else
                                    <button class="btn btn-primary"
                                        wire:click="setActivePackage({{ $position->id }})">Aktifkan Paket</button>
                                @endif
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary"
                                    wire:navigate>Lanjutkan Belajar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif ($freePosition)
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch" wire:key="free-{{ $freePosition->id }}">
                <div class="card w-100 shadow-sm border">
                    <img src="{{ $freePosition->formation->image ? Storage::url($freePosition->formation->image) : 'https://via.placeholder.com/350x200?text=Formation+Image' }}"
                        class="card-img-top" alt="{{ $freePosition->formation->name }}"
                        style="height: 180px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bolder">{{ $freePosition->formation->name }}</h5>
                        <p class="mb-2">{{ $freePosition->name }}</p>
                        <span class="badge bg-light-secondary text-secondary align-self-start mb-3">Paket Gratis</span>
                        <div class="progress-section mt-auto">
                            <div class="d-flex justify-content-between">
                                <p class="mb-1">Progres Belajar</p>
                                <p class="mb-1 fw-bold">0%</p>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%;"></div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <span class="btn btn-success disabled"><i class="ti ti-player-play me-1"></i> Sedang
                                Aktif</span>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary" wire:navigate>Mulai
                                Belajar</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <div class="card card-body text-center py-5">
                    <img src="{{ asset('assets/illustrations/empty-box.png') }}" alt="Empty" class="mx-auto mb-3"
                        style="max-width: 150px;">
                    <h5 class="mt-2">Anda Belum Memiliki Paket Apapun</h5>
                    <p class="text-muted">Semua paket yang Anda beli akan muncul di sini.</p>
                    <a href="{{ route('students.packages.index') }}" class="btn btn-primary mt-2" wire:navigate>Lihat
                        Pilihan Paket</a>
                </div>
            </div>
        @endif
    </div>
</div>

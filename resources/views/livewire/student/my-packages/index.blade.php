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

    <div class="accordion" id="packagesAccordion">
        @forelse ($groupedByFormation as $formationId => $positionsInFormation)
            @php
                $formation = $positionsInFormation->first()->formation;
            @endphp
            <div class="accordion-item" wire:key="formation-group-{{ $formationId }}">
                <h2 class="accordion-header" id="heading-{{ $formationId }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ $formationId }}">
                        <div class="d-flex align-items-center w-100">
                            <img src="{{ $formation->image ? Storage::url($formation->image) : 'https://via.placeholder.com/100x70?text=No+Image' }}"
                                alt="{{ $formation->name }}" class="rounded me-3" width="80" height="50"
                                style="object-fit: cover;">
                            <div class="me-auto">
                                <h6 class="fw-bolder mb-0">{{ $formation->name }}</h6>
                            </div>
                            <span class="badge bg-light-primary text-primary me-3">{{ count($positionsInFormation) }}
                                Posisi Dimiliki</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse-{{ $formationId }}" class="accordion-collapse collapse"
                    data-bs-parent="#packagesAccordion">
                    <div class="accordion-body">
                        @foreach ($positionsInFormation as $position)
                            @php
                                $isActive = Auth::id() && Auth::user()->position_id == $position->id;
                                // Variabel ini hanya akan berisi paket BERBAYAR untuk posisi saat ini
                                $packagesForThisPosition = $purchasedPositions->where('id', $position->id);
                            @endphp
                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-md-center p-3 rounded mb-2 border">
                                <div>
                                    <h6 class="fw-bolder mb-1">{{ $position->name }}</h6>
                                    <div class="d-flex flex-wrap gap-1">

                                        @if ($packagesForThisPosition->isNotEmpty())
                                            @foreach ($packagesForThisPosition as $pkg)
                                                @if ($pkg->pivot)
                                                    @if ($pkg->pivot->package_type == 'bimbingan')
                                                        <span class="badge bg-light-success text-success">Paket
                                                            Bimbel</span>
                                                    @else
                                                        <span class="badge bg-light-primary text-primary">Paket
                                                            Aplikasi</span>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            {{-- Jika tidak ada di daftar pembelian, ini PASTI paket gratis --}}
                                            <span class="badge bg-light-secondary text-secondary">Paket Gratis</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                                    @if ($isActive)
                                        <span class="badge bg-success"><i class="ti ti-player-play me-1"></i> Sedang
                                            Aktif</span>
                                    @else
                                        <button class="btn btn-sm btn-primary"
                                            wire:click="setActivePackage({{ $position->id }})">Aktifkan</button>
                                    @endif
                                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary"
                                        wire:navigate>Lanjutkan</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card card-body text-center py-5">
                    <img src="{{ asset('assets/illustrations/empty-box.png') }}" alt="Empty" class="mx-auto mb-3"
                        style="max-width: 150px;">
                    <h5 class="mt-2">Anda Belum Memiliki Paket Apapun</h5>
                    <p class="text-muted">Jika Anda mendaftar dengan posisi awal, paket gratis Anda akan muncul di sini.
                    </p>
                    <a href="{{ route('students.packages.index') }}" class="btn btn-primary mt-2" wire:navigate>Lihat
                        Pilihan Paket</a>
                </div>
            </div>
        @endforelse
    </div>
</div>

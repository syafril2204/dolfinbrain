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

    <div class="row">
        @forelse ($groupedByFormation as $formationId => $positionsInFormation)
            @php
                $formation = $positionsInFormation->first()->formation;
            @endphp
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    {{-- Gambar Formasi --}}
                    <img src="{{ $formation->image ? Storage::url($formation->image) : 'https://via.placeholder.com/400x200?text=No+Image' }}"
                        class="card-img-top" alt="{{ $formation->name }}" style="object-fit: cover; height: 200px;">

                    {{-- Body --}}
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $formation->name }}</h5>
                        <p class="text-muted mb-2">{{ count($positionsInFormation) }} Jabatan Dimiliki</p>

                        {{-- Tombol collapse --}}
                        <button class="btn btn-sm btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $formationId }}">
                            Lihat Jabatan
                        </button>

                        {{-- Collapse isi posisi --}}
                        <div class="collapse mt-3" id="collapse-{{ $formationId }}">
                            @foreach ($positionsInFormation as $position)
                                @php
                                    $isActive = Auth::id() && Auth::user()->position_id == $position->id;
                                    $packagesForThisPosition = $purchasedPositions->where('id', $position->id);
                                @endphp
                                <div class="border rounded p-2 mb-2">
                                    <h6 class="fw-semibold mb-1">{{ $position->name }}</h6>
                                    {{-- Badge Paket --}}
                                    <div class="mb-2">
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
                                            <span class="badge bg-light-secondary text-secondary">Paket Gratis</span>
                                        @endif
                                    </div>
                                    {{-- Tombol Aksi --}}
                                    <div class="d-flex gap-2">
                                        @if ($isActive)
                                            <span class="badge bg-success">
                                                <i class="ti ti-player-play me-1"></i> Aktif
                                            </span>
                                        @else
                                            <button class="btn btn-sm btn-primary"
                                                wire:click="setActivePackage({{ $position->id }})">Aktifkan</button>
                                        @endif
                                        <a href="{{ route('students.materi.index') }}"
                                            class="btn btn-sm btn-outline-primary" wire:navigate>
                                            Lanjutkan
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card card-body text-center py-5">
                    <img src="{{ asset('assets/illustrations/empty-box.png') }}" alt="Empty" class="mx-auto mb-3"
                        style="max-width: 150px;">
                    <h5 class="mt-2">Anda Belum Memiliki Paket Apapun</h5>
                    <p class="text-muted">Jika Anda mendaftar dengan jabatan awal, paket gratis Anda akan muncul di
                        sini.
                    </p>
                    <a href="{{ route('students.packages.index') }}" class="btn btn-primary mt-2" wire:navigate>
                        Lihat Pilihan Paket
                    </a>
                </div>
            </div>
        @endforelse
    </div>


</div>

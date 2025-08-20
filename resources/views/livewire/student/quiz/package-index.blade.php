<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Soal</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Soal</li>
                </ol>
            </nav>
        </div>
    </div>

    <ul class="nav nav-tabs mt-3">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'soal' ? 'active' : '' }}" wire:click.prevent="switchTab('soal')"
                href="#">Soal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'history' ? 'active' : '' }}" wire:click.prevent="switchTab('history')"
                href="#">History</a>
        </li>
    </ul>


    <div class="tab-content">
        <div class="tab-pane fade {{ $activeTab === 'soal' ? 'show active' : '' }}">
            <div class="row mt-4">
                @forelse ($packages as $index => $package)
                    <div class="col-md-6 col-lg-4" wire:key="soal-{{ $package->id }}">
                        @php
                            if (auth()->user()->hasLmsAccess()) {
                                $isLocked = false;
                            } else {
                                if ($index == 0) {
                                    $isLocked = false;
                                } else {
                                    $isLocked = true;
                                }
                            }
                        @endphp
                        <a href="{{ !$isLocked ? route('students.quiz.attempt', $package) : '#' }}"
                            class="text-decoration-none @if ($isLocked) disabled-link @endif"
                            @if ($isLocked) onclick="event.preventDefault(); alert('Selesaikan paket kuis sebelumnya terlebih dahulu.');" @endif>
                            <div class="card border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-semibold mb-0 text-dark">{{ $package->title }}</h6>
                                        @if ($isLocked)
                                            <i class="ti ti-lock text-muted fs-6"></i>
                                        @else
                                            <span class="badge bg-primary">Buka</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h5 class="mt-2">Belum Ada Paket Soal</h5>
                        <p class="text-muted">Saat ini belum ada paket soal yang tersedia untuk formasi Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade {{ $activeTab === 'history' ? 'show active' : '' }}">
            <div class="mt-4">
                @forelse ($historyPackages as $package)
                    <div class="mb-3 col-md-6 col-lg-4" wire:key="history-{{ $package->id }}">
                        <div class="d-flex justify-content-between align-items-center border rounded p-3"
                            style="cursor: pointer;" wire:click="toggleHistory({{ $package->id }})">
                            <h6 class="fw-semibold mb-0">{{ $package->title }}</h6>
                            <span
                                class="badge bg-light-primary text-primary rounded-pill d-flex align-items-center px-3 py-2">
                                {{ $package->attempts->count() }}x dikerjakan
                                <i
                                    class="ti {{ $expandedPackageId === $package->id ? 'ti-chevron-up' : 'ti-chevron-down' }} ms-2"></i>
                            </span>
                        </div>

                        @if ($expandedPackageId === $package->id)
                            <div class="border border-top-0 rounded-bottom p-3">
                                <div
                                    class="d-flex justify-content-between align-items-center bg-light-primary rounded p-3 mb-3">
                                    <div>
                                        <p class="fw-semibold mb-1">Kerjakan Ulang</p>
                                        <small style="font-size: 12px">Yuk, tingkatkan nilaimu lagi!</small>
                                    </div>
                                    <a href="{{ route('students.quiz.attempt', $package) }}" class="btn btn-primary"
                                        style="font-size:11px">Mulai Sekarang</a>
                                </div>

                                @foreach ($package->attempts as $attempt)
                                    <div
                                        class="d-flex justify-content-between align-items-center border rounded p-3 mb-2">
                                        <div>
                                            <p class="fw-semibold mb-1">Pengerjaan {{ $loop->remaining + 1 }}</p>
                                            <small>{{ \Carbon\Carbon::parse($attempt->finished_at)->translatedFormat('j F Y | H:i') }}</small>
                                        </div>
                                        <span class="badge bg-light-success text-success fs-3">Skor :
                                            {{ round($attempt->score) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h5 class="mt-2">Riwayat Pengerjaan Kosong</h5>
                        <p class="text-muted">Anda belum pernah menyelesaikan paket soal apapun.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .disabled-link {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
@endpush

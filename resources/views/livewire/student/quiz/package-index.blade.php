<div>
    {{-- Header & Breadcrumb --}}
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

    {{-- Daftar Paket Kuis --}}
    <div class="row">
        @forelse ($packages as $package)
            <div class="col-md-6 col-lg-4" wire:key="{{ $package->id }}">
                @php
                    $isLocked = $package->id !== $latestPackageId;
                @endphp

                <a href="{{ !$isLocked ? route('students.quiz.attempt', $package) : '#' }}"
                    class="text-decoration-none {{ $isLocked ? 'disabled-link' : '' }}"
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

@push('styles')
    <style>
        .disabled-link {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
@endpush

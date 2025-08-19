<div>
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Materi Belajar</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Materi</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Fitur Pencarian --}}
    <div class="d-flex justify-content-end mb-4">
        <div class="position-relative" style="min-width: 250px;">
            <input type="text" class="form-control" placeholder="Cari materi..."
                wire:model.live.debounce.300ms="searchTerm" style="padding-right: 40px;">
            <i class="ti ti-search position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);"></i>
        </div>
    </div>

    <div class="row">
        @if ($userHasPosition)
            @forelse ($materials as $material)
                @php
                    // [PERBAIKAN] Logika dinamis untuk ukuran file
                    $sizeInKb = $material->file_size / 1024;
                    if ($sizeInKb < 1024) {
                        $displaySize = number_format($sizeInKb, 1) . ' KB';
                    } else {
                        $displaySize = number_format($sizeInKb / 1024, 2) . ' MB';
                    }

                    // Hanya materi pertama atau jika user punya akses yang bisa di-download
                    $canDownload = $loop->first || auth()->user()->hasMaterialAccess();
                @endphp

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 {{ !$canDownload ? 'bg-light' : '' }}">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3 flex-shrink-0">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        @if ($canDownload)
                                            <i class="ti ti-file-text fs-6 text-primary"></i>
                                        @else
                                            <i class="ti ti-lock fs-6 text-muted"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="fw-semibold mb-0 text-truncate" title="{{ $material->title }}">
                                        {{ $material->title }}
                                    </h6>
                                    <small class="text-muted">{{ $displaySize }}</small>
                                </div>
                                <div class="ms-2 flex-shrink-0">
                                    @if ($canDownload)
                                        <a href="{{ route('materials.download', $material) }}"
                                            class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 35px; height: 35px;" title="Unduh Materi">
                                            <i class="ti ti-download"></i>
                                        </a>
                                    @else
                                        <a href="#"
                                            onclick="event.preventDefault(); alert('Silakan beli paket untuk membuka semua materi.');"
                                            class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 35px; height: 35px;" title="Materi Terkunci">
                                            <i class="ti ti-lock"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="{{ asset('assets/illustrations/empty-search.png') }}" alt="Not Found" class="mx-auto mb-3"
                        style="max-width: 200px;">
                    <h5 class="mt-2">Materi Tidak Ditemukan</h5>
                    <p class="text-muted">Tidak ada materi yang cocok dengan pencarian Anda atau untuk posisi Anda.</p>
                </div>
            @endforelse
        @else
            <div class="col-12 text-center py-5">
                <img src="{{ asset('assets/illustrations/profile-needed.png') }}" alt="Profile Needed"
                    class="mx-auto mb-3" style="max-width: 200px;">
                <h5 class="mt-2">Pilih Formasi Anda Terlebih Dahulu</h5>
                <p class="text-muted">Untuk dapat melihat materi yang relevan, silakan lengkapi profil Anda.</p>
                <a href="{{ route('students.profile.update') }}" class="btn btn-primary mt-2" wire:navigate>Lengkapi
                    Profil</a>
            </div>
        @endif
    </div>
</div>

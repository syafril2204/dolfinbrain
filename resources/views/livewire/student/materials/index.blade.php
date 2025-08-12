<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Materi Belajar</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Materi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <div class="position-relative">
            <input type="text" class="form-control" placeholder="Cari materi..."
                wire:model.live.debounce.300ms="searchTerm" style="padding-right: 30px;">
            <i class="ti ti-search position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);"></i>
        </div>
    </div>

    <div class="row">
        @if ($userHasPosition)
            @forelse ($materials as $index => $material)
                @if ($index == 0)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ Storage::url($material->file_path) }}" class="card-link text-decoration-none">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-semibold mb-0 text-dark">{{ $material->title }}</h6>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                            <path
                                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                            <path
                                                d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @else
                    @if (auth()->user()->hasMaterialAccess())
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ Storage::url($material->file_path) }}" class="card-link text-decoration-none">
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="fw-semibold mb-0 text-dark">{{ $material->title }}</h6>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                <path
                                                    d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                                <path
                                                    d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="col-md-6 col-lg-4" wire:key="{{ $material->id }}">
                            <a href="#" class="card-link text-decoration-none"
                                onclick="event.preventDefault(); alert('Silakan berlangganan untuk membuka materi ini.');">
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="fw-semibold mb-0 text-dark">{{ $material->title }}</h6>
                                            <i class="ti ti-lock text-muted fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endif
            @empty
                <div class="col-12 text-center py-5">
                    <h5 class="mt-2">Materi Tidak Ditemukan</h5>
                    <p class="text-muted">Tidak ada materi yang cocok dengan pencarian Anda.</p>
                </div>
            @endforelse
        @else
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">🤔</h4>
                <h5 class="mt-2">Pilih Formasi Terlebih Dahulu</h5>
                <p class="text-muted">Anda harus melengkapi pendaftaran dengan memilih formasi untuk melihat materi yang
                    relevan.</p>
                <a href="{{ route('register') }}" class="btn btn-primary mt-2">Lengkapi Pendaftaran</a>
            </div>
        @endif
    </div>
</div>

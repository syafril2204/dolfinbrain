<div>
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">LMS Space</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">LMS Space</li>
                </ol>
            </nav>
        </div>
    </div>

    @if ($hasAccess)
        {{-- Tampilan jika AKSES DIBERIKAN --}}
        <div class="row">
            @forelse ($lmsSpaces as $space)
                <div class="col-md-6 col-lg-4" wire:key="{{ $space->id }}">
                    <div class="card rounded-2 overflow-hidden">
                        <div class="position-relative">
                            <a href="{{ route('students.lms.show', $space) }}" wire:navigate>
                                <img src="{{ $space->image_path ? Storage::url($space->image_path) : 'https://via.placeholder.com/350x200' }}"
                                    class="card-img-top rounded-0" alt="..."
                                    style="height: 200px; object-fit: cover;">
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <h6 class="fw-semibold fs-4 mb-2">{{ $space->title }}</h6>
                            <p>{{ Str::limit($space->description, 100) }}</p>
                            <a href="{{ route('students.lms.show', $space) }}" class="fw-semibold" wire:navigate>Masuk
                                Pertemuan ></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h5 class="mt-2">Konten Belum Tersedia</h5>
                    <p class="text-muted">LMS Space untuk formasi Anda akan segera hadir.</p>
                </div>
            @endforelse
        </div>
    @else
        <div class="text-center py-5">
            <img src="{{ asset('assets/img/illustration.png') }}" alt="Access Denied" class="mb-4">
            <h3 class="fw-bolder">Akses Ditolak</h3>
            <p class="text-muted">Fitur ini hanya tersedia untuk pengguna premium. Silakan upgrade paketmu terlebih
                dahulu.</p>
            <a href="{{ route('students.packages.index') }}" class="btn btn-primary mt-2">Lihat Paket</a>
        </div>
    @endif
</div>

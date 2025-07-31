<div>
    {{-- Header & Breadcrumb --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manajemen Materi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Materi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Aksi & Pencarian --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.materials.create') }}" class="btn btn-primary">Tambah Materi</a>
        <div class="position-relative" style="width: 250px;">
            <input type="text" class="form-control" placeholder="Cari materi..."
                wire:model.live.debounce.300ms="searchTerm">
            <i class="ti ti-search position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);"></i>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    {{-- Daftar Kartu Materi --}}
    <div class="row">
        @forelse ($materials as $material)
            <div class="col-md-6 col-lg-4" wire:key="{{ $material->id }}">
                <div class="card border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-file-text fs-8 text-primary"></i>
                                <div class="ms-3">
                                    <h6 class="fw-semibold mb-0 fs-4">{{ Str::limit($material->title, 25) }}</h6>
                                    <span class="fs-2 text-muted">{{ number_format($material->file_size / 1024, 2) }}
                                        KB</span>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="#"
                                            wire:click.prevent="showDetail({{ $material->id }})">
                                            <i class="fs-4 ti ti-eye"></i>Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3"
                                            href="{{ route('admin.materials.edit', $material) }}">
                                            <i class="fs-4 ti ti-edit"></i>Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3 text-danger"
                                            href="#" wire:click.prevent="delete({{ $material->id }})"
                                            wire:confirm="Anda yakin ingin menghapus materi ini?">
                                            <i class="fs-4 ti ti-trash"></i>Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h5 class="mt-2 text-muted">Materi Tidak Ditemukan</h5>
                <p class="text-muted">Tidak ada materi yang cocok dengan pencarian Anda atau belum ada materi yang
                    dibuat.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $materials->links() }}
    </div>

    {{-- Modal untuk Detail Materi --}}
    @if ($isDetailModalOpen && $selectedMaterial)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Materi</h5>
                        <button type="button" class="btn-close" wire:click="closeDetailModal"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="fw-semibold">{{ $selectedMaterial->title }}</h6>
                        <p class="text-muted">{{ $selectedMaterial->description ?? 'Tidak ada deskripsi.' }}</p>
                        <hr>
                        <p><strong>Tipe File:</strong> {{ strtoupper($selectedMaterial->file_type) }}</p>
                        <p><strong>Ukuran File:</strong> {{ number_format($selectedMaterial->file_size / 1024, 2) }} KB
                        </p>
                        <div>
                            <strong>Untuk Posisi:</strong><br>
                            @forelse($selectedMaterial->positions as $position)
                                <span class="badge bg-light-primary text-primary mt-1">{{ $position->formation->name }}
                                    - {{ $position->name }}</span>
                            @empty
                                <span class="text-muted">Tidak ditugaskan ke posisi manapun.</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailModal">Tutup</button>
                        <a href="{{ route('materials.download', $selectedMaterial) }}" class="btn btn-primary">Unduh
                            File</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:navigated', () => {
            const pageKey = 'reloaded_materials_page';
            if (!sessionStorage.getItem(pageKey)) {
                sessionStorage.setItem(pageKey, 'true');
                window.location.reload();
            }
        });

        document.addEventListener('livewire:navigating', () => {
            sessionStorage.removeItem('reloaded_materials_page');
        }, {
            once: true
        });
    </script>
@endpush

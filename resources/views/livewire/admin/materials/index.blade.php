<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manajemen Materi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="#">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Materi</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('dist/images/breadcrumb/ChatBc.png') }}" alt=""
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-0">Daftar Materi</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control" placeholder="Cari materi..."
                    wire:model.live.debounce.300ms="searchTerm">
                <a href="{{ route('admin.materials.create') }}" class="btn btn-primary" wire:navigate>Tambah Materi</a>
            </div>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div class="row">
                @forelse ($materials as $material)
                    <div class="col-md-6 col-lg-4" wire:key="{{ $material->id }}">
                        <div class="card border">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-file-text fs-8 text-primary"></i>
                                        <div class="ms-3">
                                            <h6 class="fw-semibold mb-0 fs-4">{{ Str::limit($material->title, 25) }}
                                            </h6>
                                            <span class="fs-2 text-muted">
                                                {{ number_format($material->file_size / 1024, 2) }} KB
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ms-auto">
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted"
                                                id="dropdownMenuButton-{{ $material->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-6"></i>
                                            </a>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton-{{ $material->id }}">
                                                <li><a class="dropdown-item d-flex align-items-center gap-3"
                                                        href="{{ route('admin.materials.edit', $material) }}"
                                                        wire:navigate><i class="fs-4 ti ti-edit"></i>Edit</a></li>
                                                <li><a class="dropdown-item d-flex align-items-center gap-3"
                                                        href="#" wire:click.prevent="delete({{ $material->id }})"
                                                        wire:confirm="Anda yakin ingin menghapus materi ini?"><i
                                                            class="fs-4 ti ti-trash"></i>Delete</a></li>
                                                <li><a class="dropdown-item d-flex align-items-center gap-3"
                                                        href="{{ route('materials.download', $material) }}"><i
                                                            class="fs-4 ti ti-download"></i>Download</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    @foreach ($material->positions as $position)
                                        <span
                                            class="badge bg-light-secondary text-secondary fw-semibold fs-2 me-1">{{ $position->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada materi yang ditambahkan atau tidak ada hasil yang
                            cocok dengan pencarian Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

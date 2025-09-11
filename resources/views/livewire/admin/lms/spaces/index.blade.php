<div>
    {{-- Breadcrumb Dinamis --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Manajemen LMS Space</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $crumb)
                        @if ($loop->last)
                            <li class="breadcrumb-item active" aria-current="page">{{ $crumb['label'] }}</li>
                        @else
                            <li class="breadcrumb-item">
                                <a class="text-muted" href="#"
                                    wire:click.prevent="goToBreadcrumb({{ $crumb['level'] }})">{{ $crumb['label'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    {{-- Tampilan Konten Dinamis --}}
    @if ($currentPosition)
        {{-- LEVEL 3: DAFTAR LMS SPACE --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title fw-semibold mb-0">Daftar LMS untuk {{ $currentPosition->name }}</h5>
                <a href="{{ route('admin.lms-spaces.create', ['position_id' => $currentPosition->id]) }}"
                    class="btn btn-primary" wire:navigate>
                    Tambah LMS Space
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $space)
                                <tr>
                                    <td>{{ $space->title }}</td>
                                    <td>
                                        @if ($space->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.lms-spaces.content.index', $space) }}"
                                            class="btn btn-sm btn-outline-info" wire:navigate>Konten</a>
                                        <a href="{{ route('admin.lms-spaces.edit', $space) }}"
                                            class="btn btn-sm btn-warning" wire:navigate>Edit</a>
                                        <button wire:click="deleteSpace({{ $space->id }})" wire:confirm="Yakin?"
                                            class="btn btn-sm btn-danger">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada LMS Space untuk posisi ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($items->hasPages())
                    <div class="mt-3">{{ $items->links('partials.custom-pagination') }}</div>
                @endif
            </div>
        </div>
    @elseif ($currentFormation)
        {{-- LEVEL 2: FOLDER POSISI --}}
        <div class="row">
            @forelse($items as $position)
                <div class="col-md-4 col-lg-3">
                    <div class="card text-center shadow-sm hover-scale-up"
                        wire:click="selectPosition({{ $position->id }})" style="cursor: pointer;">
                        <div class="card-body">
                            <i class="ti ti-folder text-info" style="font-size: 4rem;"></i>
                            <h5 class="card-title mt-3">{{ $position->name }}</h5>
                            <p class="card-text text-muted">{{ $position->lmsSpaces()->count() }} LMS</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Tidak ada posisi di dalam formasi ini.</p>
                </div>
            @endforelse
        </div>
    @else
        {{-- LEVEL 1: FOLDER FORMASI --}}
        <div class="row">
            @forelse($items as $formation)
                <div class="col-md-4 col-lg-3">
                    <div class="card text-center shadow-sm hover-scale-up"
                        wire:click="selectFormation({{ $formation->id }})" style="cursor: pointer;">
                        <div class="card-body">
                            <i class="ti ti-folder text-info" style="font-size: 4rem;"></i>
                            <h5 class="card-title mt-3">{{ $formation->name }}</h5>
                            <p class="card-text text-muted">{{ $formation->positions()->count() }} Posisi</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Belum ada formasi yang dibuat.</p>
                </div>
            @endforelse
        </div>
    @endif
</div>

@push('styles')
    <style>
        .hover-scale-up {
            transition: transform 0.2s ease-in-out;
        }

        .hover-scale-up:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07) !important;
        }
    </style>
@endpush

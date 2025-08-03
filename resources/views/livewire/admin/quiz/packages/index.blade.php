<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manajemen Kuis</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="#">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Paket Kuis</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="formation" class="form-label">Filter Berdasarkan Formasi</label>
                    <select id="formation" class="form-select" wire:model.live="selectedFormation">
                        <option value="">Semua Formasi</option>
                        @foreach ($formations as $formation)
                            <option value="{{ $formation->id }}">{{ $formation->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="position" class="form-label">Filter Berdasarkan Jabatan</label>
                    <select id="position" class="form-select" wire:model.live="selectedPosition"
                        @if (!$selectedFormation) disabled @endif>
                        <option value="">Semua Jabatan</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-0">Daftar Paket Kuis</h5>
            <a href="{{ route('admin.quiz-packages.create') }}" class="btn btn-primary">Tambah Paket</a>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table border">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Durasi (Menit)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($packages as $package)
                            <tr>
                                <td>{{ $package->title }}</td>
                                <td>{{ $package->duration_in_minutes }}</td>
                                <td>
                                    @if ($package->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.quiz-packages.questions.index', $package) }}"
                                        class="btn btn-sm btn-info">Soal</a>
                                    <a href="{{ route('admin.quiz-packages.show', $package) }}"
                                        class="btn btn-sm btn-outline-secondary">Lihat</a>
                                    <a href="{{ route('admin.quiz-packages.edit', $package) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button wire:click="delete({{ $package->id }})" wire:confirm="Yakin?"
                                        class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada paket kuis yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $packages->links() }}</div>
        </div>
    </div>
</div>

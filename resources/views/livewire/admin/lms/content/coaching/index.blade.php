<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Jadwal Coaching: {{ Str::limit($lms_space->title, 30) }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.lms-spaces.index') }}">LMS
                            Space</a></li>
                    <li class="breadcrumb-item"><a class="text-muted"
                            href="{{ route('admin.lms-spaces.content.index', $lms_space) }}">Kelola Konten</a></li>
                    <li class="breadcrumb-item" aria-current="page">Coaching</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fw-semibold">Daftar Jadwal Coaching</h5>
            <div>
                <a href="{{ route('admin.lms-spaces.content.index', $lms_space) }}"
                    class="btn btn-outline-secondary me-2">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.lms-spaces.content.coaching.create', $lms_space) }}" class="btn btn-primary">
                    Tambah Jadwal
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table border">
                    <thead>
                        <tr>
                            <th>Topik</th>
                            <th>Trainer</th>
                            <th>Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coachings as $coaching)
                            <tr>
                                <td>{{ $coaching->title }}</td>
                                <td>{{ $coaching->trainer_name }}</td>
                                <td>{{ $coaching->start_at->translatedFormat('d M Y, H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.lms-spaces.content.coaching.edit', ['lms_space' => $lms_space, 'coaching' => $coaching]) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button wire:click="delete({{ $coaching->id }})" wire:confirm="Yakin?"
                                        class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada jadwal coaching.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

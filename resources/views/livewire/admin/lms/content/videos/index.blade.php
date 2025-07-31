<div>
    {{-- Header & Breadcrumb --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Rekaman: {{ Str::limit($lms_space->title, 30) }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted"
                            href="{{ route('admin.lms-spaces.content.index', $lms_space) }}">Kelola Konten</a></li>
                    <li class="breadcrumb-item" aria-current="page">Rekaman</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fw-semibold">Daftar Video Rekaman</h5>
            <a href="{{ route('admin.lms-spaces.content.videos.create', $lms_space) }}" class="btn btn-primary">Tambah
                Video</a>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table border">
                    <thead>
                        <tr>
                            <th>Urutan</th>
                            <th>Judul</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($videos as $video)
                            <tr>
                                <td>{{ $video->order }}</td>
                                <td>{{ $video->title }}</td>
                                <td>{{ $video->duration }}</td>
                                <td>
                                    {{-- 👇 [BAGIAN BARU] Tombol Preview --}}
                                    <button wire:click="showPreview({{ $video->id }})"
                                        class="btn btn-sm btn-outline-secondary">Preview</button>

                                    <a href="{{ route('admin.lms-spaces.content.videos.edit', ['lms_space' => $lms_space, 'video' => $video]) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button wire:click="delete({{ $video->id }})" wire:confirm="Yakin?"
                                        class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada video rekaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($isPreviewModalOpen && $previewingVideo)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $previewingVideo->title }}</h5>
                        <button type="button" class="btn-close" wire:click="closePreviewModal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $previewingVideo->youtube_url }}" title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

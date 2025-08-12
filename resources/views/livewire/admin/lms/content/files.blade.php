<div>
    {{-- Header & Breadcrumb --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">File & Audio: {{ Str::limit($lms_space->title, 30) }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted"
                            href="{{ route('admin.lms-spaces.content.index', $lms_space) }}">Kelola Konten</a></li>
                    <li class="breadcrumb-item" aria-current="page">File & Audio</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    {{-- Navigasi Tab --}}
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link {{ $activeTab === 'files' ? 'active' : '' }}" href="#"
                wire:click.prevent="switchTab('files')">File Rekap</a></li>
        <li class="nav-item"><a class="nav-link {{ $activeTab === 'audio' ? 'active' : '' }}" href="#"
                wire:click.prevent="switchTab('audio')">Audio</a></li>
    </ul>

    <div class="card">
        {{-- Konten Tab File Rekap --}}
        <div class="{{ $activeTab === 'files' ? 'd-block' : 'd-none' }}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">Daftar File Rekap</h5>
                <button wire:click="create('files')" class="btn btn-primary">Tambah File</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tipe</th>
                                <th>Ukuran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recapFiles as $file)
                                <tr>
                                    <td>{{ $file->title }}</td>
                                    <td><span class="badge bg-secondary">{{ strtoupper($file->file_type) }}</span></td>
                                    <td>{{ number_format($file->file_size / 1024, 2) }} KB</td>
                                    <td>
                                        <a href="{{ route('admin.lms-resources.download', $file) }}"
                                            class="btn btn-sm btn-outline-secondary">Unduh</a>
                                        <button wire:click="edit({{ $file->id }})"
                                            class="btn btn-sm btn-warning">Edit</button>
                                        <button wire:click="delete({{ $file->id }})" wire:confirm="Yakin?"
                                            class="btn btn-sm btn-danger">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada file rekap.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Konten Tab Audio --}}
        <div class="{{ $activeTab === 'audio' ? 'd-block' : 'd-none' }}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">Daftar Audio</h5>
                <button wire:click="create('audio')" class="btn btn-primary">Tambah Audio</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tipe</th>
                                <th>Ukuran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($audioRecordings as $audio)
                                <tr>
                                    <td>{{ $audio->title }}</td>
                                    <td><span class="badge bg-warning">{{ strtoupper($audio->file_type) }}</span></td>
                                    <td>{{ number_format($audio->file_size / 1024, 2) }} KB</td>
                                    <td>
                                        <button wire:click="showPreview({{ $audio->id }})"
                                            class="btn btn-sm btn-outline-info">Preview</button>
                                        <a href="{{ route('admin.lms-resources.download', $audio) }}"
                                            class="btn btn-sm btn-outline-secondary">Unduh</a>
                                        <button wire:click="edit({{ $audio->id }})"
                                            class="btn btn-sm btn-warning">Edit</button>
                                        <button wire:click="delete({{ $audio->id }})" wire:confirm="Yakin?"
                                            class="btn btn-sm btn-danger">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada rekaman audio.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Tambah/Edit --}}
    @if ($isModalOpen)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $isEditMode ? 'Edit' : 'Tambah' }}
                            {{ $type === 'recap_file' ? 'File Rekap' : 'Audio' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" class="form-control" wire:model="title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload File</label>
                                <input type="file" class="form-control" wire:model="file">
                                @if ($isEditMode && !$file)
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah
                                        file.</small>
                                @endif
                                <div wire:loading wire:target="file" class="text-primary mt-1">Uploading...</div>
                                @error('file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal untuk Preview Audio --}}
    @if ($isPreviewModalOpen && $previewingAudio)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview: {{ $previewingAudio->title }}</h5>
                        <button type="button" class="btn-close" wire:click="closePreviewModal"></button>
                    </div>
                    <div class="modal-body">
                        <audio controls class="w-100">
                            <source src="{{ Storage::url($previewingAudio->file_path) }}"
                                type="audio/{{ $previewingAudio->file_type }}">
                            Browser Anda tidak mendukung elemen audio.
                        </audio>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

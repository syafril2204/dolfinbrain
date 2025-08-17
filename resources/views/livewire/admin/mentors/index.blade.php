<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Manajemen Mentor</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Mentor</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-0 lh-sm">Daftar Mentor</h5>
            <button wire:click="create()" class="btn btn-primary">Tambah Mentor</button>
        </div>
        <div class="card-body p-4">
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="table-responsive rounded-2 mb-4">
                <table class="table border text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Mentor</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Jabatan</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Aksi</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mentors as $mentor)
                            <tr wire:key="{{ $mentor->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $mentor->photo ? Storage::url($mentor->photo) : asset('dist/images/profile/user-1.jpg') }}"
                                            class="rounded-circle" width="40" height="40">
                                        <div class="ms-3">
                                            <h6 class="fs-4 fw-semibold mb-0">{{ $mentor->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $mentor->position->formation->name }} - {{ $mentor->position->name }}</td>
                                <td>
                                    <button wire:click="edit({{ $mentor->id }})"
                                        class="btn btn-sm btn-warning">Edit</button>
                                    <button wire:click="delete({{ $mentor->id }})"
                                        wire:confirm="Yakin ingin menghapus mentor ini?"
                                        class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data mentor.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $mentors->links() }}
        </div>
    </div>

    {{-- Modal Form Tambah/Edit --}}
    @if ($isModalOpen)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $isEditMode ? 'Edit Mentor' : 'Tambah Mentor Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Mentor</label>
                                <input type="text" class="form-control" wire:model="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="position_id" class="form-label">Jabatan</label>
                                <select class="form-select" wire:model="position_id">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->formation->name }} -
                                            {{ $position->name }}</option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Singkat</label>
                                <textarea class="form-control" wire:model="description" rows="3"></textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Foto Mentor</label>
                                <input type="file" class="form-control" wire:model="photo">
                                <div wire:loading wire:target="photo" class="text-primary mt-1">Uploading...</div>
                                @if ($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail mt-2"
                                        style="max-height: 150px;">
                                @elseif ($existingPhotoUrl)
                                    <img src="{{ Storage::url($existingPhotoUrl) }}" class="img-thumbnail mt-2"
                                        style="max-height: 150px;">
                                @endif
                                @error('photo')
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
</div>

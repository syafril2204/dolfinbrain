{{-- resources/views/livewire/admin/formations/index.blade.php --}}
<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manajemen Formasi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="#">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Formasi</li>
                        </ol>
                    </nav>
                </div>
                {{-- ... bagian gambar ... --}}
            </div>
        </div>
    </div>

    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-0 lh-sm">Daftar Formasi</h5>
            <button wire:click="create()" class="btn btn-primary">Tambah Formasi</button>
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
                                <h6 class="fs-4 fw-semibold mb-0">Gambar</h6>
                            </th> {{-- KOLOM BARU --}}
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Nama Formasi</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Deskripsi Singkat</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Aksi</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($formations as $formation)
                            <tr>
                                {{-- DATA GAMBAR BARU --}}
                                <td>
                                    <img src="{{ $formation->image ? Storage::url($formation->image) : 'https://via.placeholder.com/100x70?text=No+Image' }}"
                                        alt="avatar" class="rounded" width="100" height="70"
                                        style="object-fit: cover;">
                                </td>
                                <td>{{ $formation->name }}</td>
                                <td>{{ Str::limit($formation->short_description, 50) }}</td>
                                <td>
                                    <a href="{{ route('admin.positions.index', $formation) }}"
                                        class="btn btn-sm btn-outline-info" wire:navigate>Posisi</a>
                                    <button wire:click="edit({{ $formation->id }})"
                                        class="btn btn-sm btn-warning">Edit</button>
                                    <button wire:click="delete({{ $formation->id }})" wire:confirm="Yakin?"
                                        class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data formasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $formations->links() }}
        </div>
    </div>

    {{-- Modal Form Tambah/Edit --}}
    @if ($isModalOpen)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $isEditMode ? 'Edit Formasi' : 'Tambah Formasi Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Formasi</label>
                                <input type="text" class="form-control" wire:model="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Singkat</label>
                                <input type="text" class="form-control" wire:model="short_description">
                                @error('short_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- INPUT FILE BARU --}}
                            <div class="mb-3">
                                <label class="form-label">Gambar Formasi</label>
                                <input type="file" class="form-control" wire:model="image">
                                <div wire:loading wire:target="image" class="text-primary mt-1">Uploading...</div>
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail mt-2"
                                        style="max-height: 150px;">
                                @elseif ($existingImageUrl)
                                    <img src="{{ Storage::url($existingImageUrl) }}" class="img-thumbnail mt-2"
                                        style="max-height: 150px;">
                                @endif
                                @error('image')
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

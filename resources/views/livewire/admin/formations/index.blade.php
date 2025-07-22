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
                                <h6 class="fs-4 fw-semibold mb-0">No</h6>
                            </th>
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
                            <tr wire:key="{{ $formation->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $formation->name }}</td>
                                <td>{{ $formation->short_description }}</td>
                                <td>
                                    <a href="{{ route('admin.positions.index', $formation) }}"
                                        class="btn btn-sm btn-info">Posisi</a>
                                    <button wire:click="edit({{ $formation->id }})"
                                        class="btn btn-sm btn-warning">Edit</button>
                                    <button wire:click="delete({{ $formation->id }})"
                                        wire:confirm="Anda yakin ingin menghapus formasi ini?"
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

    @if ($isModalOpen)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $isEditMode ? 'Edit Formasi' : 'Tambah Formasi Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Formasi</label>
                                <input type="text" class="form-control" id="name" wire:model.defer="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="short_description" class="form-label">Deskripsi Singkat</label>
                                <input type="text" class="form-control" id="short_description"
                                    wire:model.defer="short_description">
                                @error('short_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                            <button type="submit"
                                class="btn btn-primary">{{ $isEditMode ? 'Simpan Perubahan' : 'Simpan' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>

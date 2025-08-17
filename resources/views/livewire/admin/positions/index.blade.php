<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manajemen Jabatan: {{ $formation->name }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted"
                                    href="{{ route('admin.formations.index') }}">Formasi</a></li>
                            <li class="breadcrumb-item" aria-current="page">Jabatan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-0 lh-sm">Daftar Jabatan</h5>
            <button wire:click="create()" class="btn btn-primary">Tambah Jabatan</button>
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
                                <h6 class="fs-4 fw-semibold mb-0">Nama Jabatan</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Harga Mandiri</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Harga Bimbingan</h6>
                            </th>
                            <th>
                                <h6 class="fs-4 fw-semibold mb-0">Aksi</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($positions as $position)
                            <tr wire:key="{{ $position->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $position->name }}</td>
                                <td>Rp {{ number_format($position->price_mandiri, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($position->price_bimbingan, 0, ',', '.') }}</td>
                                <td>
                                    <button wire:click="edit({{ $position->id }})"
                                        class="btn btn-sm btn-warning">Edit</button>
                                    <button wire:click="delete({{ $position->id }})"
                                        wire:confirm="Anda yakin ingin menghapus Jabatan ini?"
                                        class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data Jabatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk Create/Edit Jabatan -->
    @if ($isModalOpen)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $isEditMode ? 'Edit Jabatan' : 'Tambah Jabatan Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="position_name" class="form-label">Nama Jabatan</label>
                                <input type="text" class="form-control" id="position_name" wire:model="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price_mandiri" class="form-label">Harga Paket Mandiri</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="price_mandiri"
                                        wire:model="price_mandiri">
                                </div>
                                @error('price_mandiri')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price_bimbingan" class="form-label">Harga Paket Bimbingan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="price_bimbingan"
                                        wire:model="price_bimbingan">
                                </div>
                                @error('price_bimbingan')
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
    @endif
</div>

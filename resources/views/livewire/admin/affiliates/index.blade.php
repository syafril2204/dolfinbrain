<div>
    {{-- Header Halaman --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Manajemen Affiliate</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Affiliate</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-0">Daftar Affiliator</h5>
            <button wire:click="create" class="btn btn-primary">Tambah Affiliator</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table border">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Kode Affiliate</th>
                            <th>Pengguna Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($affiliates as $affiliate)
                            <tr wire:key="{{ $affiliate->id }}">
                                <td>{{ $affiliate->name }}</td>
                                <td><span
                                        class="badge bg-light-secondary text-secondary fs-3">{{ $affiliate->code }}</span>
                                </td>
                                <td>{{ $affiliate->transactions_count }} Pengguna</td>
                                <td>
                                    <button wire:click="showDetail({{ $affiliate->id }})"
                                        class="btn btn-sm btn-outline-secondary">Lihat Pengguna</button>
                                    <button wire:click="edit({{ $affiliate->id }})"
                                        class="btn btn-sm btn-warning">Edit</button>
                                    <button wire:click="delete({{ $affiliate->id }})"
                                        wire:confirm="Yakin ingin menghapus affiliator ini?"
                                        class="btn btn-sm btn-danger">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada affiliator yang ditambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $affiliates->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Form Tambah/Edit Affiliator --}}
    @if ($isModalOpen)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingAffiliate ? 'Edit Affiliator' : 'Tambah Affiliator Baru' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Affiliator</label>
                                <input type="text" class="form-control" wire:model="name"
                                    placeholder="Contoh: John Doe">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kode Affiliate</label>
                                <input type="text" class="form-control" wire:model="code"
                                    placeholder="Contoh: DOLFIN01">
                                @error('code')
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

    {{-- Modal Detail Pengguna Affiliate --}}
    @if ($isDetailModalOpen && $viewingAffiliate)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pengguna Terdaftar via: {{ $viewingAffiliate->name }}
                            ({{ $viewingAffiliate->code }})</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table border">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Pengguna</th>
                                        <th>Email</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($viewingAffiliate->transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                            <td>{{ $transaction->user->email ?? 'N/A' }}</td>
                                            <td>{{ $transaction->created_at->translatedFormat('j F Y') }}</td>
                                            <td>
                                                @if ($transaction->status == 'paid')
                                                    <span class="badge bg-success">Berhasil</span>
                                                @else
                                                    <span
                                                        class="badge bg-warning">{{ Str::ucfirst($transaction->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Belum ada pengguna yang menggunakan
                                                kode ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

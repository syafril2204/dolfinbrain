<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="card-title fw-semibold mb-0">Daftar Pengguna</h5>
        <div class="position-relative" style="width: 250px;">
            <input type="text" class="form-control" placeholder="Cari nama atau email..."
                wire:model.live.debounce.300ms="searchTerm">
            <i class="ti ti-search position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);"></i>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table border">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Jabatan Aktif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr wire:key="{{ $user->id }}">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->status === 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Diblokir</span>
                                    @endif
                                </td>
                                <td>{{ $user->position->name ?? '-' }}</td>
                                <td>
                                    <button wire:click="showDetail({{ $user->id }})"
                                        class="btn btn-sm btn-outline-secondary">Detail</button>
                                    @if ($user->status === 'active')
                                        <button wire:click="toggleStatus({{ $user->id }})"
                                            class="btn btn-sm btn-outline-danger">Blokir</button>
                                    @else
                                        <button wire:click="toggleStatus({{ $user->id }})"
                                            class="btn btn-sm btn-outline-success">Buka Blokir</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada pengguna ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $users->links() }}</div>
        </div>
    </div>

    @if ($isDetailModalOpen && $selectedUser)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Pengguna: {{ $selectedUser->name }}</h5>
                        <button type="button" class="btn-close" wire:click="closeDetailModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ $selectedUser->email }}</p>
                                <p><strong>Domisili:</strong> {{ $selectedUser->domicile ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Jenis Kelamin:</strong> {{ $selectedUser->gender ?? '-' }}</p>
                                <p><strong>Tanggal Lahir:</strong>
                                    {{ $selectedUser->date_of_birth ? \Carbon\Carbon::parse($selectedUser->date_of_birth)->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <h6>Kursus (Jabatan) yang Dibeli</h6>
                        @if ($selectedUser->purchasedPositions->isNotEmpty())
                            <ul class="list-group">
                                @foreach ($selectedUser->purchasedPositions as $position)
                                    <li class="list-group-item">{{ $position->formation->name }} -
                                        {{ $position->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Pengguna ini belum membeli kursus apapun.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

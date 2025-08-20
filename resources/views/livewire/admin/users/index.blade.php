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
        <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold mb-0 lh-sm">Daftar Pengguna</h5>

            <button wire:click="exportExcel" class="btn btn-success">
                <i class="ti ti-file-excel me-1"></i>
                Export Excel
            </button>
        </div>

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
            <div class="mt-3">{{ $users->links('partials.custom-pagination') }}</div>
        </div>
    </div>

    @if ($isDetailModalOpen && $selectedUser)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg border-0 rounded-3">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-person-circle me-2"></i> Detail Pengguna: {{ $selectedUser->name }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeDetailModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Avatar -->
                            <div class="col-md-4 text-center">
                                <img src="{{ $selectedUser->avatar ? asset('storage/' . $selectedUser->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($selectedUser->name) }}"
                                    class="img-thumbnail rounded-circle mb-3" alt="Avatar" width="150">
                                <p class="fw-bold mb-0">{{ $selectedUser->name }}</p>
                                <small class="text-muted">ID: {{ $selectedUser->id }}</small>
                            </div>

                            <!-- Detail Data -->
                            <div class="col-md-8">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $selectedUser->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. HP</th>
                                        <td>{{ $selectedUser->phone_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Domisili</th>
                                        <td>{{ $selectedUser->domicile ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>{{ $selectedUser->gender ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>
                                            {{ $selectedUser->date_of_birth ? \Carbon\Carbon::parse($selectedUser->date_of_birth)->format('d M Y') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan Saat Ini</th>
                                        <td>{{ $selectedUser->position->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bidang</th>
                                        <td>{{ $selectedUser->formation->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Instansi</th>
                                        <td>{{ $selectedUser->instansi }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan Yang Dilamar</th>
                                        <td>{{ $selectedUser->jabatan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email Terverifikasi</th>
                                        <td>
                                            {{ $selectedUser->email_verified_at ? \Carbon\Carbon::parse($selectedUser->email_verified_at)->format('d M Y H:i') : 'Belum' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat</th>
                                        <td>{{ $selectedUser->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Diperbarui</th>
                                        <td>{{ $selectedUser->updated_at->format('d M Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <!-- Kursus yang Dibeli -->
                        <h6 class="fw-bold">Kursus (Jabatan) yang Dibeli</h6>
                        @if ($selectedUser->purchasedPositions->isNotEmpty())
                            <ul class="list-group">
                                @foreach ($selectedUser->purchasedPositions as $position)
                                    <li class="list-group-item">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        {{ $position->formation->name }} - {{ $position->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Pengguna ini belum membeli kursus apapun.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailModal">
                            <i class="bi bi-x-circle me-1"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

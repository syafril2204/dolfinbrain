<div>
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Riwayat Transaksi</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Transaksi</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Panel Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Filter Transaksi</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari Nama / Referensi</label>
                    <input type="search" class="form-control" placeholder="Cari..."
                        wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" wire:model.live="filterStatus">
                        <option value="">Semua</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="failed">Failed</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" wire:model.live="startDate">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" wire:model.live="endDate">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-outline-secondary w-100" wire:click="resetFilters">Reset</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table border">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th>Referensi</th>
                            <th>Pengguna</th>
                            <th>Paket Dibeli</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr wire:key="{{ $transaction->id }}">
                                <td>
                                    <span class="fw-semibold">{{ $transaction->reference }}</span><br>
                                    <small class="text-muted">{{ $transaction->payment_method }}</small>
                                </td>
                                <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                <td style="white-space: normal;">
                                    {{ $transaction->position->formation->name ?? 'N/A' }} -
                                    {{ $transaction->position->name ?? 'N/A' }}
                                    <br>
                                    <small class="text-muted">({{ Str::ucfirst($transaction->package_type) }})</small>
                                </td>
                                <td class="fw-semibold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $statusClass =
                                            [
                                                'paid' => 'bg-light-success text-success',
                                                'pending' => 'bg-light-warning text-warning',
                                                'failed' => 'bg-light-danger text-danger',
                                                'expired' => 'bg-light-secondary text-secondary',
                                            ][$transaction->status] ?? 'bg-light-dark text-dark';
                                    @endphp
                                    <span
                                        class="badge {{ $statusClass }}">{{ Str::ucfirst($transaction->status) }}</span>
                                </td>
                                <td>{{ $transaction->created_at->translatedFormat('d M Y, H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada transaksi yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>

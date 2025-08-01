<div>
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">History Pembelian</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">History Pembelian</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table border">
                    <thead class="table-light">
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Paket</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr wire:key="{{ $transaction->id }}">
                                <td>
                                    <span class="fw-semibold">#{{ $transaction->reference }}</span>
                                </td>
                                <td>
                                    Paket {{ ucfirst($transaction->package_type) }}<br>
                                    <small class="text-muted">{{ $transaction->position->formation->name }} -
                                        {{ $transaction->position->name }}</small>
                                </td>
                                <td>{{ $transaction->created_at->translatedFormat('j F Y') }}</td>
                                <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if ($transaction->status == 'pending')
                                        <span class="badge bg-light-warning text-warning">Menunggu Pembayaran</span>
                                    @elseif($transaction->status == 'paid')
                                        <span class="badge bg-light-success text-success">Berhasil</span>
                                    @elseif($transaction->status == 'failed')
                                        <span class="badge bg-light-danger text-danger">Gagal</span>
                                    @elseif($transaction->status == 'expired')
                                        <span class="badge bg-light-secondary text-secondary">Kedaluwarsa</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($transaction->status == 'pending')
                                        <a href="{{ route('students.packages.instruction', $transaction->reference) }}"
                                            class="btn btn-sm btn-primary">
                                            Lanjutkan Pembayaran
                                        </a>
                                    @else
                                        <p>-</p>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    Anda belum memiliki riwayat transaksi.
                                </td>
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

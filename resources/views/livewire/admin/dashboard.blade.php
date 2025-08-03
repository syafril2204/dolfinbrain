<div>
    {{-- Baris Kartu Statistik --}}
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-7 fw-bolder mb-0">{{ $totalStudents }}</h2>
                            <p class="mb-0 text-dark">Total Siswa</p>
                        </div>
                        <div class="ms-auto">
                            <span
                                class="text-primary bg-light-primary round-40 d-flex align-items-center justify-content-center h-100">
                                <i class="ti ti-users fs-7"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-7 fw-bolder mb-0">Rp {{ number_format($totalPaidTransactions, 0, ',', '.') }}
                            </h2>
                            <p class="mb-0 text-dark">Total Pendapatan</p>
                        </div>
                        <div class="ms-auto">
                            <span
                                class="text-success bg-light-success round-40 d-flex align-items-center justify-content-center h-100">
                                <i class="ti ti-wallet fs-7"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-7 fw-bolder mb-0">{{ $totalFormations }}</h2>
                            <p class="mb-0 text-dark">Total Formasi</p>
                        </div>
                        <div class="ms-auto">
                            <span
                                class="text-warning bg-light-warning round-40 d-flex align-items-center justify-content-center h-100">
                                <i class="ti ti-sitemap fs-7"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Transaksi Terbaru --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Transaksi Terbaru</h5>
            <div class="table-responsive mt-3">
                <table class="table border">
                    <thead class="table-light">
                        <tr>
                            <th>Pengguna</th>
                            <th>Paket</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                <td>Paket {{ ucfirst($transaction->package_type) }}</td>
                                <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if ($transaction->status == 'paid')
                                        <span class="badge bg-success">Berhasil</span>
                                    @else
                                        <span class="badge bg-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->created_at->translatedFormat('j M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

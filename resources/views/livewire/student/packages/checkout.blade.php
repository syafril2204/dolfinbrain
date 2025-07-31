<div>
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Checkout</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('students.packages.index') }}">Beli
                            Paket</a></li>
                    <li class="breadcrumb-item" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="row">
        {{-- Kolom Kiri: Info & Metode Pembayaran --}}
        <div class="col-lg-8">
            {{-- Book Information --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Book Information</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-muted">Paket</td>
                                    <td class="fw-semibold">{{ $packageName }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jabatan</td>
                                    <td class="fw-semibold">{{ $position->formation->name }} - {{ $position->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Durasi Akses</td>
                                    <td class="fw-semibold">6 Bulan</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">ID Paket</td>
                                    <td class="fw-semibold">PKT-{{ strtoupper($packageType) }}-{{ $position->id }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <label for="referral" class="form-label">Kode Referral</label>
                    <input type="text" id="referral" class="form-control" placeholder="Masukkan kode">
                </div>
            </div>

            {{-- Payment Methods --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Payment methods</h5>
                    <div class="list-group">
                        <a href="#"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Add debit/credit card <i class="ti ti-chevron-right"></i>
                        </a>
                        <label class="list-group-item list-group-item-action d-flex align-items-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png"
                                alt="Mastercard" height="20">
                            <span class="ms-3">Mastercard</span>
                            <input type="radio" name="payment_method" class="form-check-input ms-auto">
                        </label>
                        <label class="list-group-item list-group-item-action d-flex align-items-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/Mandiri_logo.svg/1200px-Mandiri_logo.svg.png"
                                alt="Mandiri" height="20">
                            <span class="ms-3">Mandiri</span>
                            <input type="radio" name="payment_method" class="form-check-input ms-auto">
                        </label>
                        <label class="list-group-item list-group-item-action d-flex align-items-center">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/9d/Logo_Alfamart.svg"
                                alt="Alfamart" height="20">
                            <span class="ms-3">Alfamart</span>
                            <input type="radio" name="payment_method" class="form-check-input ms-auto">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Rincian Transaksi --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Transaction Info</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">ID Transaksi</span>
                        <span class="fw-semibold">#{{ $transactionId }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tanggal</span>
                        <span class="fw-semibold">{{ now()->translatedFormat('j F Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Status</span>
                        <span class="badge bg-light-warning text-warning">Menunggu Pembayaran</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Invoice Breakdown</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">Rp {{ number_format($price, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <a href="#" class="text-primary">Diskon</a>
                        <span class="fw-semibold">- Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bolder">
                        <span>Total Akhir</span>
                        <span>Rp {{ number_format($price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="agree" wire:model="agree">
                        <label class="form-check-label" for="agree">
                            Dengan mencentang ini, saya menyetujui <a href="#">Syarat & Ketentuan</a> dan <a
                                href="#">Kebijakan Privasi</a> DolfinBrain.
                        </label>
                        @error('agree')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-primary w-100 py-2" wire:click="processPayment">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

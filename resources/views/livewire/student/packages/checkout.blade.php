<div>
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

    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
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
                                    <td class="text-muted border-0">Paket</td>
                                    <td class="fw-semibold border-0">{{ $packageName }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted border-0">Jabatan</td>
                                    <td class="fw-semibold border-0">{{ $position->formation->name }} -
                                        {{ $position->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted border-0">Durasi Akses</td>
                                    <td class="fw-semibold border-0">6 Bulan</td>
                                </tr>
                                <tr>
                                    <td class="text-muted border-0">ID Paket</td>
                                    <td class="fw-semibold border-0">
                                        PKT-{{ strtoupper($packageType) }}-{{ $position->id }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <label for="referral" class="form-label">Kode Referral</label>
                    <input type="text" id="referral" class="form-control" placeholder="Masukkan kode">
                </div>
            </div>

            {{-- Payment Methods (Accordion) --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Payment methods</h5>

                    @if (!empty($paymentChannels))
                        <div class="accordion" id="paymentMethodsAccordion">
                            @foreach ($paymentChannels as $groupName => $channels)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ Str::slug($groupName) }}">
                                        <button class="accordion-button collapsed fw-semibold" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ Str::slug($groupName) }}" aria-expanded="false"
                                            aria-controls="collapse-{{ Str::slug($groupName) }}">
                                            {{ $groupName }}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ Str::slug($groupName) }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading-{{ Str::slug($groupName) }}"
                                        data-bs-parent="#paymentMethodsAccordion">
                                        <div class="accordion-body p-0">
                                            <div class="list-group list-group-flush">
                                                @foreach ($channels as $channel)
                                                    <label
                                                        class="list-group-item list-group-item-action d-flex align-items-center"
                                                        style="cursor: pointer;">
                                                        <img src="{{ $channel['icon_url'] }}"
                                                            alt="{{ $channel['name'] }}" height="20" class="me-3">
                                                        {{ $channel['name'] }}
                                                        <input type="radio" name="payment_method"
                                                            class="form-check-input ms-auto"
                                                            value="{{ $channel['code'] }}"
                                                            wire:model="selectedPaymentMethod">
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Gagal memuat metode pembayaran. Periksa koneksi atau coba lagi nanti.</p>
                    @endif

                    @error('selectedPaymentMethod')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
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
                        <span class="fw-semibold">Rp {{ number_format($originalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-primary">Diskon (20%)</span>
                        <span class="fw-semibold text-danger">- Rp
                            {{ number_format($discountAmount, 0, ',', '.') }}</span>
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
                    <button class="btn btn-primary w-100 py-2" wire:click="createTransaction"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="createTransaction">Bayar Sekarang</span>
                        <span wire:loading wire:target="createTransaction">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

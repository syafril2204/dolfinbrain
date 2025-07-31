<div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body text-center p-4 p-md-5">

                    @if ($transaction->status == 'pending')
                        <h4 class="fw-semibold">Menunggu Pembayaran</h4>
                        <p class="text-muted">Selesaikan pembayaran Anda sebelum batas waktu berakhir.</p>

                        <div class="bg-light-warning rounded p-3 my-4 fs-4 fw-bold text-warning" x-data="{
                            timeRemaining: Math.floor(@json($timeRemaining)),
                            get formattedTime() {
                                if (this.timeRemaining <= 0) return 'Waktu Habis';
                                const hours = Math.floor(this.timeRemaining / 3600);
                                const minutes = Math.floor((this.timeRemaining % 3600) / 60);
                                const seconds = this.timeRemaining % 60;
                                return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                            },
                            initTimer() {
                                setInterval(() => {
                                    if (this.timeRemaining > 0) this.timeRemaining--;
                                }, 1000);
                            }
                        }"
                            x-init="initTimer()">
                            Selesaikan dalam <span x-text="formattedTime"></span>
                        </div>
                    @else
                        <h4 class="fw-semibold text-success">Pembayaran Berhasil</h4>
                        <p class="text-muted">Terima kasih, pembayaran Anda telah kami terima.</p>
                    @endif

                    <hr>

                    {{-- Detail Pembayaran --}}
                    <h5 class="fw-semibold mt-4 mb-3">Detail Pembayaran</h5>

                    {{-- Tampilkan QR Code jika ada --}}
                    @if ($transaction->qr_url)
                        <div class="mb-3">
                            {!! QrCode::size(200)->generate($transaction->qr_url) !!}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table text-start">
                            <tbody>
                                <tr>
                                    <td class="text-muted border-0">Metode Pembayaran</td>
                                    <td class="fw-semibold border-0">{{ $transaction->payment_method }}</td>
                                </tr>
                                {{-- Tampilkan Kode Pembayaran/VA jika ada --}}
                                @if ($transaction->payment_code)
                                    <tr>
                                        <td class="text-muted border-0">Kode Pembayaran / No. VA</td>
                                        <td class="fw-semibold border-0">{{ $transaction->payment_code }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-muted border-0">Total Pembayaran</td>
                                    <td class="fw-semibold border-0">Rp
                                        {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ $transaction->checkout_url }}" target="_blank" class="btn btn-primary btn-lg">Bayar
                            Sekarang</a>
                        <a href="{{ route('students.packages.index') }}"
                            class="btn btn-outline-secondary btn-lg mt-2 mt-md-0">Pilih Metode Lain</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

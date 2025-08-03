<div class="col-xl-5 col-xxl-4">
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
            <h2 class="mb-3 fs-7 fw-bolder">Lupa Password?</h2>
            <p class="mb-4">Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset password Anda.</p>

            @if ($status)
                <div class="alert alert-success" role="alert">
                    {{ $status }}
                </div>
            @endif

            <form wire:submit.prevent="sendResetLink">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        wire:model="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Kirim Link Reset</button>
                <a href="{{ route('login') }}" class="btn btn-light w-100 py-8 mb-4 rounded-2" wire:navigate>Kembali ke
                    Login</a>
            </form>
        </div>
    </div>
</div>

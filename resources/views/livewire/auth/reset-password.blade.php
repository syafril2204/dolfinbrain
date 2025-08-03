<div class="col-xl-5 col-xxl-4">
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
            <h2 class="mb-3 fs-7 fw-bolder">Reset Password Anda</h2>
            <p class="mb-4">Masukkan password baru Anda di bawah ini.</p>

            <form wire:submit.prevent="resetPassword">
                {{-- Hidden input for token --}}
                <input type="hidden" wire:model="token">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" wire:model="email" readonly>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="password" wire:model="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="password_confirmation"
                        wire:model="password_confirmation">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Reset Password</button>
            </form>
        </div>
    </div>
</div>

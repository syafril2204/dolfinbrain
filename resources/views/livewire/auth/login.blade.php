<div class="col-xl-5 col-xxl-4">
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
            <h2 class="mb-3 fs-7 fw-bolder">Selamat Datang di Dolfin Brain</h2>
            <div class="row">
                <div class="col-12 mb-2 mb-sm-0">
                    <a class="btn btn-white text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8"
                        href="{{ route('auth.google.redirect') }}" role="button">
                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/google-icon.svg"
                            alt="" class="img-fluid me-2" width="18" height="18">
                        <span class="d-none d-sm-block me-1 flex-shrink-0">Login</span>Google
                    </a>
                </div>
                {{-- <div class="col-6">
                    <a class="btn btn-white text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8"
                        href="javascript:void(0)" role="button">
                        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/facebook-icon.svg"
                            alt="" class="img-fluid me-2" width="18" height="18">
                        <span class="d-none d-sm-block me-1 flex-shrink-0">Login</span>FB
                    </a>
                </div> --}}
            </div>
            <div class="position-relative text-center my-4">
                <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">
                    atau Login</p>
                <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
            </div>

            <form wire:submit="attemptLogin">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        wire:model="email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        wire:model="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input primary" type="checkbox" id="flexCheckChecked"
                            wire:model="remember">
                        <label class="form-check-label text-dark" for="flexCheckChecked">
                            Remember this Device
                        </label>
                    </div>
                    <a class="text-primary fw-medium" href="{{ route('password.request') }}" wire:navigate>Lupa
                        Password</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">
                    <span>
                        Login
                    </span>
                </button>

                <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">Belum Punya Akun?</p>
                    <a class="text-primary fw-medium ms-2" href="{{ route('register') }}" wire:navigate>Daftar
                        Sekarang</a>
                </div>
            </form>
        </div>
    </div>
</div>

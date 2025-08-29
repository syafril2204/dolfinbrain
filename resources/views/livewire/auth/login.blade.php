<div class="row w-100">

    <div class="col-xl-6 col-xxl-8 p-0">
        <div class="d-flex flex-column align-items-center justify-content-center h-100 w-100"
            style="min-height: 100vh; background: linear-gradient(to bottom, #0d6efd, #ffffff);">

            <div id="authCarousel" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('assets/auth/image.png') }}" class="d-block img-fluid mx-auto"
                            width="350" alt="Image 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/auth/image2.png') }}" class="d-block img-fluid mx-auto"
                            width="350" alt="Image 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/auth/image3.png') }}" class="d-block img-fluid mx-auto"
                            width="350" alt="Image 3">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/auth/image4.png') }}" class="d-block img-fluid mx-auto"
                            width="350" alt="Image 4">
                    </div>
                </div>

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#authCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#authCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#authCarousel" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#authCarousel" data-bs-slide-to="3"></button>
                </div>
            </div>

        </div>
    </div>


    <div class="col-xl-6 col-xxl-4">
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
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" wire:model="password">
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
</div>

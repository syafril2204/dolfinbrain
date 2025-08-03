<div class="col-xl-5 col-xxl-4">
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif


            @if ($step == 1)
                <h2 class="mb-3 fs-7 fw-bolder">Buat Akun DolfinBrain</h2>
                <p class="mb-4">Daftar sekarang untuk akses penuh ke materi, soal, dan fitur belajar pintar.</p>

                <div class="row">
                    <div class="col-12 mb-2 mb-sm-0">
                        <a class="btn btn-white text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8"
                            href="{{ route('auth.google.redirect') }}" role="button">
                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/google-icon.svg"
                                alt="" class="img-fluid me-2" width="18" height="18">
                            <span class="d-none d-sm-block me-1 flex-shrink-0">Daftar dengan</span>Google
                        </a>
                    </div>
                </div>
                <div class="position-relative text-center my-4">
                    <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">atau daftar
                        dengan email</p>
                    <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                </div>

                <form wire:submit.prevent="submitStep1">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" wire:model="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" wire:model="email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" wire:model="password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            wire:model="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Daftar</button>
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-medium">Sudah Punya Akun?</p>
                        <a class="text-primary fw-medium ms-2" href="{{ route('login') }}" wire:navigate>Login</a>
                    </div>
                </form>
            @endif

            {{-- =============================================== --}}
            {{-- LANGKAH 2: LENGKAPI PROFIL --}}
            {{-- =============================================== --}}
            @if ($step == 2)
                <h2 class="mb-3 fs-7 fw-bolder">Lengkapi Profil Kamu</h2>
                <p class="mb-4">Isi data dirimu untuk pengalaman belajar yang lebih personal dan maksimal.</p>
                <form wire:submit.prevent="submitStep2">
                    <div class="mb-3">
                        <label for="name_step2" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name_step2" wire:model="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="d-flex gap-3">
                            <div class="form-check card card-body border flex-fill text-center">
                                <input class="form-check-input d-none" type="radio" name="gender" id="gender_male"
                                    value="Laki-laki" wire:model="gender">
                                <label class="form-check-label w-100" for="gender_male" style="cursor: pointer;">
                                    <img src="{{ asset('assets/avatar/male.png') }}" class="rounded-circle mb-2"
                                        alt="Laki-laki"><br>
                                    Laki-laki
                                </label>
                            </div>
                            <div class="form-check card card-body border flex-fill text-center">
                                <input class="form-check-input d-none" type="radio" name="gender" id="gender_female"
                                    value="Perempuan" wire:model="gender">
                                <label class="form-check-label w-100" for="gender_female" style="cursor: pointer;">
                                    <img src="{{ asset('assets/avatar/female.png') }}" class="rounded-circle mb-2"
                                        alt="Perempuan"><br>
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        @error('gender')
                            <span class="text-danger d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="date_of_birth" wire:model="date_of_birth">
                        @error('date_of_birth')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="domicile" class="form-label">Domisili</label>
                        <input type="text" class="form-control" id="domicile" wire:model="domicile"
                            placeholder="Contoh: Jakarta">
                        @error('domicile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Lanjutkan</button>
                </form>
            @endif

            {{-- =============================================== --}}
            {{-- LANGKAH 3: PILIH KATEGORI FORMASI --}}
            {{-- =============================================== --}}
            @if ($step == 3)
                <h2 class="mb-3 fs-7 fw-bolder">Pilih Kategori Formasi</h2>
                <p class="mb-4">Silakan pilih kategori formasi sesuai minat dan kualifikasi anda</p>

                @foreach ($formations as $formation)
                    <div class="card card-body border mb-3" wire:click="selectFormation({{ $formation->id }})"
                        style="cursor: pointer;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-semibold mb-0">{{ $formation->name }}</h6>
                                <small>{{ $formation->short_description }}</small>
                            </div>
                            <span>Pilih Jabatan <i class="ti ti-chevron-right"></i></span>
                        </div>
                    </div>
                @endforeach
                <a href="#" wire:click.prevent="back" class="d-block text-center mt-3">Kembali</a>
            @endif

            {{-- =============================================== --}}
            {{-- LANGKAH 4: PILIH JABATAN (POSISI) --}}
            {{-- =============================================== --}}
            @if ($step == 4)
                <h2 class="mb-3 fs-7 fw-bolder">{{ $selectedFormation->name ?? 'Pilih Jabatan' }}</h2>
                <p class="mb-4">Pilih Jabatan yang ingin dipelajari. **Pastikan Anda sudah memverifikasi email Anda
                    sebelum melanjutkan.**</p>

                <form wire:submit.prevent="submitStep4">
                    @if ($selectedFormation)
                        @foreach ($selectedFormation->positions as $position)
                            <div class="form-check card card-body border mb-2 position-relative">
                                <input class="form-check-input" type="radio" name="position"
                                    id="pos-{{ $position->id }}" value="{{ $position->id }}"
                                    wire:model="position_id"
                                    style="position: absolute; top: 1rem; right: 1rem; cursor: pointer;">
                                <label class="form-check-label w-100" for="pos-{{ $position->id }}"
                                    style="cursor: pointer;">
                                    {{ $position->name }}
                                </label>
                            </div>
                        @endforeach
                    @endif
                    @error('position_id')
                        <span class="text-danger d-block mb-3">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Selesaikan
                        Pendaftaran</button>
                    <a href="#" wire:click.prevent="back" class="d-block text-center">Kembali</a>
                </form>

                <div class="text-center mt-4 border-top pt-3">
                    <p class="fs-4 mb-2 fw-medium">Tidak menerima email verifikasi?</p>
                    <button type="button" class="btn btn-link" wire:click="resendVerificationEmail">
                        Kirim Ulang Email Verifikasi
                    </button>
                </div>
            @endif

        </div>
    </div>
</div>

@push('styles')
    <style>
        .form-check:has(input[type="radio"]:checked) {
            border-color: var(--bs-primary) !important;
            background-color: var(--bs-primary-bg-subtle) !important;
            box-shadow: 0 0 0 2px rgba(var(--bs-primary-rgb), 0.25);
        }
    </style>
@endpush

<div class="col-xl-5 col-xxl-4">
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">

            {{-- LANGKAH 1: BUAT AKUN --}}
            @if ($step == 1)
                {{-- ... Kode Step 1 tidak berubah ... --}}
                <h2 class="mb-3 fs-7 fw-bolder">Buat Akun DolfinBrain</h2>
                <p class="mb-4">Daftar sekarang untuk akses penuh ke materi, soal, dan fitur belajar pintar.</p>

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

            {{-- LANGKAH 2: LENGKAPI PROFIL --}}
            @if ($step == 2)
                <h2 class="mb-3 fs-7 fw-bolder">Lengkapi Profil Kamu</h2>
                <p class="mb-4">Isi data dirimu untuk pengalaman belajar yang lebih personal dan maksimal</p>
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

            {{-- LANGKAH 3: PILIH KATEGORI FORMASI --}}
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

            {{-- LANGKAH 4: PILIH JABATAN (POSISI) --}}
            @if ($step == 4)
                <h2 class="mb-3 fs-7 fw-bolder">{{ $selectedFormation->name }}</h2>
                <p class="mb-4">Pilih Jabatan yang ingin dipelajari</p>

                <form wire:submit.prevent="submitStep4">
                    @foreach ($selectedFormation->positions as $position)
                        <div class="form-check card card-body border mb-2 position-relative">
                            <input class="form-check-input" type="radio" name="position"
                                id="pos-{{ $position->id }}" value="{{ $position->id }}" wire:model="position_id"
                                style="position: absolute; top: 1rem; right: 1rem; cursor: pointer;">
                            <label class="form-check-label w-100" for="pos-{{ $position->id }}"
                                style="cursor: pointer;">
                                {{ $position->name }}
                            </label>
                        </div>
                    @endforeach
                    @error('position_id')
                        <span class="text-danger d-block mb-3">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Pilih Jabatan</button>
                    <a href="#" wire:click.prevent="back" class="d-block text-center">Kembali</a>
                </form>
            @endif

        </div>
    </div>
</div>

{{-- 👇 [BAGIAN BARU] TAMBAHKAN BLOK INI --}}
@push('styles')
    <style>
        /* CSS ini mencari elemen .form-check (kartu)
                  yang di dalamnya terdapat input radio yang sedang dipilih (:checked)
                */
        .form-check:has(input[type="radio"]:checked) {
            border-color: var(--bs-primary) !important;
            background-color: var(--bs-primary-bg-subtle) !important;
            box-shadow: 0 0 0 2px rgba(var(--bs-primary-rgb), 0.25);
        }
    </style>
@endpush

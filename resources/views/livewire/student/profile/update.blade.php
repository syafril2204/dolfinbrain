<div>
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Ubah Profile</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted"
                            href="{{ route('students.profile.index') }}">Profile</a></li>
                    <li class="breadcrumb-item" aria-current="page">Ubah Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            {{-- Navigasi Tab --}}
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'profile' ? 'active' : '' }}" href="#"
                        wire:click.prevent="switchTab('profile')">Ubah Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'password' ? 'active' : '' }}" href="#"
                        wire:click.prevent="switchTab('password')">Ubah Password</a>
                </li>
            </ul>

            {{-- Konten Tab --}}
            <div>
                {{-- Form Ubah Profil --}}
                <div class="{{ $activeTab === 'profile' ? 'd-block' : 'd-none' }}">
                    <form wire:submit.prevent="updateProfile">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Avatar</label>
                                <div class="d-flex align-items-center">
                                    <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('dist/images/profile/user-1.jpg') }}"
                                        class="rounded-circle" width="80" height="80" alt="Preview">

                                    <input type="file" class="form-control ms-3" wire:model="avatar">
                                </div>
                                <div wire:loading wire:target="avatar" class="text-primary mt-1">Uploading...</div>
                                @error('avatar')
                                    <span class="text-danger mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" wire:model="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check card card-body border flex-fill text-center">
                                        <input class="form-check-input d-none" type="radio" name="gender"
                                            id="gender_male" value="Laki-laki" wire:model="gender">
                                        <label class="form-check-label w-100" for="gender_male"
                                            style="cursor: pointer;">
                                            <img src="{{ asset('assets/avatar/male.png') }}" class="rounded-circle mb-2"
                                                alt="Laki-laki"><br>
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check card card-body border flex-fill text-center">
                                        <input class="form-check-input d-none" type="radio" name="gender"
                                            id="gender_female" value="Perempuan" wire:model="gender">
                                        <label class="form-check-label w-100" for="gender_female"
                                            style="cursor: pointer;">
                                            <img src="{{ asset('assets/avatar/female.png') }}"
                                                class="rounded-circle mb-2" alt="Perempuan"><br>
                                            Perempuan
                                        </label>
                                    </div>
                                </div>
                                @error('gender')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" wire:model="date_of_birth">
                                @error('date_of_birth')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Domisili</label>
                                <input type="text" class="form-control" wire:model="domicile">
                                @error('domicile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-outline-secondary me-2">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>

                {{-- Form Ubah Password --}}
                <div class="{{ $activeTab === 'password' ? 'd-block' : 'd-none' }}">
                    <form wire:submit.prevent="updatePassword">
                        <div class="mb-3">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control" wire:model="current_password">
                            @error('current_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" wire:model="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" wire:model="password_confirmation">
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-outline-secondary me-2">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* CSS untuk highlight pilihan jenis kelamin */
        .form-check:has(input[type="radio"]:checked) {
            border-color: var(--bs-primary) !important;
            background-color: var(--bs-primary-bg-subtle) !important;
        }
    </style>
@endpush

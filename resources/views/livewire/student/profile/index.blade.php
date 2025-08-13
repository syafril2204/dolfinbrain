<div> {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Profile</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="row">
        {{-- LEFT COLUMN - Actions --}}
        <div class="col-lg-7 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    {{-- Menu Utama --}}
                    <div class="list-group list-group-flush">
                        <a href="{{ route('students.transactions.index') }}" style="padding: 1.25rem 1rem;"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-bottom">
                            History Pembelian
                            <i class="ti ti-chevron-right"></i>
                        </a>
                        <a href="{{ route('students.profile.update', ['status' => 'profile']) }}"
                            style="padding: 1.25rem 1rem;"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-bottom">
                            Ubah Profile
                            <i class="ti ti-chevron-right"></i>
                        </a>
                        <a href="{{ route('students.profile.update', ['status' => 'password']) }}"
                            style="padding: 1.25rem 1rem;"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-bottom">
                            Ubah Password
                            <i class="ti ti-chevron-right"></i>
                        </a>
                        <a href="{{ route('students.contact.index') }}" style="padding: 1.25rem 1rem;"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Hubungi Admin <i class="ti ti-chevron-right"></i>
                        </a>
                    </div>

                    {{-- Tombol Keluar --}}
                    <div class="mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-outline-danger w-100 d-flex justify-content-between align-items-center"
                                style="padding: 1.25rem 1rem;">
                                Keluar
                                <i class="ti ti-chevron-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN - Info Profil --}}
        <div class="col-lg-5 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('dist/images/profile/user-1.jpg') }}" alt="avatar"
                            class="img-fluid rounded-circle mb-3" width="120">
                        <h5 class="fw-semibold">{{ $user->name }}</h5>
                        <p class="badge bg-light-primary text-primary fs-2 rounded-pill px-3 py-1 mb-2">Free</p>
                    </div>

                    <hr class="my-4">

                    {{-- Info Detail --}}
                    <div class="px-2">
                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                            <span class="text-dark fw-semibold">Formasi</span>
                            <span class="text-muted">{{ $user->position->formation->name ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                            <span class="text-dark fw-semibold">Jabatan</span>
                            <span class="text-muted">{{ $user->position->name ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                            <span class="text-dark fw-semibold">Email</span>
                            <span class="text-muted">{{ $user->email }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-3">
                            <span class="text-dark fw-semibold">Nomor HP</span>
                            <span class="text-muted">{{ $user->phone_number ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

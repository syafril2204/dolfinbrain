<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="card-title fw-semibold mb-0">Daftar LMS Space</h5>
        <a href="{{ route('admin.lms-spaces.create') }}" class="btn btn-primary">Tambah LMS Space</a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="row">
        @forelse ($spaces as $space)
            <div class="col-md-6 col-lg-4" wire:key="{{ $space->id }}">
                <div class="card rounded-2 overflow-hidden">
                    <div class="position-relative">
                        <img src="{{ $space->image_path ? Storage::url($space->image_path) : 'https://via.placeholder.com/350x200' }}"
                            class="card-img-top rounded-0" alt="LMS Space Image"
                            style="height: 200px; object-fit: cover;">

                        <div class="position-absolute top-0 end-0 m-3">
                            <div class="dropdown">
                                <a class="btn btn-light btn-sm" href="#" role="button"
                                    id="dropdownMenuLink-{{ $space->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink-{{ $space->id }}">
                                    <li><a class="dropdown-item" href="#"><i
                                                class="ti ti-settings me-2"></i>Kelola Konten</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.lms-spaces.edit', $space) }}"><i
                                                class="ti ti-edit me-2"></i>Edit</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#"
                                            wire:click.prevent="delete({{ $space->id }})"
                                            wire:confirm="Anda yakin ingin menghapus LMS Space ini?">
                                            <i class="ti ti-trash me-2"></i>Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {{-- 👆 [AKHIR BAGIAN YANG DIPERBARUI] --}}

                    </div>
                    <div class="card-body p-4">
                        <h6 class="fw-semibold fs-4 mb-2">{{ $space->title }}</h6>
                        <p class="mb-3">{{ Str::limit($space->description, 100) }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Belum ada LMS Space yang dibuat.</p>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $spaces->links() }}
    </div>
</div>

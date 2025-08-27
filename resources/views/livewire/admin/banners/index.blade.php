<div>
    {{-- Header --}}
    <div class="card bg-light-info border-0 shadow-sm position-relative overflow-hidden mb-4 rounded-3">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-2">Manajemen Banner</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Banner</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success shadow-sm border-0 rounded-3">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger shadow-sm border-0 rounded-3">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        {{-- Banner List --}}
        @foreach ($banners as $banner)
            <div class="col-md-6 col-lg-4" wire:key="{{ $banner->id }}">
                <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                    <div class="position-relative">
                        <img src="{{ Storage::url($banner->image_path) }}" class="card-img-top" alt="Banner"
                            style="height: 180px; object-fit: cover; border-bottom: 1px solid #f0f0f0;">
                        {{-- Overlay kecil saat hover --}}
                        <div
                            class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25 opacity-0 hover-opacity-100 transition">
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($editingBannerId === $banner->id)
                            {{-- Form Edit --}}
                            <div>
                                <label class="form-label fw-semibold">Ganti Gambar</label>
                                <input type="file" class="form-control mb-2 rounded-3" wire:model="editingImage">
                                <div wire:loading wire:target="editingImage" class="text-primary small">Uploading...
                                </div>
                                @error('editingImage')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                <div class="d-flex gap-2 mt-3">
                                    <button class="btn btn-sm btn-primary rounded-3"
                                        wire:click="updateBanner({{ $banner->id }})">Simpan</button>
                                    <button class="btn btn-sm btn-light border rounded-3"
                                        wire:click="cancelEdit">Batal</button>
                                </div>
                            </div>
                        @else
                            {{-- Tombol Aksi --}}
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning rounded-3 px-3"
                                    wire:click="editBanner({{ $banner->id }})">
                                    <i class="ti ti-edit me-1"></i> Ganti
                                </button>
                                <button class="btn btn-sm btn-danger rounded-3 px-3"
                                    wire:click="deleteBanner({{ $banner->id }})"
                                    wire:confirm="Yakin ingin menghapus banner ini?">
                                    <i class="ti ti-trash me-1"></i> Hapus
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Add New Banner --}}
        @if (count($banners) < 3)
            <div class="col-md-6 col-lg-4">
                <div
                    class="card border-dashed shadow-sm h-100 rounded-3 d-flex align-items-center justify-content-center p-4">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-semibold mb-3">Tambah Banner Baru</h5>
                        <div class="mb-3">
                            <label class="form-label">Upload Gambar</label>
                            <input type="file" class="form-control rounded-3" wire:model="newImage">
                            <div wire:loading wire:target="newImage" class="text-primary small mt-1">Uploading...</div>
                            @if ($newImage)
                                <img src="{{ $newImage->temporaryUrl() }}" class="img-fluid rounded mt-3 shadow-sm"
                                    style="max-height: 150px; object-fit: cover;">
                            @endif
                            @error('newImage')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-primary rounded-3 px-4" wire:click="addBanner">
                            <i class="ti ti-plus me-1"></i> Tambahkan
                        </button>
                        <p class="text-muted small mt-2">Maksimal 3 banner</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

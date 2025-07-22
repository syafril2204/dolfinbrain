<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">{{ $isEditMode ? 'Edit Paket Kuis' : 'Tambah Paket Kuis' }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted"
                                    href="{{ route('admin.quiz-packages.index') }}">Paket Kuis</a></li>
                            <li class="breadcrumb-item" aria-current="page">{{ $isEditMode ? 'Edit' : 'Tambah' }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $isEditMode ? 'Edit Paket Kuis' : 'Tambah Paket Kuis' }}</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="store">
                {{-- Form Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Paket</label>
                    <input type="text" id="title" class="form-control" wire:model="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- Form Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" class="form-control" wire:model="description"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- Form Duration --}}
                <div class="mb-3">
                    <label for="duration" class="form-label">Durasi (menit)</label>
                    <input type="number" id="duration" class="form-control" wire:model="duration_in_minutes">
                    @error('duration_in_minutes')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- Form Status --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" wire:model="is_active">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                {{-- Select2 (TIDAK ADA PERUBAHAN DI SINI) --}}
                <div class="mb-3" wire:ignore>
                    <label class="form-label">Tugaskan ke Posisi</label>
                    <select class="form-control" id="select-positions" multiple>
                        @foreach ($allPositions as $position)
                            <option value="{{ $position->id }}">{{ $position->formation->name }} - {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('assignedPositions')
                    <span class="text-danger d-block">{{ $message }}</span>
                @enderror

                <button type="submit" class="btn btn-primary">Simpan</button>
                {{-- Hapus wire:navigate agar tombol Batal juga me-refresh halaman --}}
                <a href="{{ route('admin.quiz-packages.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Gunakan $(document).ready() karena halaman ini selalu dimuat ulang
        $(document).ready(function() {
            let select = $('#select-positions');

            select.select2({
                placeholder: "Pilih posisi",
                width: '100%'
            });

            // Set nilai awal dari properti Livewire
            select.val(@json($assignedPositions)).trigger('change');

            // Kirim data ke Livewire setiap kali ada perubahan
            select.on('change', function(e) {
                @this.set('assignedPositions', $(this).val());
            });
        });
    </script>
@endpush

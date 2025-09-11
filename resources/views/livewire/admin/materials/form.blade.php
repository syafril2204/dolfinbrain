<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">{{ $isEditMode ? 'Edit Materi' : 'Tambah Materi Baru' }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted"
                                    href="{{ route('admin.materials.index') }}">Materi</a></li>
                            <li class="breadcrumb-item" aria-current="page">{{ $isEditMode ? 'Edit' : 'Tambah' }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Materi</label>
                    <input type="text" class="form-control" id="title" wire:model="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi (Opsional)</label>
                    <textarea class="form-control" id="description" rows="3" wire:model="description"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Upload File</label>
                    <input type="file" class="form-control" id="file" wire:model="file">
                    <div wire:loading wire:target="file" class="text-primary mt-2">Uploading...</div>
                    @if ($isEditMode && !$file)
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file.</small>
                    @endif
                    @error('file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3" wire:ignore>
                    <label class="form-label">Tugaskan ke Jabatan</label>
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

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.materials.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let select = $('#select-positions');

            select.select2({
                placeholder: "Pilih satu atau lebih jabatan",
                width: '100%'
            });

            select.val(@json($assignedPositions)).trigger('change');

            select.on('change', function(e) {
                @this.set('assignedPositions', $(this).val());
            });
        });
    </script>
@endpush

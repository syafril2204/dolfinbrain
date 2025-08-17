<div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $isEditMode ? 'Edit LMS Space' : 'Tambah LMS Space Baru' }}</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3">
                    <label class="form-label">Judul LMS Space</label>
                    <input type="text" class="form-control" wire:model="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" wire:model="description" rows="4"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar Sampul</label>
                    <input type="file" class="form-control" wire:model="image">
                    @if ($existing_image_path)
                        <img src="{{ Storage::url($existing_image_path) }}" class="img-thumbnail mt-2" width="200">
                    @endif
                    <div wire:loading wire:target="image" class="text-primary mt-1">Uploading...</div>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" wire:model="is_active">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
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

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.lms-spaces.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let select = $('#select-positions');
            select.select2({
                placeholder: "Pilih Jabatan",
                width: '100%'
            });
            select.val(@json($assignedPositions)).trigger('change');
            select.on('change', function(e) {
                @this.set('assignedPositions', $(this).val());
            });
        });
    </script>
@endpush

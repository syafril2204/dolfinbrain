<div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $isEditMode ? 'Edit Video' : 'Tambah Video Baru' }}</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3"><label class="form-label">Judul Video</label><input type="text" class="form-control"
                        wire:model="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">URL YouTube</label>
                    <input type="url" class="form-control" wire:model="youtube_url"
                        placeholder="Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                    @error('youtube_url')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Durasi</label><input type="text"
                            class="form-control" wire:model="duration" placeholder="Contoh: 5 menit">
                        @error('duration')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3"><label class="form-label">Urutan</label><input type="number"
                            class="form-control" wire:model="order">
                        @error('order')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.lms-spaces.content.videos.index', $lms_space) }}"
                    class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

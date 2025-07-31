<div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $isEditMode ? 'Edit Jadwal' : 'Tambah Jadwal Baru' }}</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3"><label class="form-label">Topik Coaching</label><input type="text"
                        class="form-control" wire:model="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3"><label class="form-label">Nama Trainer</label><input type="text"
                        class="form-control" wire:model="trainer_name">
                    @error('trainer_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3"><label class="form-label">Link Meeting (Zoom/GMeet)</label><input type="url"
                        class="form-control" wire:model="meeting_url">
                    @error('meeting_url')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Waktu Mulai</label><input type="datetime-local"
                            class="form-control" wire:model="start_at">
                        @error('start_at')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3"><label class="form-label">Waktu Selesai</label><input
                            type="datetime-local" class="form-control" wire:model="end_at">
                        @error('end_at')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.lms-spaces.content.coaching.index', $lms_space) }}"
                    class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

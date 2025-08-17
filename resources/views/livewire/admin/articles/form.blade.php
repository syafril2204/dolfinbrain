<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">{{ $isEditMode ? 'Edit Artikel' : 'Tambah Artikel Baru' }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted"
                            href="{{ route('admin.articles.index') }}">Artikel</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $isEditMode ? 'Edit' : 'Tambah' }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Artikel</label>
                    <input type="text" id="title" class="form-control" wire:model="title">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Bagian Konten yang Diubah --}}
                <div class="mb-3" wire:ignore>
                    <label for="content" class="form-label">Konten</label>
                    <textarea id="content" class="form-control" wire:model="content" rows="10"></textarea>
                </div>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Utama</label>
                    <input type="file" id="image" class="form-control" wire:model="image">
                    <div wire:loading wire:target="image" class="text-primary mt-1">Uploading...</div>
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail mt-2" style="max-height: 200px;">
                    @elseif ($existingImageUrl)
                        <img src="{{ Storage::url($existingImageUrl) }}" class="img-thumbnail mt-2"
                            style="max-height: 200px;">
                    @endif
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_published" wire:model="is_published">
                        <label class="form-check-label" for="is_published">Publikasikan Artikel</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary" wire:navigate>Batal</a>
            </form>
        </div>
    </div>
</div>

{{-- Script Baru untuk Summernote --}}
@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            $('#content').summernote({
                placeholder: 'Tulis isi artikel di sini...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        // Update property Livewire saat konten berubah
                        @this.set('content', contents);
                    }
                }
            });

            // Set konten awal jika dalam mode edit
            let initialContent = @this.get('content');
            $('#content').summernote('code', initialContent);
        });
    </script>
@endpush

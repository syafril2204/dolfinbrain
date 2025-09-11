<div>
    {{-- Header Halaman --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Manajemen Artikel</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Artikel</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('dist/images/breadcrumb/ChatBc.png') }}" alt=""
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kontrol & Aksi --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex" style="width: 40%;">
            <input type="search" class="form-control" wire:model.live.debounce.300ms="search"
                placeholder="Cari judul artikel...">
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary" wire:navigate>Tambah Artikel</a>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    {{-- Tampilan Kartu Artikel --}}
    <div class="row">
        @forelse ($articles as $article)
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch" wire:key="{{ $article->id }}">
                <div class="card w-100">
                    <img src="{{ $article->image ? Storage::url($article->image) : 'https://via.placeholder.com/350x200?text=No+Image' }}"
                        class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <div>
                            @if ($article->type == 'tips')
                                <span class="badge bg-light-info text-info mb-2">Tips & Trik</span>
                            @else
                                <span class="badge bg-light-secondary text-secondary mb-2">Artikel</span>
                            @endif

                            @if ($article->is_published)
                                <span class="badge bg-success mb-2">Published</span>
                            @else
                                <span class="badge bg-secondary mb-2">Draft</span>
                            @endif
                        </div>
                        <h5 class="card-title">{{ Str::limit($article->title, 50) }}</h5>
                        <p class="card-text text-muted small mt-auto">
                            Oleh: {{ $article->user->name }} <br>
                            Dibuat: {{ $article->created_at->translatedFormat('d M Y') }}
                        </p>
                    </div>
                    <div class="card-footer bg-white border-top d-flex justify-content-between">
                        <button wire:click="showDetail({{ $article->id }})"
                            class="btn btn-sm btn-outline-primary">Lihat Detail</button>
                        <div>
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-warning"
                                wire:navigate>Edit</a>
                            <button wire:click="delete({{ $article->id }})"
                                wire:confirm="Yakin ingin menghapus artikel ini?"
                                class="btn btn-sm btn-danger">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Tidak ada artikel yang ditemukan.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $articles->links('partials.custom-pagination') }}
    </div>

    {{-- Modal untuk Detail Artikel --}}
    @if ($isDetailModalOpen && $selectedArticle)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $selectedArticle->title }}</h5>
                        <button type="button" class="btn-close" wire:click="closeDetailModal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ $selectedArticle->image ? Storage::url($selectedArticle->image) : 'https://via.placeholder.com/700x300?text=No+Image' }}"
                            class="img-fluid rounded mb-3" alt="{{ $selectedArticle->title }}">

                        <div class="d-flex justify-content-between text-muted mb-3">
                            <span>Oleh: <strong>{{ $selectedArticle->user->name }}</strong></span>
                            <span>Dipublikasikan:
                                <strong>{{ $selectedArticle->published_at ? $selectedArticle->published_at->translatedFormat('d F Y') : 'Draft' }}</strong></span>
                        </div>

                        <hr>

                        <div class="article-content">
                            {!! $selectedArticle->content !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div>
    {{-- Header & Breadcrumb --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Manajemen Soal: {{ $quiz_package->title }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.quiz-packages.index') }}">Paket
                            Kuis</a></li>
                    <li class="breadcrumb-item" aria-current="page">Soal</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    {{-- Fitur Import Excel --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Import Soal dari Excel</h5>
            <p class="card-subtitle mb-3">
                Unggah file Excel untuk menambahkan soal. Pastikan format sudah sesuai.
                <a href="#" wire:click.prevent="downloadTemplate" class="fw-bold">
                    <i class="ti ti-download me-1"></i>Unduh Format di Sini
                </a>
            </p>
            <form wire:submit.prevent="importExcel">
                <div class="row align-items-center">
                    <div class="col-md-9 mb-2 mb-md-0">
                        <input type="file" class="form-control" wire:model="importFile">
                        <div wire:loading wire:target="importFile" class="text-primary mt-1">Uploading...</div>
                        @error('importFile')
                            <span class="text-danger d-block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-upload me-1"></i> Import
                        </button>
                    </div>
                </div>
            </form>
            @if (!empty($importErrors))
                <div class="alert alert-danger mt-3 mb-0">
                    <strong>Terdapat kesalahan saat import:</strong>
                    <ul class="mb-0 ps-3">
                        @foreach ($importErrors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{-- Judul dan Tombol Tambah Soal --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title fw-semibold mb-0">Daftar Soal yang Ada</h5>
        <a href="{{ route('admin.quiz-packages.questions.create', $quiz_package) }}" class="btn btn-primary"
            wire:navigate>
            <i class="ti ti-plus me-1"></i> Tambah Soal Manual
        </a>
    </div>

    {{-- [PERUBAHAN] Tampilan Daftar Soal Menggunakan Kartu --}}
    @forelse ($questions as $question)
        <div class="card border" wire:key="{{ $question->id }}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Soal #{{ $questions->firstItem() + $loop->index }}</h6>
                <div>
                    <a href="{{ route('admin.quiz-packages.questions.edit', ['quiz_package' => $quiz_package, 'question' => $question]) }}"
                        class="btn btn-sm btn-warning" wire:navigate>Edit</a>
                    <button wire:click="delete({{ $question->id }})" wire:confirm="Anda yakin ingin menghapus soal ini?"
                        class="btn btn-sm btn-danger">Hapus</button>
                </div>
            </div>
            <div class="card-body">
                @if ($question->image)
                    <img src="{{ Storage::url($question->image) }}" class="img-fluid rounded mb-3"
                        style="max-height: 300px;" alt="Gambar Soal">
                @endif
                <p class="mb-3">{!! nl2br(e($question->question_text)) !!}</p>
                <hr>
                <small>Pilihan Jawaban:</small>
                <ul class="list-unstyled mt-2">
                    @foreach ($question->answers as $answer)
                        <li class="{{ $answer->is_correct ? 'text-success fw-bold' : '' }}">
                            {{ chr(65 + $loop->index) }}. {{ $answer->answer_text }}
                            @if ($answer->is_correct)
                                <i class="ti ti-check ms-1"></i>
                            @endif
                        </li>
                    @endforeach
                </ul>
                @if ($question->explanation)
                    <div class="alert alert-secondary mt-3 mb-0">
                        <strong>Pembahasan:</strong> {{ $question->explanation }}
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="card">
            <div class="card-body">
                <p class="text-center mb-0">Belum ada soal untuk paket ini.</p>
            </div>
        </div>
    @endforelse

    <div class="mt-4">
        {{ $questions->links() }}
    </div>
</div>

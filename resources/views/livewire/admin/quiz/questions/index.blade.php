<div>
    {{-- Header & Breadcrumb --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Manajemen Soal: {{ $quiz_package->title }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.quiz-packages.index') }}">Paket
                            Kuis</a></li>
                    <li class="breadcrumb-item" aria-current="page">Manajemen Soal</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Daftar Soal --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fw-semibold">Daftar Soal</h5>
            <a href="{{ route('admin.quiz-packages.questions.create', $quiz_package) }}" class="btn btn-primary">Tambah
                Soal</a>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            @forelse ($questions as $question)
                <div class="card border shadow-sm mb-4" wire:key="{{ $question->id }}">
                    <div class="card-body">
                        {{-- Teks Pertanyaan & Tombol Aksi --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-grow-1 pe-3">
                                <p class="mb-2"><strong>Soal #{{ $loop->iteration }}</strong></p>
                                <div class="question-text">
                                    {!! nl2br(e($question->question_text)) !!}
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.quiz-packages.questions.edit', ['quiz_package' => $quiz_package, 'question' => $question]) }}"
                                    class="btn btn-sm btn-outline-warning">Edit</a>
                                <button wire:click="delete({{ $question->id }})"
                                    wire:confirm="Yakin ingin menghapus soal ini?"
                                    class="btn btn-sm btn-outline-danger">Hapus</button>
                            </div>
                        </div>

                        {{-- Pilihan Jawaban --}}
                        <div class="list-group">
                            @foreach ($question->answers as $answer)
                                <div
                                    class="list-group-item d-flex align-items-center
                                    @if ($answer->is_correct) border-success bg-success-subtle @endif">

                                    <span class="fw-bold me-3">{{ chr(65 + $loop->index) }}.</span>
                                    {{-- Diubah ke A, B, C --}}

                                    <div class="flex-grow-1">
                                        {{ $answer->answer_text }}
                                    </div>

                                    @if ($answer->is_correct)
                                        <span class="badge bg-success rounded-pill ms-3">Jawaban Benar</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- 👇 [BAGIAN BARU] Tombol & Konten Pembahasan --}}
                        <div class="mt-3">
                            {{-- Tombol untuk Menampilkan Pembahasan --}}
                            <a class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse"
                                href="#pembahasan-{{ $question->id }}" role="button" aria-expanded="false"
                                aria-controls="pembahasan-{{ $question->id }}">
                                <i class="ti ti-eye"></i> Lihat Pembahasan
                            </a>
                        </div>

                        {{-- Konten Pembahasan yang Bisa Disembunyikan --}}
                        <div class="collapse mt-3" id="pembahasan-{{ $question->id }}">
                            <div class="card card-body bg-light-secondary">
                                <h6 class="fw-semibold">Pembahasan:</h6>
                                @if ($question->explanation)
                                    <p class="mb-0">{!! nl2br(e($question->explanation)) !!}</p>
                                @else
                                    <p class="mb-0 text-muted">Belum ada pembahasan untuk soal ini.</p>
                                @endif
                            </div>
                        </div>
                        {{-- 👆 [AKHIR BAGIAN BARU] --}}

                    </div>
                </div>
            @empty
                {{-- Tampilan Jika Tidak Ada Soal --}}
                <div class="text-center py-5">
                    <h4 class="text-muted">📝</h4>
                    <h5 class="mt-2">Belum Ada Soal</h5>
                    <p class="text-muted">Silakan tambahkan soal pertama untuk paket kuis ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

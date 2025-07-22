<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">{{ $isEditMode ? 'Edit Soal' : 'Tambah Soal Baru' }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.quiz-packages.index') }}">Paket
                            Kuis</a></li>
                    <li class="breadcrumb-item"><a class="text-muted"
                            href="{{ route('admin.questions.index', $quiz_package) }}">Soal</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $isEditMode ? 'Edit' : 'Tambah' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3">
                    <label for="question_text" class="form-label">Teks Soal</label>
                    <textarea id="question_text" class="form-control" rows="4" wire:model="question_text"></textarea>
                    @error('question_text')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <h5 class="card-title">Pilihan Jawaban</h5>
                    <small>Tandai salah satu sebagai jawaban yang benar.</small>
                </div>

                @foreach ($answers as $index => $answer)
                    <div class="input-group mb-3" wire:key="answer-{{ $index }}">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" wire:model="correctAnswerIndex"
                                value="{{ $index }}" aria-label="Tandai sebagai jawaban benar">
                        </div>
                        <input type="text" class="form-control" wire:model="answers.{{ $index }}.text"
                            placeholder="Pilihan Jawaban {{ $index + 1 }}">
                    </div>
                    @error("answers.{$index}.text")
                        <div class="text-danger mb-2" style="margin-top: -10px;">{{ $message }}</div>
                    @enderror
                @endforeach
                @error('correctAnswerIndex')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror


                <div class="mb-3 mt-4">
                    <label for="explanation" class="form-label">Pembahasan Jawaban (Opsional)</label>
                    <textarea id="explanation" class="form-control" rows="4" wire:model="explanation"></textarea>
                    @error('explanation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Soal</button>
                <a href="{{ route('admin.questions.index', $quiz_package) }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

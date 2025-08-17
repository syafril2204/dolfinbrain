<div>
    {{-- Header & Breadcrumb --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Pengerjaan Soal</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('students.soal.index') }}">Soal</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">{{ $quiz_package->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        {{-- Kolom Utama Soal --}}
        <div class="col-lg-8">
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <i class="ti ti-clock fs-5 me-2"></i>
                Sisa Waktu Pengerjaan:
                <strong class="ms-2" id="timer">Memuat...</strong>
            </div>

            <div class="card">
                <div class="card-body">
                    <p class="mb-3">
                        <strong>Soal : {{ $currentQuestionIndex + 1 }} / {{ $totalQuestions }}</strong>
                    </p>

                    {{-- [FIX] Menampilkan Gambar Soal Jika Ada --}}
                    @if ($currentQuestion->image)
                        <div class="text-center mb-4">
                            <img src="{{ Storage::url($currentQuestion->image) }}" class="img-fluid rounded"
                                style="max-height: 350px;" alt="Gambar Soal">
                        </div>
                    @endif

                    <p class="fs-5 mb-4">{!! nl2br(e($currentQuestion->question_text)) !!}</p>
                    <hr>

                    {{-- [IMPROVEMENT] Tampilan Opsi Jawaban Disederhanakan --}}
                    <div class="answers-container">
                        @foreach ($currentQuestion->answers as $answer)
                            <div class="answer-option mb-2" wire:key="{{ $answer->id }}">
                                <input class="form-check-input" type="radio" id="ans-{{ $answer->id }}"
                                    value="{{ $answer->id }}"
                                    wire:click="selectAnswer({{ $currentQuestion->id }}, {{ $answer->id }})"
                                    name="question-{{ $currentQuestion->id }}" {{-- [IMPROVEMENT] Menggunakan directive @checked --}}
                                    @checked(isset($userAnswers[$currentQuestion->id]) && $userAnswers[$currentQuestion->id] == $answer->id)>
                                <label class="form-check-label" for="ans-{{ $answer->id }}">
                                    <span class="fw-bold">{{ chr(65 + $loop->index) }}.</span>
                                    {{ $answer->answer_text }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Tombol Navigasi --}}
            <div class="d-flex justify-content-between">
                @if ($currentQuestionIndex > 0)
                    <button class="btn btn-outline-secondary"
                        wire:click="goToQuestion({{ $currentQuestionIndex - 1 }})">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </button>
                @else
                    <div></div> {{-- Placeholder agar tombol selanjutnya tetap di kanan --}}
                @endif

                @if ($currentQuestionIndex < $totalQuestions - 1)
                    <button class="btn btn-primary" wire:click="goToQuestion({{ $currentQuestionIndex + 1 }})">
                        Selanjutnya <i class="ti ti-arrow-right ms-1"></i>
                    </button>
                @endif

                @if ($currentQuestionIndex == $totalQuestions - 1)
                    <button class="btn btn-success" wire:click="submitQuiz"
                        wire:confirm="Anda yakin ingin menyelesaikan dan mengumpulkan kuis ini?">
                        <i class="ti ti-check me-1"></i> Selesaikan Kuis
                    </button>
                @endif
            </div>
        </div>

        {{-- Kolom Navigasi Nomor Soal --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Navigasi Soal</h5>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        @for ($i = 0; $i < $totalQuestions; $i++)
                            <button
                                class="btn btn-sm
                                @if ($currentQuestionIndex == $i) btn-primary
                                @elseif(isset($userAnswers[$questions[$i]->id]) && $userAnswers[$questions[$i]->id] !== null)
                                    btn-dark
                                @else
                                    btn-outline-secondary @endif"
                                wire:click="goToQuestion({{ $i }})" style="width: 40px; height: 40px;">
                                {{ $i + 1 }}
                            </button>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="card bg-light-warning">
                <div class="card-body">
                    <h5 class="card-title">Keterangan</h5>
                    <div class="mt-3">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-primary rounded-pill me-2" style="width: 20px;">&nbsp;</span> Posisi
                            Saat Ini
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-dark rounded-pill me-2" style="width: 20px;">&nbsp;</span> Sudah
                            Dijawab
                        </div>
                        <div class="d-flex align-items-center">
                            <span
                                class="badge bg-light-secondary text-secondary border border-secondary rounded-pill me-2"
                                style="width: 20px;">&nbsp;</span> Belum Dijawab
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .answer-option {
            border: 1px solid #e9ecef;
            padding: 1rem;
            border-radius: 7px;
            transition: all 0.2s ease-in-out;
        }

        .answer-option:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .answer-option input[type="radio"] {
            transform: scale(1.4);
        }

        .answer-option label {
            display: flex;
            align-items: center;
            width: 100%;
            margin-bottom: 0;
            cursor: pointer;
        }

        .answer-option label span {
            margin-right: 0.75rem;
        }
    </style>
@endpush

@push('scripts')
    {{-- Kode JavaScript untuk timer tidak perlu diubah, sudah benar --}}
    <script>
        document.addEventListener('livewire:navigated', () => {
            let duration = @json($timeRemaining);
            const timerElement = document.getElementById('timer');

            if (window.quizTimer) {
                clearInterval(window.quizTimer);
            }

            window.quizTimer = setInterval(function() {
                if (duration < 0) {
                    clearInterval(window.quizTimer);
                    return;
                }

                const hours = Math.floor(duration / 3600);
                const minutes = Math.floor((duration % 3600) / 60);
                const seconds = Math.floor(duration % 60);

                if (timerElement) {
                    timerElement.textContent =
                        `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                }

                duration--;

                if (duration < 0) {
                    clearInterval(window.quizTimer);
                    if (!window.quizSubmitted) {
                        window.quizSubmitted = true;
                        alert('Waktu pengerjaan telah habis! Kuis akan dikumpulkan secara otomatis.');
                        @this.submitQuiz();
                    }
                }
            }, 1000);
        });

        window.quizSubmitted = false;
    </script>
@endpush

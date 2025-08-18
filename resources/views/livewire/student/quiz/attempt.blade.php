<div>
    {{-- Header --}}
    <div class="quiz-header p-4 mb-4 rounded-lg">
        <h5 class="fw-semibold text-dark mb-2">Soal</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted" href="{{ route('students.soal.index') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a class="text-muted" href="#">LMS Space</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $quiz_package->title }}</li>
            </ol>
        </nav>
    </div>

    {{-- Timer --}}
    <div class="quiz-timer d-flex align-items-center justify-content-between p-3 rounded-lg mb-4">
        <div class="d-flex align-items-center">
            <i class="ti ti-clock fs-5 me-2"></i>
            <span class="fw-semibold">Sisa Waktu Pengerjaan</span>
        </div>
        <strong id="timer" class="fs-5 text-dark">00:00:00</strong>
    </div>

    <div class="row">
        {{-- Soal --}}
        <div class="col-lg-8 mb-4">
            <div class="quiz-card p-4 rounded-lg shadow-sm">
                <p class="fw-semibold mb-3">Quiz : {{ $currentQuestionIndex + 1 }} / {{ $totalQuestions }}</p>

                {{-- Gambar Soal --}}
                @if ($currentQuestion->image)
                    <div class="text-center mb-4">
                        <img src="{{ Storage::url($currentQuestion->image) }}" class="img-fluid rounded"
                            style="max-height: 300px;" alt="Gambar Soal">
                    </div>
                @endif

                <p class="fs-6 mb-4">{!! nl2br(e($currentQuestion->question_text)) !!}</p>

                {{-- Jawaban --}}
                <div class="answer-list">
                    @foreach ($currentQuestion->answers as $answer)
                        <label class="answer-option p-3 rounded-lg mb-3 d-flex align-items-center"
                            for="ans-{{ $answer->id }}" wire:key="{{ $answer->id }}">
                            <input type="radio" id="ans-{{ $answer->id }}"
                                name="question-{{ $currentQuestion->id }}" value="{{ $answer->id }}"
                                wire:click="selectAnswer({{ $currentQuestion->id }}, {{ $answer->id }})"
                                @checked(isset($userAnswers[$currentQuestion->id]) && $userAnswers[$currentQuestion->id] == $answer->id)>
                            <span class="option-label fw-bold me-2">{{ chr(65 + $loop->index) }}.</span>
                            <span>{{ $answer->answer_text }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Navigasi Tombol --}}
            <div class="d-flex justify-content-between mt-3">
                @if ($currentQuestionIndex > 0)
                    <button class="btn btn-outline-secondary rounded-lg px-4"
                        wire:click="goToQuestion({{ $currentQuestionIndex - 1 }})">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </button>
                @else
                    <div></div>
                @endif

                @if ($currentQuestionIndex < $totalQuestions - 1)
                    <button class="btn btn-primary rounded-lg px-4"
                        wire:click="goToQuestion({{ $currentQuestionIndex + 1 }})">
                        Selanjutnya <i class="ti ti-arrow-right ms-1"></i>
                    </button>
                @else
                    <button class="btn btn-success rounded-lg px-4" wire:click="submitQuiz"
                        wire:confirm="Yakin ingin mengumpulkan kuis ini?">
                        <i class="ti ti-check me-1"></i> Selesaikan
                    </button>
                @endif
            </div>
        </div>

        {{-- Navigasi Soal --}}
        <div class="col-lg-4">
            <div class="quiz-card p-4 rounded-lg shadow-sm mb-4">
                <h6 class="fw-semibold">Daftar Pertanyaan</h6>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    @for ($i = 0; $i < $totalQuestions; $i++)
                        <button
                            class="quiz-number-btn
                            @if ($currentQuestionIndex == $i) active
                            @elseif(isset($userAnswers[$questions[$i]->id])) answered @endif"
                            wire:click="goToQuestion({{ $i }})">
                            {{ $i + 1 }}
                        </button>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .quiz-header {
            background: #f8fafc;
        }

        .quiz-timer {
            background: #e6f2ff;
        }

        .quiz-card {
            background: #fff;
            border: 1px solid #eee;
        }

        .answer-option {
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
            cursor: pointer;
        }

        .answer-option:hover {
            background: #f9fafb;
        }

        .answer-option input {
            margin-right: 10px;
            transform: scale(1.2);
        }

        .quiz-number-btn {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            background: #e6f2ff;
            color: #000;
        }

        .quiz-number-btn.active {
            background: #2196f3;
            color: #fff;
        }

        .quiz-number-btn.answered {
            background: #333;
            color: #fff;
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('livewire:navigated', () => {
            let duration = @json($timeRemaining); // ambil waktu dari backend (detik)
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

                // Auto submit kalau waktu habis
                if (duration < 0) {
                    clearInterval(window.quizTimer);
                    if (!window.quizSubmitted) {
                        window.quizSubmitted = true;
                        alert('Waktu pengerjaan telah habis! Kuis akan dikumpulkan otomatis.');
                        @this.submitQuiz();
                    }
                }
            }, 1000);
        });

        window.quizSubmitted = false;
    </script>
@endpush

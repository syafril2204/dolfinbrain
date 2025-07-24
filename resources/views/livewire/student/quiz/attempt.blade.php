<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Soal</h4>
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
        <div class="col-lg-8">
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <i class="ti ti-info-circle fs-5 me-2"></i>
                Sisa Waktu Pengerjaan:
                <strong class="ms-2" id="timer"></strong>
            </div>

            <div class="card">
                <div class="card-body">
                    <p class="mb-3"><strong>Quiz : {{ $currentQuestionIndex + 1 }} /
                            {{ $totalQuestions }}</strong>
                    </p>
                    <p class="fs-5">{!! nl2br(e($currentQuestion->question_text)) !!}</p>

                    <hr>

                    @foreach ($currentQuestion->answers as $answer)
                        <div class="card card-body border mb-2" wire:key="{{ $answer->id }}">
                            <div class="d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" id="ans-{{ $answer->id }}"
                                    value="{{ $answer->id }}"
                                    wire:click="selectAnswer({{ $currentQuestion->id }}, {{ $answer->id }})"
                                    name="question-{{ $currentQuestion->id }}"
                                    @if (isset($userAnswers[$currentQuestion->id]) && $userAnswers[$currentQuestion->id] == $answer->id) checked @endif>
                                <label class="form-check-label w-100 mb-0" for="ans-{{ $answer->id }}">
                                    {{ chr(65 + $loop->index) }}. {{ $answer->answer_text }}
                                </label>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="d-flex justify-content-between">
                @if ($currentQuestionIndex > 0)
                    <button class="btn btn-outline-secondary"
                        wire:click="goToQuestion({{ $currentQuestionIndex - 1 }})">Kembali</button>
                @else
                    <div></div>
                @endif
                @if ($currentQuestionIndex < $totalQuestions - 1)
                    <button class="btn btn-primary"
                        wire:click="goToQuestion({{ $currentQuestionIndex + 1 }})">Selanjutnya</button>
                @endif
                @if ($currentQuestionIndex == $totalQuestions - 1)
                    <button class="btn btn-success" wire:click="submitQuiz"
                        wire:confirm="Anda yakin ingin menyelesaikan kuis ini?">Submit</button>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Pertanyaan</h5>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        @for ($i = 0; $i < $totalQuestions; $i++)
                            <button
                                class="btn
                                @if ($currentQuestionIndex == $i) btn-primary
                                @elseif(isset($userAnswers[$questions[$i]->id])) btn-success
                                @else btn-outline-secondary @endif"
                                wire:click="goToQuestion({{ $i }})" style="width: 40px; height: 40px;">
                                {{ $i + 1 }}
                            </button>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:navigated',
            () => {
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
                    const seconds = Math.floor(duration %
                        60);

                    if (timerElement) {
                        timerElement.textContent =
                            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }

                    duration--;

                    if (duration < 0) {
                        clearInterval(window.quizTimer);
                        if (!window.quizSubmitted) {
                            window.quizSubmitted = true;
                            alert('Waktu habis!');
                            @this.submitQuiz();
                        }
                    }
                }, 1000);
            });

        window.quizSubmitted = false;
    </script>
@endpush

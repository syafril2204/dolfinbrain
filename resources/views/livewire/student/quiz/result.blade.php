<div>
    {{-- Skor --}}
    <div class="alert alert-success text-center fw-bold fs-4 rounded-3">
        Skor Anda <span class="text-success">{{ $score }}</span>
    </div>

    {{-- Feedback Motivasi --}}
    <div class="alert border border-dashed rounded-3 bg-light-warning p-4 mb-4">
        <p class="mb-0 fw-medium text-dark">
            Skor {{ $score }} itu sudah luar biasa! 🎉 <br>
            Kamu sudah menunjukkan usaha yang hebat dan hasilnya sangat baik—lihat semua jawaban benar yang kamu
            dapatkan! ✅
        </p>
    </div>

    <div class="row">
        {{-- Kolom Soal --}}
        <div class="col-md-8">
            @foreach ($showQuestions as $question)
                @php
                    $userAnswerId = $userAnswers[$question->id] ?? null;
                    $correctAnswerId = $question->answers->where('is_correct', true)->first()->id;
                    $isCorrect = $userAnswerId !== null && $userAnswerId == $correctAnswerId;
                @endphp

                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-header bg-primary text-white fw-bold rounded-top">
                        Quiz {{ $loop->iteration }}
                    </div>
                    <div class="card-body">
                        <p class="mb-3">{{ $question->question_text }}</p>

                        @foreach ($question->answers as $answer)
                            @php
                                $isUserAnswer = $userAnswerId == $answer->id;
                                $isCorrectAnswer = $answer->is_correct;
                            @endphp
                            <div
                                class="p-3 mb-2 rounded border
                                @if ($isCorrectAnswer) border-success bg-light-success text-success fw-bold
                                @elseif($isUserAnswer && !$isCorrectAnswer) border-danger bg-light-danger text-danger fw-bold
                                @else border-secondary @endif">
                                {{ chr(65 + $loop->index) }}. {{ $answer->answer_text }}
                                @if ($isCorrectAnswer)
                                    <i class="ti ti-check ms-2"></i>
                                @elseif ($isUserAnswer && !$isCorrectAnswer)
                                    <i class="ti ti-x ms-2"></i>
                                @endif
                            </div>
                        @endforeach
                        <h3 class="">Pembahasan: </h3>
                        <p class="mb-3">{{ $question->explanation }}</p>
                    </div>
                </div>
            @endforeach
            <div class="mt-3">{{ $showQuestions->links('partials.custom-pagination') }}</div>
        </div>

        {{-- Kolom Daftar Pertanyaan --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-primary text-white fw-bold rounded-top">
                    Daftar Pertanyaan
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2" style="grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));">
                        @foreach ($attempt->quizPackage->questions as $question)
                            @php
                                $userAnswerId = $userAnswers[$question->id] ?? null;
                                $correctAnswerId = $question->answers->where('is_correct', true)->first()->id;
                                $isCorrect = $userAnswerId !== null && $userAnswerId == $correctAnswerId;
                            @endphp
                            <div class="d-flex align-items-center justify-content-center rounded-3 border fw-bold
            @if ($userAnswerId === null) border-secondary text-secondary
            @elseif($isCorrect) border-success text-success
            @else border-danger text-danger @endif"
                                style="width:40px; height:40px;">
                                <a href="/students/quiz/result/1?page={{ $loop->iteration }}">
                                    {{ $loop->iteration }}
                                </a>

                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('students.soal.index') }}"
                        class="btn btn-primary w-100 mt-4 rounded-pill">Kembali
                        Ke Daftar Quiz</a>
                </div>
            </div>
        </div>
    </div>
</div>

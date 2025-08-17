<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold">Detail Paket Kuis: {{ $quiz_package->title }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.quiz-packages.index') }}">Paket Kuis</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.quiz-packages.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Deskripsi:</strong> {{ $quiz_package->description ?? '-' }}</p>
            <p><strong>Durasi:</strong> {{ $quiz_package->duration_in_minutes }} menit</p>
            <p><strong>Status:</strong>
                @if ($quiz_package->is_active)
                    Aktif
                @else
                    Nonaktif
                @endif
            </p>
            <p class="mb-0"><strong>Untuk Jabatan:</strong>
                @forelse($quiz_package->positions as $position)
                    <span class="badge bg-light-primary text-primary">{{ $position->formation->name }} -
                        {{ $position->name }}</span>
                @empty
                    -
                @endforelse
            </p>
        </div>
    </div>

    <h5 class="mb-3">Daftar Soal Terlampir</h5>
    @forelse ($quiz_package->questions as $question)
        <div class="card border mb-3" wire:key="{{ $question->id }}">
            <div class="card-body">
                <p class="mb-2"><strong>Soal #{{ $loop->iteration }}</strong></p>
                <p>{!! nl2br(e($question->question_text)) !!}</p>
                <hr>
                <small>Pilihan Jawaban:</small>
                <ul class="list-unstyled">
                    @foreach ($question->answers as $answer)
                        <li class="{{ $answer->is_correct ? 'text-success fw-bold' : '' }}">
                            {{ chr(65 + $loop->index) }}. {{ $answer->answer_text }}
                            @if ($answer->is_correct)
                                <i class="ti ti-check"></i>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <p>Belum ada soal untuk paket ini.</p>
    @endforelse
</div>

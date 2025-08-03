<div>
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('students.lms.show', $lms_space) }}" class="text-dark"><i
                class="ti ti-arrow-left fs-6 me-2"></i></a>
        <div>
            <h4 class="fw-semibold mb-0">Quiz</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.index') }}">LMS Space</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.show', $lms_space) }}">Pertemuan</a></li>
                    <li class="breadcrumb-item active">Quiz</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        @forelse ($quizPackages as $package)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('students.quiz.attempt', $package) }}" class="text-decoration-none">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-semibold mb-0 text-dark">{{ $package->title }}</h6>
                                <span class="badge bg-primary">Mulai</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p>Belum ada kuis untuk pertemuan ini.</p>
        @endforelse
    </div>
</div>

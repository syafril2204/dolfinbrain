<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Kelola Konten: {{ $lms_space->title }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.lms-spaces.index') }}">LMS
                            Space</a></li>
                    <li class="breadcrumb-item" aria-current="page">Kelola Konten</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.lms-spaces.content.coaching.index', $lms_space) }}">
                <div class="card card-body text-center">
                    <i class="ti ti-calendar-event fs-8 text-primary"></i>
                    <h6 class="fw-semibold mt-3 mb-0">Coaching</h6>
                    <p class="text-muted mb-0">Jadwal Live Session</p>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a
                href="{{ route('admin.lms-spaces.content.attachments', ['lms_space' => $lms_space, 'tab' => 'materials']) }}">
                <div class="card card-body text-center">
                    <i class="ti ti-book fs-8 text-secondary"></i>
                    <h6 class="fw-semibold mt-3 mb-0">Materi</h6>
                    <p class="text-muted mb-0">Lampirkan Materi Belajar</p>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a
                href="{{ route('admin.lms-spaces.content.attachments', ['lms_space' => $lms_space, 'tab' => 'quizzes']) }}">
                <div class="card card-body text-center">
                    <i class="ti ti-file-text fs-8 text-success"></i>
                    <h6 class="fw-semibold mt-3 mb-0">Kuis</h6>
                    <p class="text-muted mb-0">Lampirkan Paket Soal</p>
                </div>
            </a>
        </div>
    </div>
</div>

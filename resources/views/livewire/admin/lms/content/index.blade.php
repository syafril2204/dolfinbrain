<div>
    {{-- Header & Breadcrumb --}}
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
        {{-- Menu Coaching --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.lms-spaces.content.coaching.index', $lms_space) }}">
                <div class="card card-body text-center">
                    <i class="ti ti-calendar-event fs-8 text-primary"></i>
                    <h6 class="fw-semibold mt-3 mb-0">Coaching</h6>
                    <p class="text-muted mb-0">Jadwal Live Session</p>
                </div>
            </a>
        </div>
        {{-- Menu Materi --}}
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
        {{-- Menu Kuis --}}
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
        {{-- Menu Rekaman --}}
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.lms-spaces.content.videos.index', $lms_space) }}">
                <div class="card card-body text-center">
                    <i class="ti ti-video fs-8 text-danger"></i>
                    <h6 class="fw-semibold mt-3 mb-0">Rekaman</h6>
                    <p class="text-muted mb-0">Kelola Video Rekaman</p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a
                href="{{ route('admin.lms-spaces.content.files.index', ['lms_space' => $lms_space, 'tab' => 'files']) }}">
                <div class="card card-body text-center">
                    <i class="ti ti-file-invoice fs-8 text-warning"></i>
                    <h6 class="fw-semibold mt-3 mb-0">File Rekap</h6>
                    <p class="text-muted mb-0">Kelola File PDF, DOC, dll</p>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a
                href="{{ route('admin.lms-spaces.content.files.index', ['lms_space' => $lms_space, 'tab' => 'audio']) }}">
                <div class="card card-body text-center">
                    <i class="ti ti-microphone fs-8 text-info"></i>
                    <h6 class="fw-semibold mt-3 mb-0">Audio</h6>
                    <p class="text-muted mb-0">Kelola Rekaman Audio</p>
                </div>
            </a>
        </div>
    </div>
</div>

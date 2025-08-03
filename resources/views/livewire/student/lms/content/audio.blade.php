<div>
    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('students.lms.show', $lms_space) }}" class="text-dark"><i
                class="ti ti-arrow-left fs-6 me-2"></i></a>
        <div>
            <h4 class="fw-semibold mb-0">Audio</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.index') }}">LMS Space</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.show', $lms_space) }}">Pertemuan</a></li>
                    <li class="breadcrumb-item active">Audio</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        @forelse ($audios as $audio)
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.lms-resources.download', $audio) }}" class="text-decoration-none">
                    <div class="card card-body">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-volume fs-8 text-info"></i>
                            <div class="ms-3">
                                <h6 class="fw-semibold mb-0 fs-4">{{ Str::limit($audio->title, 25) }}</h6>
                                <span class="fs-2 text-muted">{{ number_format($audio->file_size / 1024, 1) }} KB</span>
                            </div>
                            <i class="ti ti-player-play ms-auto text-muted"></i>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p>Belum ada audio untuk pertemuan ini.</p>
        @endforelse
    </div>
</div>

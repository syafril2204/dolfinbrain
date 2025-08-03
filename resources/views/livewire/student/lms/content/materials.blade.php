<div>
    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('students.lms.show', $lms_space) }}" class="text-dark"><i
                class="ti ti-arrow-left fs-6 me-2"></i></a>
        <div>
            <h4 class="fw-semibold mb-0">Materi</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.index') }}">LMS Space</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.show', $lms_space) }}">Pertemuan</a></li>
                    <li class="breadcrumb-item active">Materi</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Daftar Materi --}}
    <div class="row">
        @forelse ($materials as $material)
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('materials.download', $material) }}" class="text-decoration-none">
                    <div class="card card-body">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-file-text fs-8 text-primary"></i>
                            <div class="ms-3">
                                <h6 class="fw-semibold mb-0 fs-4">{{ Str::limit($material->title, 25) }}</h6>
                                <span class="fs-2 text-muted">{{ number_format($material->file_size / 1024, 1) }}
                                    KB</span>
                            </div>
                            <i class="ti ti-download ms-auto text-muted"></i>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p>Belum ada materi untuk pertemuan ini.</p>
        @endforelse
    </div>
</div>

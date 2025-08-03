<div>
    {{-- Header --}}
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('students.lms.show', $lms_space) }}" class="text-dark"><i
                class="ti ti-arrow-left fs-6 me-2"></i></a>
        <div>
            <h4 class="fw-semibold mb-0">Files</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.index') }}">LMS Space</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.show', $lms_space) }}">Pertemuan</a></li>
                    <li class="breadcrumb-item active">Files</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        @forelse ($files as $file)
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('admin.lms-resources.download', $file) }}" class="text-decoration-none">
                    <div class="card card-body text-center">
                        @if (in_array($file->file_type, ['pdf', 'doc', 'docx']))
                            <i class="ti ti-file-text fs-8 text-danger"></i>
                        @else
                            <i class="ti ti-file fs-8 text-secondary"></i>
                        @endif
                        <h6 class="fw-semibold mt-3 mb-0">{{ Str::limit($file->title, 20) }}</h6>
                        <p class="text-muted fs-2">{{ number_format($file->file_size / 1024, 1) }} KB</p>
                        <span class="btn btn-primary">Download</span>
                    </div>
                </a>
            </div>
        @empty
            <p>Belum ada file rekap untuk pertemuan ini.</p>
        @endforelse
    </div>
</div>

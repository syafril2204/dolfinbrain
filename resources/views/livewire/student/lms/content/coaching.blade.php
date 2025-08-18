<div>
    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('students.lms.show', $lms_space) }}" class="text-dark me-3">
            <i class="ti ti-arrow-left fs-5"></i>
        </a>
        <div>
            <h4 class="fw-semibold mb-1">Coaching Schedule</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.show', $lms_space) }}">LMS Space</a></li>
                    <li class="breadcrumb-item active">Coaching</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Alert -->
    <div class="alert alert-warning d-flex align-items-center" role="alert">
        <i class="ti ti-info-circle me-2 fs-5"></i>
        <span><strong>Catatan:</strong> Pastikan koneksi internet stabil dan login minimal 5 menit sebelum sesi dimulai.
            Materi dan rekaman akan tersedia setelah sesi selesai.</span>
    </div>

    <!-- Coaching List -->
    @forelse($coachings as $coaching)
        <div class="card border-0 shadow-sm mb-3 rounded-4">
            <div class="card-body">
                <!-- Title -->
                <p class="mb-1 text-danger fw-semibold">
                    <i class="ti ti-pin me-1"></i> Topik Coaching :
                </p>
                <h5 class="fw-bold text-primary mb-2">
                    {{ $coaching->title }}
                </h5>
                <p class="text-muted mb-3">Dipandu oleh {{ $coaching->trainer_name }}</p>

                <!-- Schedule + Button -->
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex flex-wrap gap-3 small">
                        <div class="px-3 py-2 bg-light rounded d-flex align-items-center">
                            <i class="ti ti-calendar-event me-2 text-primary"></i>
                            {{ $coaching->start_at->translatedFormat('l, j F Y') }}
                        </div>
                        <div class="px-3 py-2 bg-light rounded d-flex align-items-center">
                            <i class="ti ti-clock me-2 text-primary"></i>
                            {{ $coaching->start_at->format('H:i') }} - {{ $coaching->end_at->format('H:i') }} WIB
                        </div>
                    </div>

                    <!-- Button -->
                    <a href="{{ $coaching->meeting_url }}" target="_blank"
                        class="btn btn-primary rounded-pill px-4 mt-3 mt-md-0">
                        Gabung Sekarang
                    </a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada jadwal coaching untuk pertemuan ini.</p>
    @endforelse
</div>

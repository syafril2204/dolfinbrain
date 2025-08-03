<div>
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('students.lms.show', $lms_space) }}" class="text-dark"><i
                class="ti ti-arrow-left fs-6 me-2"></i></a>
        <div>
            <h4 class="fw-semibold mb-0">Coaching</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.index') }}">LMS Space</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.show', $lms_space) }}">Pertemuan</a></li>
                    <li class="breadcrumb-item active">Coaching</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="alert alert-warning">
        <strong>Catatan:</strong> Pastikan koneksi internet stabil dan login minimal 5 menit sebelum sesi dimulai.
        Materi dan rekaman akan tersedia setelah sesi selesai.
    </div>

    @forelse($coachings as $coaching)
        <div class="card border shadow-sm">
            <div class="card-body">
                <p class="mb-1 text-muted">Topik Coaching :</p>
                <h5 class="fw-semibold">{{ $coaching->title }}</h5>
                <p class="mb-3">Dipandu oleh {{ $coaching->trainer_name }}</p>

                <div class="d-flex flex-wrap gap-3">
                    <div class="d-flex align-items-center text-muted"><i class="ti ti-calendar-event me-2"></i>
                        {{ $coaching->start_at->translatedFormat('l, j F Y') }}</div>
                    <div class="d-flex align-items-center text-muted"><i class="ti ti-clock me-2"></i>
                        {{ $coaching->start_at->format('H:i') }} - {{ $coaching->end_at->format('H:i') }} WIB</div>
                </div>

                <div class="mt-4">
                    <a href="{{ $coaching->meeting_url }}" target="_blank" class="btn btn-primary">Gabung Sekarang</a>
                </div>
            </div>
        </div>
    @empty
        <p>Belum ada jadwal coaching untuk pertemuan ini.</p>
    @endforelse
</div>

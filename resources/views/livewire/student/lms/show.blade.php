<div>
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">{{ $lms_space->title }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('students.lms.index') }}">LMS
                            Space</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Pertemuan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        {{-- Kolom Kiri: Deskripsi Pertemuan --}}
        <div class="col-lg-8">
            <div class="card">
                <img src="{{ $lms_space->image_path ? Storage::url($lms_space->image_path) : 'https://via.placeholder.com/700x400' }}"
                    class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="fw-bolder">Bimbingan Lanjutan</h4>
                        @if ($lms_space->coachings->isNotEmpty())
                            @php $firstCoaching = $lms_space->coachings->first(); @endphp
                            <span
                                class="badge bg-light-primary text-primary fs-3">{{ $firstCoaching->start_at->format('H:i') }}
                                - {{ $firstCoaching->end_at->format('H:i') }} WIB</span>
                        @endif
                    </div>
                    <p>{{ $lms_space->description }}</p>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Menu Konten --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Menu</h5>
                    <div class="row">
                        <div class="col-6 mb-3"><a href="{{ route('students.lms.content.materials', $lms_space) }}"
                                class="card card-body text-center text-decoration-none"><i class="ti ti-book fs-7"></i>
                                <p class="mb-0 mt-2" style="font-size: 12.5px">Materi</p>
                            </a></div>
                        <div class="col-6 mb-3"><a href="{{ route('students.lms.content.coaching', $lms_space) }}"
                                class="card card-body text-center text-decoration-none"><i
                                    class="ti ti-microphone fs-7"></i>
                                <p class="mb-0 mt-2" style="font-size: 12.5px">Coaching</p>
                            </a></div>
                        <div class="col-6 mb-3"><a href="{{ route('students.lms.content.videos', $lms_space) }}"
                                class="card card-body text-center text-decoration-none"><i class="ti ti-video fs-7"></i>
                                <p class="mb-0 mt-2" style="font-size: 12.5px">Rekaman</p>
                            </a></div>
                        <div class="col-6 mb-3"><a href="{{ route('students.lms.content.quizzes', $lms_space) }}"
                                class="card card-body text-center text-decoration-none"><i
                                    class="ti ti-file-text fs-7"></i>
                                <p class="mb-0 mt-2" style="font-size: 12.5px">Kuis</p>
                            </a></div>
                        <div class="col-6"><a href="{{ route('students.lms.content.files', $lms_space) }}"
                                class="card card-body text-center text-decoration-none"><i class="ti ti-files fs-7"></i>
                                <p class="mb-0 mt-2" style="font-size: 12.5px">File</p>
                            </a></div>
                        <div class="col-6"><a href="{{ route('students.lms.content.audio', $lms_space) }}"
                                class="card card-body text-center text-decoration-none"><i
                                    class="ti ti-volume fs-7"></i>
                                <p class="mb-0 mt-2" style="font-size: 12.5px">Audio</p>
                            </a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

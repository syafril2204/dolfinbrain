<div>
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('students.lms.show', $lms_space) }}" class="text-dark"><i
                class="ti ti-arrow-left fs-6 me-2"></i></a>
        <div>
            <h4 class="fw-semibold mb-0">Video</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.index') }}">LMS Space</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.show', $lms_space) }}">Pertemuan</a></li>
                    <li class="breadcrumb-item active">Video</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            @if ($playingVideo)
                <div class="card">
                    <div class="card-body p-0">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $playingVideo->youtube_url }}" title="YouTube video player"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <h4 class="fw-bolder">{{ $playingVideo->title }}</h4>
                <p><strong>Overview:</strong><br>{{ $lms_space->description }}</p>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-semibold">Chapter</h5>
                    <div class="list-group list-group-flush">
                        @foreach ($videos as $video)
                            <a href="#" wire:click.prevent="playVideo({{ $video->id }})"
                                class="list-group-item list-group-item-action d-flex align-items-center {{ $playingVideo->id == $video->id ? 'active' : '' }}">
                                <i class="ti ti-player-play fs-5 me-2"></i>
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ $video->title }}</h6>
                                    <small>{{ $video->duration }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

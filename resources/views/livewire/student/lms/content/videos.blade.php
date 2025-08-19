<div>
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('students.lms.show', $lms_space) }}" class="text-dark me-3">
            <i class="ti ti-arrow-left fs-5"></i>
        </a>
        <div>
            <h4 class="fw-bold text-primary mb-1">Rekaman Bimbel</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small text-muted">
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.index') }}">LMS Space</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.lms.show', $lms_space) }}">Pertemuan 1</a>
                    </li>
                    <li class="breadcrumb-item active">Rekaman Bimbel</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            @if ($playingVideo)
                <div class="position-relative rounded-3 overflow-hidden mb-3">
                    <div class="ratio ratio-16x9">
                        <iframe src="{{ $playingVideo->youtube_url }}" class="rounded-3" allowfullscreen>
                        </iframe>
                    </div>

                    <div class="position-absolute bottom-0 start-0 w-100 p-3 text-white"
                        style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                        <h6 class="mb-1">{{ $playingVideo->title }}</h6>
                        <small>{{ $playingVideo->created_at->format('d F Y') }}</small>
                    </div>
                </div>

                <h5 class="fw-semibold mb-2">{{ $playingVideo->title }}</h5>
                <p class="text-muted lh-lg" style="text-align: justify;">
                    {{ $lms_space->description }}
                </p>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Chapter</h6>
                    <div class="list-group list-group-flush">
                        @foreach ($videos as $video)
                            <a href="#" wire:click.prevent="playVideo({{ $video->id }})"
                                class="list-group-item list-group-item-action d-flex align-items-center py-3 px-2 border-0 mb-2 rounded-3 {{ $playingVideo->id == $video->id ? 'bg-light border-start border-3 border-primary' : '' }}">
                                {{--

                                <img src="{{ $video->youtube_thumbnail }}" alt="thumb" class="rounded me-3"
                                    style="width: 60px; height: 40px; object-fit: cover;"> --}}


                                <div class="flex-grow-1">
                                    {{-- <h6 class="mb-0 fw-semibold">{{ $video->title }}</h6> --}}
                                    <small class="text-muted">{{ $video->duration }}</small>
                                </div>

                                @if ($playingVideo->id == $video->id)
                                    <i class="ti ti-circle-check text-primary fs-5 ms-2"></i>
                                @else
                                    <i class="ti ti-player-play text-muted fs-5 ms-2"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

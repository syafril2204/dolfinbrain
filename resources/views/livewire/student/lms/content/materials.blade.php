    <div>
        <div
            class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center justify-content-between gap-2 mb-4">
        </div>

        {{-- Daftar Materi --}}
        <div class="row">
            @forelse ($materials as $material)
                @php
                    $sizeInKb = $material->file_size / 1024;
                    if ($sizeInKb < 1024) {
                        $displaySize = number_format($sizeInKb, 1) . ' KB';
                    } else {
                        $displaySize = number_format($sizeInKb / 1024, 2) . ' MB';
                    }
                @endphp
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 ">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3 flex-shrink-0">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="ti ti-file-text fs-6 text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="fw-semibold mb-0 text-truncate" title="{{ $material->title }}">
                                        {{ $material->title }}
                                    </h6>
                                    <small class="text-muted">{{ $displaySize }}</small>
                                </div>
                                <div class="ms-2 flex-shrink-0">
                                    <a href="{{ route('materials.download', $material) }}"
                                        class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 35px; height: 35px;" title="Unduh Materi">
                                        <i class="ti ti-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Belum ada materi untuk pertemuan ini.</p>
            @endforelse
        </div>
    </div>

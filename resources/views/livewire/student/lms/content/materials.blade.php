    <div>
        <div
            class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center justify-content-between gap-2 mb-4">

            <form action="{{ route('students.lms.search') }}" method="GET" class="w-100 w-md-auto">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari materi..."
                        value="{{ request('q') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>

            <a href="{{ route('materials.create') }}" class="btn btn-success w-100 w-md-auto">
                + Tambah Materi
            </a>

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

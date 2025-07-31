<div>
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Lampiran Konten: {{ Str::limit($lms_space->title, 30) }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('admin.lms-spaces.index') }}">LMS
                            Space</a></li>
                    <li class="breadcrumb-item"><a class="text-muted"
                            href="{{ route('admin.lms-spaces.content.index', $lms_space) }}">Kelola Konten</a></li>
                    <li class="breadcrumb-item" aria-current="page">Lampiran</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link {{ $activeTab === 'materials' ? 'active' : '' }}" href="#"
                wire:click.prevent="switchTab('materials')">Materi</a></li>
        <li class="nav-item"><a class="nav-link {{ $activeTab === 'quizzes' ? 'active' : '' }}" href="#"
                wire:click.prevent="switchTab('quizzes')">Kuis</a></li>
    </ul>

    <div class="card">
        <div class="card-body">
            <div class="{{ $activeTab === 'materials' ? 'd-block' : 'd-none' }}">
                <form wire:submit.prevent="saveMaterials">
                    <div class="mb-3" wire:ignore>
                        <label class="form-label">Pilih Materi untuk Dilampirkan</label>
                        <select class="form-control" id="select-materials" multiple>
                            @foreach ($allMaterials as $material)
                                <option value="{{ $material->id }}">{{ $material->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Materi</button>
                </form>

                <hr class="my-4">
                <h5 class="mb-3">Materi Terlampir</h5>
                <div class="table-responsive">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tipe</th>
                                <th>Ukuran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attachedMaterials as $material)
                                <tr>
                                    <td>{{ $material->title }}</td>
                                    <td><span class="badge bg-secondary">{{ strtoupper($material->file_type) }}</span>
                                    </td>
                                    <td>{{ number_format($material->file_size / 1024, 2) }} KB</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada materi yang dilampirkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="{{ $activeTab === 'quizzes' ? 'd-block' : 'd-none' }}">
                <form wire:submit.prevent="saveQuizzes">
                    <div class="mb-3" wire:ignore>
                        <label class="form-label">Pilih Paket Kuis untuk Dilampirkan</label>
                        <select class="form-control" id="select-quizzes" multiple>
                            @foreach ($allQuizzes as $quiz)
                                <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Kuis</button>
                </form>

                <hr class="my-4">
                <h5 class="mb-3">Kuis Terlampir</h5>
                <div class="table-responsive">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Durasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attachedQuizzes as $quiz)
                                <tr>
                                    <td>{{ $quiz->title }}</td>
                                    <td>{{ $quiz->duration_in_minutes }} Menit</td>
                                    <td>
                                        @if ($quiz->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada kuis yang dilampirkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function initSelect2() {
            $('#select-materials').select2({
                placeholder: "Pilih materi",
                width: '100%'
            }).on('change', function(e) {
                @this.set('selectedMaterials', $(this).val());
            });

            $('#select-quizzes').select2({
                placeholder: "Pilih paket kuis",
                width: '100%'
            }).on('change', function(e) {
                @this.set('selectedQuizzes', $(this).val());
            });

            $('#select-materials').val(@json($selectedMaterials)).trigger('change.select2');
            $('#select-quizzes').val(@json($selectedQuizzes)).trigger('change.select2');
        }

        document.addEventListener('livewire:init', () => {
            initSelect2();
        });

        Livewire.on('tabChanged', () => {
            if ($('#select-materials').data('select2')) {
                $('#select-materials').select2('destroy');
            }
            if ($('#select-quizzes').data('select2')) {
                $('#select-quizzes').select2('destroy');
            }
            initSelect2();
        });
    </script>
@endpush

<div>
    {{-- Header --}}
    <div class="card bg-light-info shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Kontak</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-muted"
                            href="{{ route('students.profile.index') }}">Profile</a></li>
                    <li class="breadcrumb-item" aria-current="page">Kontak</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                {{-- Kolom Kiri: Opsi Kontak --}}
                <div class="col-lg-6">
                    <h4 class="fw-semibold mb-4">Ada pertanyaan?</h4>

                    {{-- Opsi WhatsApp --}}
                    <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none">
                        <div class="d-flex align-items-center p-3 border rounded mb-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/240px-WhatsApp.svg.png"
                                alt="WhatsApp" height="40">
                            <div class="ms-3">
                                <h6 class="fw-semibold mb-0">Chat WhatsApp</h6>
                                <p class="text-muted mb-0 fs-2">Hubungi admin langsung melalui WhatsApp untuk respon
                                    cepat.</p>
                            </div>
                            <i class="ti ti-chevron-right ms-auto text-muted"></i>
                        </div>
                    </a>

                    {{-- Opsi Instagram --}}
                    <a href="https://instagram.com/dolfinbrain" target="_blank" class="text-decoration-none">
                        <div class="d-flex align-items-center p-3 border rounded mb-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Instagram_logo_2016.svg/240px-Instagram_logo_2016.svg.png"
                                alt="Instagram" height="40">
                            <div class="ms-3">
                                <h6 class="fw-semibold mb-0">DM Instagram</h6>
                                <p class="text-muted mb-0 fs-2">Follow dan kirim DM ke akun Instagram resmi kami.</p>
                            </div>
                            <i class="ti ti-chevron-right ms-auto text-muted"></i>
                        </div>
                    </a>

                    {{-- Opsi Email --}}
                    <a href="mailto:support@dolfinbrain.com" class="text-decoration-none">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Gmail_icon_%282020%29.svg/256px-Gmail_icon_%282020%29.svg.png"
                                alt="Email" height="40">
                            <div class="ms-3">
                                <h6 class="fw-semibold mb-0">Kirim Email</h6>
                                <p class="text-muted mb-0 fs-2">Kirim pertanyaan atau masukan melalui email resmi kami.
                                </p>
                            </div>
                            <i class="ti ti-chevron-right ms-auto text-muted"></i>
                        </div>
                    </a>
                </div>

                {{-- Kolom Kanan: Peta --}}
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div id="map" class="rounded" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    {{-- CSS untuk Leaflet JS Map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
    {{-- JS untuk Leaflet JS Map --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            // Koordinat Alun-Alun Malang
            const lat = -7.9829;
            const lng = 112.6309;

            // Inisialisasi peta
            var map = L.map('map').setView([lat, lng], 17);

            // Tambahkan layer peta dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Tambahkan penanda (marker) di lokasi
            L.marker([lat, lng]).addTo(map)
                .bindPopup('<b>Dolfin Brain HQ</b><br>Alun-Alun Malang.')
                .openPopup();
        });
    </script>
@endpush

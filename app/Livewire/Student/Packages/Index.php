<?php

namespace App\Livewire\Student\Packages;

use App\Models\Formation;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    // State untuk mengontrol alur 3 langkah
    public $step = 1; // 1: Formasi, 2: Posisi, 3: Detail Paket
    public ?Formation $selectedFormation = null;
    public ?Position $selectedPosition = null;

    // State untuk langkah ke-3 (Detail Paket)
    public $packageType = 'mandiri';
    public $mandiriPackage = [];
    public $bimbinganPackage = [];

    /**
     * Dipanggil saat pengguna memilih formasi.
     */
    public function selectFormation(Formation $formation)
    {
        $this->selectedFormation = $formation;
        $this->step = 2;
    }

    /**
     * Dipanggil saat pengguna memilih posisi.
     */
    public function selectPosition(Position $position)
    {
        $this->selectedPosition = $position;
        $this->preparePackageDetails();
        $this->step = 3;
    }

    /**
     * Menyiapkan detail paket untuk ditampilkan di langkah ke-3.
     */
    public function preparePackageDetails()
    {
        $this->mandiriPackage = [
            'name' => 'Paket Aplikasi',
            'price' => $this->selectedPosition->price_mandiri,
            'features' => [
                'Akses Materi SKD & SKB Sesuai Formasi',
                'Ribuan Soal Latihan & Pembahasan',
                'Simulasi CAT Berbasis Komputer',
                'Analisis Hasil & Peringkat Nasional',
            ],
        ];
        $this->bimbinganPackage = [
            'name' => 'Paket Bimbel',
            'price' => $this->selectedPosition->price_bimbingan,
            'features' => [
                'Semua fitur Paket Aplikasi',
                'Bimbingan Intensif via Zoom Meeting',
                'Grup Diskusi Interaktif (Mentor & Peserta)',
                'File Rekap & Rekaman Sesi Bimbingan',
                'Pendampingan oleh Mentor Profesional',
            ],
        ];
    }

    /**
     * Dipanggil oleh toggle switch di langkah ke-3.
     */
    public function selectPackageType($type)
    {
        $this->packageType = $type;
    }

    /**
     * Kembali ke langkah sebelumnya.
     */
    public function goBack()
    {
        if ($this->step == 3) {
            $this->selectedPosition = null;
            $this->step = 2;
        } elseif ($this->step == 2) {
            $this->selectedFormation = null;
            $this->step = 1;
        }
    }

    /**
     * Mengarahkan ke halaman checkout.
     */
    public function checkout()
    {
        $user = Auth::user();
        $user->position_id = $this->selectedPosition->id;
        $user->save();

        return $this->redirect(route('students.packages.checkout', ['package_type' => $this->packageType]), navigate: true);
    }

    public function getSelectedPackageProperty()
    {
        return $this->packageType === 'mandiri' ? $this->mandiriPackage : $this->bimbinganPackage;
    }

    public function render()
    {
        $formations = Formation::withCount('positions')->whereHas('positions')->get();

        return view('livewire.student.packages.index', [
            'formations' => $formations,
        ])->layout('components.layouts.app');
    }
}

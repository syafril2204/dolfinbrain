<?php

namespace App\Livewire\Student\Packages;

use App\Models\Formation;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $step = 1;
    public ?Formation $selectedFormation = null;
    public ?Position $selectedPosition = null;

    public array $mandiriPackage = [];
    public array $bimbinganPackage = [];

    // Properti baru untuk melacak kepemilikan paket
    public bool $hasMandiriPackage = false;
    public bool $hasBimbelPackage = false;

    public function selectFormation(Formation $formation)
    {
        $this->selectedFormation = $formation;
        $this->step = 2;
    }

    public function selectPosition(Position $position)
    {
        $this->selectedPosition = $position;
        $this->checkUserPackages(); // Cek paket yang sudah dimiliki
        $this->preparePackageDetails();
        $this->step = 3;
    }

    /**
     * Memeriksa paket apa saja yang sudah dimiliki pengguna untuk posisi yang dipilih.
     */
    public function checkUserPackages()
    {
        $user = Auth::user();
        $purchasedPackages = $user->purchasedPositions()
            ->where('position_id', $this->selectedPosition->id)
            ->get();

        $this->hasMandiriPackage = $purchasedPackages->contains(fn($p) => $p->pivot->package_type === 'mandiri');
        $this->hasBimbelPackage = $purchasedPackages->contains(fn($p) => $p->pivot->package_type === 'bimbingan');
    }

    /**
     * Menyiapkan detail paket, termasuk harga upgrade jika memungkinkan.
     */
    public function preparePackageDetails()
    {
        $mandiriPrice = $this->selectedPosition->price_mandiri;
        $bimbelPrice = $this->selectedPosition->price_bimbingan;
        $isUpgrade = false;

        // LOGIKA UPGRADE: Jika punya paket mandiri TAPI BELUM punya paket bimbel
        if ($this->hasMandiriPackage && !$this->hasBimbelPackage) {
            $bimbelPrice = $bimbelPrice - $mandiriPrice;
            $isUpgrade = true;
        }

        $this->mandiriPackage = [
            'price' => $mandiriPrice,
            'original_price' => $mandiriPrice * 1.8,
            'features' => [
                ['text' => 'Akses Penuh Selama 6 Bulan Tanpa Batas', 'included' => true],
                ['text' => ' Materi Paling Up-to-Date', 'included' => true],
                ['text' => 'Bonus! Fitur Simulasi Try Out', 'included' => true],
                ['text' => 'Cocok untuk Kamu yang Punya Jadwal Padat', 'included' => true],
                ['text' => 'Bimbingan Eksklusif 1-on-1', 'included' => false],
                ['text' => 'Tutor Berpengalaman & ASN Aktif', 'included' => false],
                ['text' => 'Akses Grup Belajar Premium', 'included' => false],
                ['text' => 'Konsultasi Gratis Tanpa Batas', 'included' => false],
                ['text' => 'Materi dan Rekaman Premium', 'included' => false],
                ['text' => 'Garansi Fokus Terbaik! HANYA 1 PESERTA PER INSTANSI!*', 'included' => false],
                ['text' => 'Tujuh sesi pertemuan intensif yang akan membimbingmu secara personal', 'included' => false],
            ],
        ];

        $this->bimbinganPackage = [
            'price' => max(0, $bimbelPrice), // Pastikan harga tidak negatif
            'original_price' => $this->selectedPosition->price_bimbingan * 2,
            'is_upgrade' => $isUpgrade, // Flag untuk menandai ini adalah harga upgrade
            'features' => [
                ['text' => 'Akses Penuh Selama 6 Bulan Tanpa Batas', 'included' => true],
                ['text' => ' Materi Paling Up-to-Date', 'included' => true],
                ['text' => 'Bonus! Fitur Simulasi Try Out', 'included' => true],
                ['text' => 'Cocok untuk Kamu yang Punya Jadwal Padat', 'included' => true],
                ['text' => 'Bimbingan Eksklusif 1-on-1', 'included' => true],
                ['text' => 'Tutor Berpengalaman & ASN Aktif', 'included' => true],
                ['text' => 'Akses Grup Belajar Premium', 'included' => true],
                ['text' => 'Konsultasi Gratis Tanpa Batas', 'included' => true],
                ['text' => 'Materi dan Rekaman Premium', 'included' => true],
                ['text' => 'Garansi Fokus Terbaik! HANYA 1 PESERTA PER INSTANSI!*', 'included' => true],
                ['text' => 'Tujuh sesi pertemuan intensif yang akan membimbingmu secara personal', 'included' => true],
            ],
        ];
    }

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

    public function checkout($packageType)
    {
        $user = Auth::user();
        $user->position_id = $this->selectedPosition->id;
        $user->save();
        return $this->redirect(route('students.packages.checkout', ['package_type' => $packageType]), navigate: true);
    }

    public function render()
    {
        $formations = Formation::withCount('positions')->whereHas('positions')->get();
        return view('livewire.student.packages.index', ['formations' => $formations])->layout('components.layouts.app');
    }
}

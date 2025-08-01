<?php

namespace Database\Seeders;

use App\Models\Formation;
use Illuminate\Database\Seeder;

class FormationAndPositionSeeder extends Seeder
{
    public function run(): void
    {
        $formations = [
            'Kelautan dan Perikanan' => [
                ['name' => 'Pengelola Produksi Perikanan Tangkap', 'price_mandiri' => 275000, 'price_bimbingan' => 1225000],
                ['name' => 'Asisten Pengelola Produksi', 'price_mandiri' => 250000, 'price_bimbingan' => 1100000],
                ['name' => 'Pengawas Perikanan', 'price_mandiri' => 300000, 'price_bimbingan' => 1300000],
            ],
            'Pertanian dan Ketahanan Pangan' => [
                ['name' => 'Analis Ketahanan Pangan', 'price_mandiri' => 280000, 'price_bimbingan' => 1250000],
                ['name' => 'Penyuluh Pertanian', 'price_mandiri' => 260000, 'price_bimbingan' => 1150000],
            ],
            'Kehutanan' => [
                ['name' => 'Polisi Kehutanan', 'price_mandiri' => 310000, 'price_bimbingan' => 1350000],
                ['name' => 'Penyuluh Kehutanan', 'price_mandiri' => 290000, 'price_bimbingan' => 1280000],
            ],
        ];

        foreach ($formations as $formationName => $positions) {
            $formation = Formation::create([
                'name' => $formationName,
                'short_description' => 'Materi dan soal CPNS terkait ' . strtolower($formationName),
            ]);

            foreach ($positions as $positionData) {
                $formation->positions()->create($positionData);
            }
        }
    }
}

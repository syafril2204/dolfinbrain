<?php

namespace Database\Seeders;

use App\Models\Formation;
use Illuminate\Database\Seeder;

class FormationAndPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formations = [
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

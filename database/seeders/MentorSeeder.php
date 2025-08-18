<?php

namespace Database\Seeders;

use App\Models\Mentor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mentor::create([
            'name' => 'Dr. Budi Santoso, S.Hut, M.Sc.',
            'description' => 'Ahli konservasi sumber daya hutan dengan pengalaman 10 tahun di lapangan dan sebagai peneliti di LIPI.',
            'photo' => null, // Biarkan null agar menggunakan foto default
            'position_id' => 1, // ID untuk "Polisi Kehutanan"
        ]);

        Mentor::create([
            'name' => 'Ir. Rina Wulandari',
            'description' => 'Spesialis penyuluhan kehutanan yang berfokus pada pemberdayaan masyarakat desa hutan.',
            'photo' => null,
            'position_id' => 2, // ID untuk "Penyuluh Kehutanan"
        ]);

        Mentor::create([
            'name' => 'Ahmad Prasetyo, S.Hut.',
            'description' => 'Berpengalaman dalam penegakan hukum lingkungan dan patroli pengamanan kawasan hutan lindung.',
            'photo' => null,
            'position_id' => 1, // ID untuk "Polisi Kehutanan"
        ]);
    }
}
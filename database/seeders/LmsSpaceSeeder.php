<?php

namespace Database\Seeders;

use App\Models\LmsSpace;
use Illuminate\Database\Seeder;

class LmsSpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spacePolhut = LmsSpace::create([
            'title' => 'Bimbingan Intensif Formasi Polisi Kehutanan',
            'description' => 'Ruang belajar komprehensif untuk persiapan menjadi Polisi Kehutanan. Meliputi materi pengamanan, legislasi, dan studi kasus.',
            'is_active' => true,
        ]);

        $spacePolhut->coachings()->create([
            'title' => 'Sesi 1: Teknik Investigasi Pembalakan Liar',
            'trainer_name' => 'Bapak Adi Nugroho, S.Hut',
            'meeting_url' => 'http://googleusercontent.com/meet/polhut-1',
            'start_at' => now()->addDays(7),
            'end_at' => now()->addDays(7)->addHours(2),
        ]);
        $spacePolhut->coachings()->create([
            'title' => 'Sesi 2: Praktik Penggunaan GPS dan Kompas',
            'trainer_name' => 'Ibu Rina Wulandari, M.Si',
            'meeting_url' => 'http://googleusercontent.com/meet/polhut-2',
            'start_at' => now()->addDays(14),
            'end_at' => now()->addDays(14)->addHours(2),
        ]);

        $spacePolhut->videos()->create([
            'title' => 'Rekaman: Identifikasi Satwa Dilindungi di Lapangan',
            'youtube_url' => 'http://googleusercontent.com/youtube/polhut',
            'duration' => '25 menit',
            'order' => 1,
        ]);

        $spacePolhut->resources()->create([
            'title' => 'PDF Kumpulan Undang-Undang Kehutanan',
            'file_path' => 'files/uu-kehutanan.pdf',
            'file_size' => 5000,
            'file_type' => 'pdf',
            'type' => 'recap_file'
        ]);
        $spacePolhut->resources()->create([
            'title' => 'Audio: Simulasi Komunikasi Radio di Lapangan',
            'file_path' => 'files/simulasi-radio.mp3',
            'file_size' => 7500,
            'file_type' => 'mp3',
            'type' => 'audio_recording'
        ]);

        $spacePolhut->materials()->attach(range(1, 10));
        $spacePolhut->quizPackages()->attach(1);


        $spacePenyuluh = LmsSpace::create([
            'title' => 'Bimbingan Intensif Formasi Penyuluh Kehutanan',
            'description' => 'Ruang belajar komprehensif untuk persiapan menjadi Penyuluh Kehutanan. Fokus pada pemberdayaan masyarakat dan perhutanan sosial.',
            'is_active' => true,
        ]);

        $spacePenyuluh->coachings()->create([
            'title' => 'Sesi 1: Strategi Penyuluhan Partisipatif',
            'trainer_name' => 'Dr. Budi Santoso, M.P.',
            'meeting_url' => 'http://googleusercontent.com/meet/penyuluh-1',
            'start_at' => now()->addDays(8),
            'end_at' => now()->addDays(8)->addHours(2),
        ]);
        $spacePenyuluh->coachings()->create([
            'title' => 'Sesi 2: Merancang Proposal Perhutanan Sosial',
            'trainer_name' => 'Ibu Lestari Handayani, S.Hut',
            'meeting_url' => 'http://googleusercontent.com/meet/penyuluh-2',
            'start_at' => now()->addDays(15),
            'end_at' => now()->addDays(15)->addHours(2),
        ]);

        $spacePenyuluh->videos()->create([
            'title' => 'Rekaman: Studi Kasus Keberhasilan Kelompok Tani Hutan',
            'youtube_url' => 'http://googleusercontent.com/youtube/penyuluh',
            'duration' => '30 menit',
            'order' => 1,
        ]);

        $spacePenyuluh->resources()->create([
            'title' => 'PDF Panduan Fasilitasi Masyarakat Desa Hutan',
            'file_path' => 'files/panduan-fasilitasi.pdf',
            'file_size' => 4500,
            'file_type' => 'pdf',
            'type' => 'recap_file'
        ]);
        $spacePenyuluh->resources()->create([
            'title' => 'Audio: Roleplay Teknik Public Speaking untuk Penyuluh',
            'file_path' => 'files/public-speaking.mp3',
            'file_size' => 8500,
            'file_type' => 'mp3',
            'type' => 'audio_recording'
        ]);

        // Menghubungkan materi (ID 11-20) dan kuis (ID 2)
        $spacePenyuluh->materials()->attach(range(11, 20));
        $spacePenyuluh->quizPackages()->attach(2);
    }
}

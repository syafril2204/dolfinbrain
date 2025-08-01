<?php

namespace Database\Seeders;

use App\Models\LmsSpace;
use Illuminate\Database\Seeder;

class LmsSpaceSeeder extends Seeder
{
    public function run(): void
    {
        $space1 = LmsSpace::create([
            'title' => 'Bimbingan Belajar Persiapan P3T',
            'description' => 'Deskripsi lengkap tentang bimbingan belajar P3T.',
            'is_active' => true,
        ]);

        // Menambahkan Jadwal Coaching
        $space1->coachings()->create([
            'title' => 'Sesi 1: Strategi Menjawab Soal TWK',
            'trainer_name' => 'Ibu Intan Kartika, M.Pd',
            'meeting_url' => 'http://googleusercontent.com/meet/example',
            'start_at' => now()->addDays(5),
            'end_at' => now()->addDays(5)->addHours(2),
        ]);

        // Menambahkan Video Rekaman
        $space1->videos()->create([
            'title' => 'Video Pembahasan Materi Pancasila',
            'youtube_url' => 'http://googleusercontent.com/youtube.com/6',
            'duration' => '15 menit',
            'order' => 1,
        ]);

        // Menambahkan File & Audio
        $space1->resources()->create([
            'title' => 'File Rekap Sesi 1',
            'file_path' => 'files/rekap.pdf',
            'file_size' => 1200,
            'file_type' => 'pdf',
            'type' => 'recap_file'
        ]);
        $space1->resources()->create([
            'title' => 'Audio Motivasi Belajar',
            'file_path' => 'files/audio.mp3',
            'file_size' => 5000,
            'file_type' => 'mp3',
            'type' => 'audio_recording'
        ]);

        $space1->materials()->attach([1, 2]);
        $space1->quizPackages()->attach(1);
    }
}

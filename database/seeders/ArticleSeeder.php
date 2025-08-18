<?php

namespace Database\Seeders;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data contoh untuk artikel
        $articles = [
            [
                'user_id' => 1,
                'title' => 'Materi dan Contoh Soal SKB Jabatan Penata Kelola Kelautan dan Perikanan',
                'content' => 'Ini adalah isi konten lengkap dari artikel tentang materi dan contoh soal SKB Jabatan Penata Kelola Kelautan dan Perikanan. Pembahasan mencakup berbagai aspek penting yang perlu dipelajari oleh calon peserta.',
                'image' => 'https://placehold.co/600x400/007BFF/FFFFFF/png',
                'type' => 'Artikel',
                'is_published' => true,
                'published_at' => Carbon::now()->subHours(5),
            ],
            [
                'user_id' => 1,
                'title' => 'Tips & Trik Lulus Ujian SKD CPNS 2025 Dengan Mudah',
                'content' => 'Berikut adalah tips dan trik jitu untuk lulus ujian SKD CPNS. Strategi ini telah terbukti efektif dan membantu banyak peserta untuk mencapai skor maksimal.',
                'image' => 'https://placehold.co/600x400/28A745/FFFFFF/png',
                'type' => 'Tips & Trik',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => 1,
                'title' => 'Perbedaan PNS dan PPPK yang Wajib Kamu Tahu',
                'content' => 'Sebelum mendaftar, pahami dulu perbedaan mendasar antara PNS dan PPPK agar Anda tidak salah memilih jalur karir. Artikel ini akan mengupas tuntas perbedaannya.',
                'image' => 'https://placehold.co/600x400/FFC107/000000/png',
                'type' => 'Artikel',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => 1,
                'title' => 'Panduan Lengkap Pemberkasan Setelah Lulus CPNS',
                'content' => 'Selamat bagi yang sudah lulus! Tahap selanjutnya adalah pemberkasan. Jangan sampai ada yang terlewat, ikuti panduan lengkap dalam artikel ini.',
                'image' => 'https://placehold.co/600x400/DC3545/FFFFFF/png',
                'type' => 'Tips & Trik',
                'is_published' => false,
                'published_at' => null,
            ],
        ];

        foreach ($articles as $articleData) {
            
            Article::create($articleData);
        }
    }
}
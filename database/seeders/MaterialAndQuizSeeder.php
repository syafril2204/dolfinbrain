<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Position;
use App\Models\QuizPackage;
use Illuminate\Database\Seeder;

class MaterialAndQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polhutMaterials = [
            ['title' => 'Polhut: Dasar-dasar Pengamanan Hutan', 'file_path' => 'files/dummy.pdf', 'file_size' => 3100, 'file_type' => 'pdf'],
            ['title' => 'Polhut: Legislasi dan Peraturan Kehutanan', 'file_path' => 'files/dummy.pdf', 'file_size' => 4200, 'file_type' => 'pdf'],
            ['title' => 'Polhut: Teknik Patroli dan Investigasi', 'file_path' => 'files/dummy.pdf', 'file_size' => 3500, 'file_type' => 'pdf'],
            ['title' => 'Polhut: Penanganan Tindak Pidana Kehutanan', 'file_path' => 'files/dummy.pdf', 'file_size' => 3800, 'file_type' => 'pdf'],
            ['title' => 'Polhut: Identifikasi Flora dan Fauna Dilindungi', 'file_path' => 'files/dummy.pdf', 'file_size' => 4500, 'file_type' => 'pdf'],
            ['title' => 'Polhut: Penggunaan GPS dan Pemetaan', 'file_path' => 'files/dummy.pdf', 'file_size' => 2900, 'file_type' => 'pdf'],
            ['title' => 'Polhut: Bela Diri dan Kesamaptaan', 'file_path' => 'files/dummy.pdf', 'file_size' => 3300, 'file_type' => 'pdf'],
            ['title' => 'Polhut: Komunikasi dan Laporan Kejadian', 'file_path' => 'files/dummy.pdf', 'file_size' => 2800, 'file_type' => 'pdf'],
            ['title' => 'Polhut: Konservasi Sumber Daya Alam Hayati', 'file_path' => 'files/dummy.pdf', 'file_size' => 4100, 'file_type' => 'pdf'],
            ['title' => 'Polhut: Studi Kasus Pembalakan Liar', 'file_path' => 'files/dummy.pdf', 'file_size' => 3900, 'file_type' => 'pdf'],
        ];

        $penyuluhMaterials = [
            ['title' => 'Penyuluh: Teknik Komunikasi dan Penyuluhan Efektif', 'file_path' => 'files/dummy.pdf', 'file_size' => 3200, 'file_type' => 'pdf'],
            ['title' => 'Penyuluh: Program Perhutanan Sosial', 'file_path' => 'files/dummy.pdf', 'file_size' => 3700, 'file_type' => 'pdf'],
            ['title' => 'Penyuluh: Pemberdayaan Masyarakat Desa Hutan', 'file_path' => 'files/dummy.pdf', 'file_size' => 3600, 'file_type' => 'pdf'],
            ['title' => 'Penyuluh: Pengembangan Hasil Hutan Bukan Kayu (HHBK)', 'file_path' => 'files/dummy.pdf', 'file_size' => 3400, 'file_type' => 'pdf'],
            ['title' => 'Penyuluh: Teknik Agroforestri dan Wanatani', 'file_path' => 'files/dummy.pdf', 'file_size' => 4000, 'file_type' => 'pdf'],
            ['title' => 'Penyuluh: Mitigasi dan Adaptasi Perubahan Iklim', 'file_path' => 'files/dummy.pdf', 'file_size' => 4300, 'file_type' => 'pdf'],
            ['title' => 'Penyuluh: Pembuatan Rencana Kegiatan Penyuluhan', 'file_path' => 'files/dummy.pdf', 'file_size' => 3000, 'file_type' => 'pdf'],
            ['title' => 'Penyuluh: Penilaian Keberhasilan Program Penyuluhan', 'file_path' => 'files/dummy.pdf', 'file_size' => 3100, 'file_type' => 'pdf'],
            ['title' => 'Penyuluh: Kemitraan Usaha Kehutanan', 'file_path' => 'files/dummy.pdf', 'file_size' => 3500, 'file_type' => 'pdf'],
            ['title' => 'Penyuluh: Rehabilitasi Hutan dan Lahan', 'file_path' => 'files/dummy.pdf', 'file_size' => 4200, 'file_type' => 'pdf'],
        ];

        $createdPolhutMaterials = [];
        foreach ($polhutMaterials as $material) {
            $createdPolhutMaterials[] = Material::create($material);
        }

        $createdPenyuluhMaterials = [];
        foreach ($penyuluhMaterials as $material) {
            $createdPenyuluhMaterials[] = Material::create($material);
        }

        $quizPackagePolhut = QuizPackage::create([
            'title' => 'Paket Latihan Soal Polisi Kehutanan',
            'description' => 'Paket latihan soal untuk menguji kompetensi dasar dan bidang Polisi Kehutanan.',
            'duration_in_minutes' => 120,
            'is_active' => true,
        ]);

        $questionsPolhut = [
            ['question_text' => 'Apa landasan hukum utama bagi Polisi Kehutanan di Indonesia?', 'explanation' => 'UU No. 41 Tahun 1999 tentang Kehutanan adalah dasar hukum utama yang mengatur segala aspek kehutanan, termasuk tugas dan wewenang Polhut.'],
            ['question_text' => 'Kegiatan mengangkut, menguasai, atau memiliki hasil hutan kayu yang tidak dilengkapi secara bersama surat keterangan sahnya hasil hutan disebut?', 'explanation' => 'Ini adalah definisi dari pembalakan liar atau illegal logging.'],
        ];

        foreach ($questionsPolhut as $qData) {
            $q = $quizPackagePolhut->questions()->create(['question_text' => $qData['question_text'], 'explanation' => $qData['explanation'], 'type' => 'multiple_choice']);
            $q->answers()->createMany([['answer_text' => 'Jawaban Benar A', 'is_correct' => true], ['answer_text' => 'Jawaban Salah B', 'is_correct' => false], ['answer_text' => 'Jawaban Salah C', 'is_correct' => false], ['answer_text' => 'Jawaban Salah D', 'is_correct' => false]]);
        }

        $quizPackagePenyuluh = QuizPackage::create([
            'title' => 'Paket Latihan Soal Penyuluh Kehutanan',
            'description' => 'Paket latihan soal untuk menguji kompetensi dasar dan bidang Penyuluh Kehutanan.',
            'duration_in_minutes' => 120,
            'is_active' => true,
        ]);

        $questionsPenyuluh = [
            ['question_text' => 'Metode penyuluhan yang melibatkan partisipasi aktif dari masyarakat disebut?', 'explanation' => 'Metode partisipatif menekankan keterlibatan masyarakat dalam setiap tahapan kegiatan.'],
            ['question_text' => 'Apa tujuan utama dari program Perhutanan Sosial?', 'explanation' => 'Tujuan utamanya adalah memberikan akses kelola hutan kepada masyarakat untuk meningkatkan kesejahteraan dan menjaga kelestarian hutan.'],
        ];

        foreach ($questionsPenyuluh as $qData) {
            $q = $quizPackagePenyuluh->questions()->create(['question_text' => $qData['question_text'], 'explanation' => $qData['explanation'], 'type' => 'multiple_choice']);
            $q->answers()->createMany([['answer_text' => 'Pilihan Benar A', 'is_correct' => true], ['answer_text' => 'Pilihan Salah B', 'is_correct' => false], ['answer_text' => 'Pilihan Salah C', 'is_correct' => false], ['answer_text' => 'Pilihan Salah D', 'is_correct' => false]]);
        }

        // Tugaskan materi dan kuis ke posisi yang sesuai
        $posisiPolhut = Position::where('name', 'Polisi Kehutanan')->first();
        if ($posisiPolhut) {
            $polhutMaterialIds = collect($createdPolhutMaterials)->pluck('id')->all();
            $posisiPolhut->materials()->attach($polhutMaterialIds);
            $posisiPolhut->quizPackages()->attach($quizPackagePolhut->id);
        }

        $posisiPenyuluh = Position::where('name', 'Penyuluh Kehutanan')->first();
        if ($posisiPenyuluh) {
            $penyuluhMaterialIds = collect($createdPenyuluhMaterials)->pluck('id')->all();
            $posisiPenyuluh->materials()->attach($penyuluhMaterialIds);
            $posisiPenyuluh->quizPackages()->attach($quizPackagePenyuluh->id);
        }
    }
}

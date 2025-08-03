<?php

namespace Database\Seeders;

use App\Models\Material;
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

        foreach (array_merge($polhutMaterials, $penyuluhMaterials) as $material) {
            Material::create($material);
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
            ['question_text' => 'Dalam patroli, alat yang paling umum digunakan untuk navigasi dan penandaan lokasi temuan adalah?', 'explanation' => 'GPS (Global Positioning System) sangat esensial untuk navigasi dan menandai koordinat di lapangan.'],
            ['question_text' => 'Taman Nasional adalah kawasan pelestarian alam yang mempunyai ekosistem asli dan dikelola dengan sistem...', 'explanation' => 'Sistem zonasi (zona inti, zona rimba, zona pemanfaatan) digunakan untuk mengelola Taman Nasional.'],
            ['question_text' => 'Apa yang dimaksud dengan TSL (Tumbuhan dan Satwa Liar) yang dilindungi?', 'explanation' => 'TSL yang dilindungi adalah spesies yang populasinya terancam punah dan ditetapkan oleh pemerintah untuk dilindungi.'],
            ['question_text' => 'Surat Perintah Tugas (SPT) dalam kegiatan pengamanan hutan dikeluarkan oleh?', 'explanation' => 'SPT biasanya dikeluarkan oleh pejabat yang berwenang, seperti Kepala Balai atau Kepala Dinas Kehutanan.'],
            ['question_text' => 'Fungsi utama dari hutan lindung adalah...', 'explanation' => 'Fungsi utamanya adalah perlindungan sistem penyangga kehidupan, seperti tata air, pencegahan banjir, dan pengendalian erosi.'],
            ['question_text' => 'Dalam proses penyidikan tindak pidana kehutanan, Polhut berperan sebagai?', 'explanation' => 'Polhut memiliki kewenangan sebagai Penyidik Pegawai Negeri Sipil (PPNS).'],
            ['question_text' => 'Salah satu contoh hasil hutan bukan kayu (HHBK) yang memiliki nilai ekonomi tinggi adalah?', 'explanation' => 'Rotan, madu hutan, dan getah merupakan contoh HHBK.'],
            ['question_text' => 'Prinsip dasar dalam penanganan barang bukti adalah...', 'explanation' => 'Chain of Custody atau rantai penanganan barang bukti harus terjaga untuk memastikan keaslian dan keabsahan barang bukti di pengadilan.'],
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
            ['question_text' => 'Sistem pertanian yang mengkombinasikan tanaman kehutanan dengan tanaman pertanian disebut?', 'explanation' => 'Agroforestri atau wanatani adalah sistem yang menggabungkan komponen kehutanan dan pertanian.'],
            ['question_text' => 'Media yang paling efektif untuk penyuluhan di daerah tanpa akses internet adalah?', 'explanation' => 'Media cetak seperti leaflet, brosur, atau pertemuan langsung masih sangat efektif di daerah terpencil.'],
            ['question_text' => 'Kelompok Tani Hutan (KTH) merupakan contoh dari?', 'explanation' => 'KTH adalah kelembagaan petani di tingkat tapak yang menjadi sasaran utama kegiatan penyuluhan.'],
            ['question_text' => 'Evaluasi yang dilakukan di akhir program penyuluhan untuk melihat dampaknya disebut evaluasi...', 'explanation' => 'Evaluasi ex-post atau evaluasi dampak dilakukan setelah program selesai untuk melihat hasil jangka panjang.'],
            ['question_text' => 'Apa yang dimaksud dengan HHBK?', 'explanation' => 'Hasil Hutan Bukan Kayu adalah semua hasil hayati dari hutan selain kayu, contohnya getah, rotan, madu, buah-buahan.'],
            ['question_text' => 'Salah satu tantangan utama dalam pemberdayaan masyarakat desa hutan adalah?', 'explanation' => 'Tingkat pendidikan, akses modal, dan konflik tenurial adalah beberapa tantangan utama.'],
            ['question_text' => 'Rencana kegiatan penyuluhan yang dibuat oleh seorang penyuluh untuk satu tahun ke depan disebut?', 'explanation' => 'Programa penyuluhan adalah rencana tertulis yang disusun secara sistematis.'],
            ['question_text' => 'Prinsip "Melihat, Memahami, Melakukan" adalah inti dari metode penyuluhan?', 'explanation' => 'Ini adalah inti dari metode Sekolah Lapang (SL) yang berfokus pada pembelajaran dari pengalaman langsung.'],
        ];

        foreach ($questionsPenyuluh as $qData) {
            $q = $quizPackagePenyuluh->questions()->create(['question_text' => $qData['question_text'], 'explanation' => $qData['explanation'], 'type' => 'multiple_choice']);
            $q->answers()->createMany([['answer_text' => 'Pilihan Benar A', 'is_correct' => true], ['answer_text' => 'Pilihan Salah B', 'is_correct' => false], ['answer_text' => 'Pilihan Salah C', 'is_correct' => false], ['answer_text' => 'Pilihan Salah D', 'is_correct' => false]]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\QuizPackage;
use Illuminate\Database\Seeder;

class MaterialAndQuizSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            ['title' => 'TWK: Pancasila dan UUD 1945', 'file_path' => 'files/dummy.pdf', 'file_size' => 2800, 'file_type' => 'pdf'],
            ['title' => 'TWK: Sejarah Perjuangan Bangsa', 'file_path' => 'files/dummy.pdf', 'file_size' => 3200, 'file_type' => 'pdf'],
            ['title' => 'TIU: Logika Matematika Dasar', 'file_path' => 'files/dummy.pdf', 'file_size' => 2500, 'file_type' => 'pdf'],
            ['title' => 'TIU: Deret Angka dan Pola Bilangan', 'file_path' => 'files/dummy.pdf', 'file_size' => 2900, 'file_type' => 'pdf'],
        ];
        foreach ($materials as $material) {
            Material::create($material);
        }

        // Membuat Paket Kuis beserta Soal dan Jawabannya
        $quizPackage = QuizPackage::create([
            'title' => 'Paket 1 P3T',
            'description' => 'Paket Latihan 1 untuk Pengelola Produksi Perikanan Tangkap.',
            'duration_in_minutes' => 90,
            'is_active' => true,
        ]);

        $question1 = $quizPackage->questions()->create([
            'question_text' => 'Apa dasar negara Republik Indonesia?',
            'explanation' => 'Dasar negara Indonesia adalah Pancasila, yang tercantum dalam Pembukaan UUD 1945.',
            'type' => 'multiple_choice',
        ]);
        $question1->answers()->createMany([
            ['answer_text' => 'Pancasila', 'is_correct' => true],
            ['answer_text' => 'UUD 1945', 'is_correct' => false],
            ['answer_text' => 'Bhinneka Tunggal Ika', 'is_correct' => false],
            ['answer_text' => 'Tap MPR', 'is_correct' => false],
        ]);

        $question2 = $quizPackage->questions()->create([
            'question_text' => 'Siapakah presiden pertama Indonesia?',
            'explanation' => 'Ir. Soekarno adalah proklamator kemerdekaan sekaligus presiden pertama Republik Indonesia.',
            'type' => 'multiple_choice',
        ]);
        $question2->answers()->createMany([
            ['answer_text' => 'Soeharto', 'is_correct' => false],
            ['answer_text' => 'B.J. Habibie', 'is_correct' => false],
            ['answer_text' => 'Soekarno', 'is_correct' => true],
            ['answer_text' => 'Mohammad Hatta', 'is_correct' => false],
        ]);
    }
}

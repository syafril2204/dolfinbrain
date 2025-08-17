<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\QuizPackage;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class QuestionsImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $quizPackage;

    public function __construct(QuizPackage $quizPackage)
    {
        $this->quizPackage = $quizPackage;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $question = Question::create([
                'quiz_package_id' => $this->quizPackage->id,
                'question_text' => $row['soal'],
                'explanation' => $row['pembahasan'],
                // Kolom 'gambar' diabaikan untuk saat ini, bisa dikembangkan lebih lanjut
            ]);

            $options = ['a', 'b', 'c', 'd', 'e'];
            foreach ($options as $option) {
                if (isset($row[strtolower($option)]) && !empty($row[strtolower($option)])) {
                    $question->answers()->create([
                        'answer_text' => $row[strtolower($option)],
                        'is_correct' => (strtolower($row['kunci_jawaban']) == $option),
                    ]);
                }
            }
        }
    }

    public function rules(): array
    {
        return [
            'soal' => 'required|string',
            'a' => 'required|string',
            'b' => 'required|string',
            'kunci_jawaban' => 'required|string|in:A,B,C,D,E,a,b,c,d,e',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'soal.required' => 'Kolom "soal" tidak boleh kosong pada baris :row.',
            'a.required' => 'Kolom "a" tidak boleh kosong pada baris :row.',
            'b.required' => 'Kolom "b" tidak boleh kosong pada baris :row.',
            'kunci_jawaban.required' => 'Kolom "kunci_jawaban" tidak boleh kosong pada baris :row.',
            'kunci_jawaban.in' => 'Kolom "kunci_jawaban" harus berisi A, B, C, D, atau E pada baris :row.',
        ];
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuestionTemplateExport implements WithHeadings, ShouldAutoSize
{
    /**
     * Menentukan judul header untuk setiap kolom di file template Excel.
     */
    public function headings(): array
    {
        return [
            'No',
            'Soal',
            'Gambar',
            'A',
            'B',
            'C',
            'D',
            'E',
            'Pembahasan',
            'kunci_jawaban',
        ];
    }
}

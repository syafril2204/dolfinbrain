<?php

namespace App\Livewire\Admin\Quiz\Questions;

use App\Exports\QuestionTemplateExport;
use App\Models\Question;
use App\Models\QuizPackage;
use App\Imports\QuestionsImport;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public QuizPackage $quiz_package;
    public $importFile;
    public array $importErrors = [];

    public function mount(QuizPackage $quiz_package)
    {
        $this->quiz_package = $quiz_package;
    }

    public function delete(Question $question)
    {
        $question->delete();
        session()->flash('message', 'Soal berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        return Excel::download(new QuestionTemplateExport(), 'format-import-soal.xlsx');
    }

    /**
     * Method untuk memproses file Excel yang diunggah.
     */
    public function importExcel()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls,csv'
        ]);

        $this->importErrors = [];

        try {
            Excel::import(new QuestionsImport($this->quiz_package), $this->importFile);

            session()->flash('message', 'Soal berhasil diimpor!');
            $this->importFile = null; // Kosongkan input file setelah berhasil

        } catch (ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                // Format pesan error agar lebih mudah dibaca
                $this->importErrors[] = 'Kesalahan di baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
        } catch (\Exception $e) {
            // Menangkap error umum lainnya
            $this->importErrors[] = 'Terjadi kesalahan yang tidak terduga saat memproses file. Pastikan format file sudah benar. Pesan: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.admin.quiz.questions.index', [
            'questions' => $this->quiz_package->questions()->with('answers')->paginate(10)
        ])->layout('components.layouts.app');
    }
}

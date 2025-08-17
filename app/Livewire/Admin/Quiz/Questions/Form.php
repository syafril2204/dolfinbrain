<?php

namespace App\Livewire\Admin\Quiz\Questions;

use App\Models\Question;
use App\Models\QuizPackage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public QuizPackage $quiz_package;
    public ?Question $question = null;

    public $question_text = '';
    public $explanation = '';
    public $answers = [];
    public $correctAnswerIndex = null; // Diubah ke null untuk state awal yang lebih jelas
    public $isEditMode = false;
    public $image;
    public $existingImageUrl = null;

    protected function rules()
    {
        return [
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
            'image' => 'nullable|image', // Maks 1MB
            'answers.*.answer_text' => 'required|string', // [FIX] Key disamakan menjadi 'answer_text'
            'correctAnswerIndex' => 'required|integer|between:0,4',
        ];
    }

    protected function messages()
    {
        $messages = [
            'question_text.required' => 'Teks soal tidak boleh kosong.',
            'correctAnswerIndex.required' => 'Anda harus memilih satu jawaban benar.',
        ];
        foreach ($this->answers as $index => $answer) {
            // [FIX] Key disamakan menjadi 'answer_text'
            $messages["answers.{$index}.answer_text.required"] = 'Pilihan jawaban ' . ($index + 1) . ' tidak boleh kosong.';
        }
        return $messages;
    }

    // [FIX] Method mount disederhanakan untuk langsung menerima model
    public function mount(QuizPackage $quiz_package, $question = null)
    {
        $this->quiz_package = $quiz_package;

        if ($question) {
            $this->isEditMode = true;
            $this->question = $question;
            $this->question_text = $question->question_text;
            $this->explanation = $question->explanation;
            $this->existingImageUrl = $question->image;

            foreach ($question->answers as $index => $answer) {
                // [FIX] Key disamakan menjadi 'answer_text'
                $this->answers[$index] = ['answer_text' => $answer->answer_text];
                if ($answer->is_correct) {
                    $this->correctAnswerIndex = $index;
                }
            }
        } else {
            // Inisialisasi 5 jawaban kosong untuk form create
            for ($i = 0; $i < 5; $i++) {
                $this->answers[] = ['answer_text' => ''];
            }
        }
    }

    public function store()
    {
        $this->validate();

        $data = [
            'quiz_package_id' => $this->quiz_package->id,
            'question_text' => $this->question_text,
            'explanation' => $this->explanation,
        ];

        if ($this->image) {
            if ($this->isEditMode && $this->question->image) {
                Storage::disk('public')->delete($this->question->image);
            }
            $data['image'] = $this->image->store('questions', 'public');
        }

        if ($this->isEditMode) {
            $this->question->update($data);
            $this->question->answers()->delete(); // Hapus jawaban lama untuk diganti
        } else {
            $this->question = Question::create($data);
        }

        foreach ($this->answers as $index => $answer) {
            $this->question->answers()->create([
                'answer_text' => $answer['answer_text'],
                'is_correct' => ($this->correctAnswerIndex == $index),
            ]);
        }

        session()->flash('message', 'Soal berhasil disimpan.');
        return $this->redirectRoute('admin.quiz-packages.questions.index', $this->quiz_package);
    }

    public function render()
    {
        return view('livewire.admin.quiz.questions.form')
            ->layout('components.layouts.app');
    }
}

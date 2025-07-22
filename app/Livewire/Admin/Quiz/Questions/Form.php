<?php

namespace App\Livewire\Admin\Quiz\Questions;

use App\Models\Question;
use App\Models\QuizPackage;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    public QuizPackage $quiz_package;
    public ?Question $question = null;

    public $question_text = '';
    public $explanation = '';
    public $answers = [];
    public $correctAnswerIndex = 0;
    public $isEditMode = false;

    protected function rules()
    {
        return [
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
            'answers.*.text' => 'required|string',
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
            $messages["answers.{$index}.text.required"] = 'Pilihan jawaban ' . ($index + 1) . ' tidak boleh kosong.';
        }
        return $messages;
    }

    /**
     * PERBAIKAN UTAMA:
     * Samakan nama argumen ($quiz_package, $question) dengan
     * nama parameter di route ({quiz_package}, {question})
     */
    public function mount($quiz_package, $question = null)
    {
        $this->quiz_package = QuizPackage::findOrFail($quiz_package->id);

        if ($question) {
            $this->isEditMode = true;
            $this->question = Question::with('answers')->findOrFail($question->id);
            $this->question_text = $this->question->question_text;
            $this->explanation = $this->question->explanation;

            foreach ($this->question->answers as $index => $answer) {
                $this->answers[$index] = ['text' => $answer->answer_text];
                if ($answer->is_correct) {
                    $this->correctAnswerIndex = $index;
                }
            }
        }

        $this->initializeAnswers();
    }

    public function initializeAnswers()
    {
        for ($i = 0; $i < 5; $i++) {
            if (!isset($this->answers[$i])) {
                $this->answers[$i] = ['text' => ''];
            }
        }
    }

    public function store()
    {
        $this->validate();

        DB::transaction(function () {
            $questionData = [
                'quiz_package_id' => $this->quiz_package->id,
                'question_text' => $this->question_text,
                'explanation' => $this->explanation,
            ];

            if ($this->isEditMode) {
                $this->question->update($questionData);
                $this->question->answers()->delete();
            } else {
                $this->question = Question::create($questionData);
            }

            foreach ($this->answers as $index => $answerData) {
                $this->question->answers()->create([
                    'answer_text' => $answerData['text'],
                    'is_correct' => ($index == $this->correctAnswerIndex),
                ]);
            }
        });

        session()->flash('message', 'Soal berhasil disimpan.');
        return $this->redirectRoute('admin.quiz-packages.questions.index', ['quiz_package' => $this->quiz_package->id]);
    }

    public function render()
    {
        return view('livewire.admin.quiz.questions.form')
            ->layout('components.layouts.app');
    }
}

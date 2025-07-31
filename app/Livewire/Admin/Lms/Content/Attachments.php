<?php

namespace App\Livewire\Admin\Lms\Content;

use App\Models\LmsSpace;
use App\Models\Material;
use App\Models\QuizPackage;
use Livewire\Component;

class Attachments extends Component
{
    public LmsSpace $lms_space;
    public $activeTab = 'materials';
    protected $queryString = ['activeTab' => ['except' => 'materials', 'as' => 'tab']];
    public $selectedMaterials = [];
    public $selectedQuizzes = [];

    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
        $this->selectedMaterials = $lms_space->materials()->pluck('id')->toArray();
        $this->selectedQuizzes = $lms_space->quizPackages()->pluck('id')->toArray();
    }

    public function switchTab($tabName)
    {
        $this->activeTab = $tabName;
    }

    public function saveMaterials()
    {
        $this->lms_space->materials()->sync($this->selectedMaterials);
        session()->flash('message', 'Daftar materi berhasil diperbarui.');
    }

    public function saveQuizzes()
    {
        $this->lms_space->quizPackages()->sync($this->selectedQuizzes);
        session()->flash('message', 'Daftar kuis berhasil diperbarui.');
    }

    public function render()
    {
        $attachedMaterials = Material::whereIn('id', $this->selectedMaterials)->get();
        $attachedQuizzes = QuizPackage::whereIn('id', $this->selectedQuizzes)->get();

        return view('livewire.admin.lms.content.attachments', [
            'allMaterials' => Material::all(),
            'allQuizzes' => QuizPackage::all(),
            'attachedMaterials' => $attachedMaterials, 
            'attachedQuizzes' => $attachedQuizzes,   
        ])->layout('components.layouts.app');
    }
}

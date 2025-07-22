<?php

namespace App\Livewire\Admin\Quiz\Packages;

use App\Models\QuizPackage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $packages = QuizPackage::latest()->paginate(10);
        return view('livewire.admin.quiz.packages.index', [
            'packages' => $packages
        ])->layout('components.layouts.app');
    }

    public function delete(QuizPackage $quizPackage)
    {
        $quizPackage->delete();
        session()->flash('message', 'Paket kuis berhasil dihapus.');
    }
}

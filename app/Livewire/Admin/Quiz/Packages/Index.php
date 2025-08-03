<?php

namespace App\Livewire\Admin\Quiz\Packages;

use App\Models\Formation;
use App\Models\Position;
use App\Models\QuizPackage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedFormation = '';
    public $selectedPosition = '';

    public function updatedSelectedFormation()
    {
        $this->selectedPosition = '';
        $this->resetPage();
    }

    public function updatedSelectedPosition()
    {
        $this->resetPage();
    }

    public function render()
    {
        $formations = Formation::all();
        $positions = collect();

        if ($this->selectedFormation) {
            $positions = Position::where('formation_id', $this->selectedFormation)->get();
        }

        $packagesQuery = QuizPackage::query();

        if ($this->selectedPosition) {
            $packagesQuery->whereHas('positions', function ($query) {
                $query->where('position_id', $this->selectedPosition);
            });
        }
        elseif ($this->selectedFormation) {
            $packagesQuery->whereHas('positions', function ($query) {
                $query->where('formation_id', $this->selectedFormation);
            });
        }

        $packages = $packagesQuery->latest()->paginate(10);

        return view('livewire.admin.quiz.packages.index', [
            'packages' => $packages,
            'formations' => $formations,
            'positions' => $positions,
        ])->layout('components.layouts.app');
    }

    public function delete(QuizPackage $quizPackage)
    {
        $quizPackage->delete();
        session()->flash('message', 'Paket kuis berhasil dihapus.');
    }
}

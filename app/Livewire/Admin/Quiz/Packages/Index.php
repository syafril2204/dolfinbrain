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

    public ?Formation $currentFormation = null;
    public ?Position $currentPosition = null;
    public array $breadcrumbs = [];

    public function mount()
    {
        $this->updateBreadcrumbs();
    }

    public function selectFormation($formationId)
    {
        $this->currentFormation = Formation::findOrFail($formationId);
        $this->currentPosition = null;
        $this->resetPage();
        $this->updateBreadcrumbs();
    }

    public function selectPosition($positionId)
    {
        $this->currentPosition = Position::findOrFail($positionId);
        $this->resetPage();
        $this->updateBreadcrumbs();
    }

    public function goToBreadcrumb($level)
    {
        if ($level === 0) {
            $this->currentFormation = null;
            $this->currentPosition = null;
        } elseif ($level === 1) {
            $this->currentPosition = null;
        }
        $this->resetPage();
        $this->updateBreadcrumbs();
    }

    private function updateBreadcrumbs()
    {
        $this->breadcrumbs = [];
        $this->breadcrumbs[] = ['label' => 'Paket Kuis', 'level' => 0];

        if ($this->currentFormation) {
            $this->breadcrumbs[] = ['label' => $this->currentFormation->name, 'level' => 1];
        }

        if ($this->currentPosition) {
            $this->breadcrumbs[] = ['label' => $this->currentPosition->name, 'level' => 2];
        }
    }

    public function deletePackage(QuizPackage $quiz_package)
    {
        $quiz_package->delete();
        session()->flash('message', 'Paket kuis berhasil dihapus.');
    }

    public function render()
    {
        $data = [];

        if ($this->currentPosition) {
            $data['items'] = $this->currentPosition->quizPackages()->paginate(10);
        } elseif ($this->currentFormation) {
            $data['items'] = $this->currentFormation->positions()->get();
        } else {
            $data['items'] = Formation::all();
        }

        return view('livewire.admin.quiz.packages.index', $data)
            ->layout('components.layouts.app');
    }
}

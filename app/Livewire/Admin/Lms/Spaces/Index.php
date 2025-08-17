<?php

namespace App\Livewire\Admin\Lms\Spaces;

use App\Models\Formation;
use App\Models\LmsSpace;
use App\Models\Position;
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
        $this->breadcrumbs[] = ['label' => 'LMS Space', 'level' => 0];

        if ($this->currentFormation) {
            $this->breadcrumbs[] = ['label' => $this->currentFormation->name, 'level' => 1];
        }

        if ($this->currentPosition) {
            $this->breadcrumbs[] = ['label' => $this->currentPosition->name, 'level' => 2];
        }
    }

    public function deleteSpace(LmsSpace $lms_space)
    {
        $lms_space->delete();
        session()->flash('message', 'LMS Space berhasil dihapus.');
    }

    public function render()
    {
        $data = [];

        if ($this->currentPosition) {
            $data['items'] = $this->currentPosition->lmsSpaces()->paginate(10);
        } elseif ($this->currentFormation) {
            $data['items'] = $this->currentFormation->positions()->get();
        } else {
            $data['items'] = Formation::all();
        }

        return view('livewire.admin.lms.spaces.index', $data)
            ->layout('components.layouts.app');
    }
}

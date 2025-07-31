<?php

namespace App\Livewire\Student\Packages;

use App\Models\Formation;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public ?Position $currentPosition;

    public $isModalOpen = false;
    public $formations;
    public $selectedFormation = null;
    public $new_position_id = null;
    public $step = 1;

    public function mount()
    {
        $this->loadCurrentPosition();
    }

    public function loadCurrentPosition()
    {
        $user = Auth::user();
        if ($user->position_id) {
            $this->currentPosition = Position::with('formation')->find($user->position_id);
        } else {
            $this->currentPosition = null;
        }
    }

    public function openChangePositionModal()
    {
        $this->formations = Formation::with('positions')->get();
        $this->step = 1;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->selectedFormation = null;
        $this->new_position_id = null;
    }

    public function selectFormation($formationId)
    {
        $this->selectedFormation = Formation::with('positions')->find($formationId);
        $this->step = 2;
    }

    public function backToFormationSelection()
    {
        $this->selectedFormation = null;
        $this->step = 1;
    }

    public function changePosition()
    {
        $this->validate(['new_position_id' => 'required|exists:positions,id']);

        $user = Auth::user();
        $user->position_id = $this->new_position_id;
        $user->save();

        $this->closeModal();
        $this->loadCurrentPosition();
        $this->dispatch('position-changed', 'Jabatan berhasil diubah!');
    }

    public function render()
    {
        return view('livewire.student.packages.index')
            ->layout('components.layouts.app');
    }
}

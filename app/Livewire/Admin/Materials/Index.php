<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Formation;
use App\Models\Material;
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
        $this->currentPosition = null; // Reset posisi saat formasi dipilih
        $this->resetPage(); // Reset paginasi
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
        $this->breadcrumbs[] = ['label' => 'Materi', 'level' => 0];

        if ($this->currentFormation) {
            $this->breadcrumbs[] = ['label' => $this->currentFormation->name, 'level' => 1];
        }

        if ($this->currentPosition) {
            $this->breadcrumbs[] = ['label' => $this->currentPosition->name, 'level' => 2];
        }
    }

    public function deleteMaterial(Material $material)
    {
        // Logika hapus materi (jika ada file terkait, hapus juga)
        $material->delete();
        session()->flash('message', 'Materi berhasil dihapus.');
    }

    public function render()
    {
        $data = [];

        if ($this->currentPosition) {
            // Level 3: Tampilkan Materi
            $data['items'] = $this->currentPosition->materials()->paginate(10);
        } elseif ($this->currentFormation) {
            // Level 2: Tampilkan Posisi
            $data['items'] = $this->currentFormation->positions()->get();
        } else {
            // Level 1: Tampilkan Formasi
            $data['items'] = Formation::all();
        }

        return view('livewire.admin.materials.index', $data)
            ->layout('components.layouts.app');
    }
}

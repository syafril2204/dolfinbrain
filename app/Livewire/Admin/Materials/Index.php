<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Formation;
use App\Models\Material;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $searchTerm = '';

    // Properti baru untuk filter
    public $selectedFormation = '';
    public $selectedPosition = '';

    // Properti untuk modal detail
    public $isDetailModalOpen = false;
    public ?Material $selectedMaterial = null;

    // Reset halaman saat filter atau pencarian berubah
    public function updating()
    {
        $this->resetPage();
    }

    // Reset filter jabatan jika formasi diubah
    public function updatedSelectedFormation()
    {
        $this->reset('selectedPosition');
    }

    public function render()
    {
        $formations = Formation::all();
        $positions = collect();

        // Jika sebuah formasi dipilih, ambil jabatannya
        if ($this->selectedFormation) {
            $positions = Position::where('formation_id', $this->selectedFormation)->get();
        }

        // Mulai query materi
        $materialsQuery = Material::query()->with('positions.formation');

        // Terapkan filter berdasarkan jabatan
        if ($this->selectedPosition) {
            $materialsQuery->whereHas('positions', function ($query) {
                $query->where('position_id', $this->selectedPosition);
            });
        }
        // Jika hanya formasi yang dipilih, filter berdasarkan semua jabatan di formasi itu
        elseif ($this->selectedFormation) {
            $materialsQuery->whereHas('positions', function ($query) {
                $query->where('formation_id', $this->selectedFormation);
            });
        }

        // Terapkan filter pencarian
        $materialsQuery->where('title', 'like', '%' . $this->searchTerm . '%');

        $materials = $materialsQuery->latest()->paginate(12);

        return view('livewire.admin.materials.index', [
            'materials' => $materials,
            'formations' => $formations,
            'positions' => $positions,
        ])->layout('components.layouts.app');
    }

    public function showDetail(Material $material)
    {
        $this->selectedMaterial = $material->load('positions.formation');
        $this->isDetailModalOpen = true;
    }

    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->selectedMaterial = null;
    }

    public function delete(Material $material)
    {
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();
        session()->flash('message', 'Materi berhasil dihapus.');
    }
}

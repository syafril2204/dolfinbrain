<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Material;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $searchTerm = '';

    public $isDetailModalOpen = false;
    public ?Material $selectedMaterial = null;

    /**
     * Render the component.
     */
    public function render()
    {
        $materials = Material::where('title', 'like', '%' . $this->searchTerm . '%')
            ->latest()
            ->paginate(12);

        return view('livewire.admin.materials.index', [
            'materials' => $materials,
        ])->layout('components.layouts.app');
    }

    /**
     * Menampilkan modal dengan detail materi yang dipilih.
     */
    public function showDetail(Material $material)
    {
        // Muat relasi positions dan formation agar bisa diakses di modal
        $this->selectedMaterial = $material->load('positions.formation');
        $this->isDetailModalOpen = true;
    }

    /**
     * Menutup modal detail.
     */
    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->selectedMaterial = null;
    }

    /**
     * Menghapus materi dari database dan filenya dari storage.
     */
    public function delete(Material $material)
    {
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();
        session()->flash('message', 'Materi berhasil dihapus.');
    }
}

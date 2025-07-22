<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Material;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    public $searchTerm = '';

    public function render()
    {
        $materials = Material::with('positions')
            ->where('title', 'like', '%' . $this->searchTerm . '%')
            ->latest()
            ->get();

        return view('livewire.admin.materials.index', [
            'materials' => $materials,
        ])->layout('components.layouts.app');
    }

    public function delete(Material $material)
    {
        if ($material->file_path && Storage::exists($material->file_path)) {
            Storage::delete($material->file_path);
        }

        $material->delete();
        session()->flash('message', 'Materi berhasil dihapus.');
    }
}

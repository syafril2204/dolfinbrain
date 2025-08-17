<?php

namespace App\Livewire\Admin\Formations;

use App\Models\Formation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads; // <-- Import trait
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithFileUploads; // <-- Gunakan trait

    public $isModalOpen = false;
    public $isEditMode = false;
    public ?Formation $formation = null;

    // Properti form
    public $name, $short_description;
    public $image; // <-- Properti untuk file upload
    public $existingImageUrl = null; // <-- Untuk menampilkan gambar lama saat edit

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'image' => 'required|image', // Validasi gambar, maks 1MB
        ];

        // Validasi 'name' harus unik, kecuali untuk data yang sedang diedit
        if ($this->isEditMode) {
            $rules['name'] .= ',' . $this->formation->id;
        } else {
            $rules['name'] .= '|unique:formations';
        }

        return $rules;
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->isModalOpen = true;
    }

    public function edit(Formation $formation)
    {
        $this->formation = $formation;
        $this->name = $formation->name;
        $this->short_description = $formation->short_description;
        $this->existingImageUrl = $formation->image; // Ambil path gambar lama
        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'short_description' => $this->short_description,
            'slug' => Str::slug($this->name),
        ];

        // Logika untuk menyimpan gambar
        if ($this->image) {
            if ($this->isEditMode && $this->formation->image) {
                Storage::disk('public')->delete($this->formation->image);
            }
            $data['image'] = $this->image->store('formations', 'public');
        }

        if ($this->isEditMode) {
            $this->formation->update($data);
        } else {
            Formation::create($data);
        }

        session()->flash('message', 'Data formasi berhasil disimpan.');
        $this->closeModal();
    }

    public function delete(Formation $formation)
    {
        if ($formation->image && Storage::disk('public')->exists($formation->image)) {
            Storage::disk('public')->delete($formation->image);
        }
        $formation->delete();
        session()->flash('message', 'Formasi berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->formation = null;
        $this->name = '';
        $this->short_description = '';
        $this->image = null;
        $this->existingImageUrl = null;
    }

    public function render()
    {
        return view('livewire.admin.formations.index', [
            'formations' => Formation::latest()->paginate(10),
        ])->layout('components.layouts.app');
    }
}

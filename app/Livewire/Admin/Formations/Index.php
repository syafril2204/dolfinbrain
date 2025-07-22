<?php

namespace App\Livewire\Admin\Formations;

use App\Models\Formation;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Properti untuk form
    public $name, $short_description;
    public $formation_id;

    // Properti untuk modal
    public $isModalOpen = false;
    public $isEditMode = false;

    // Aturan validasi
    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255|unique:formations,name',
            'short_description' => 'required|string|max:255',
        ];

        if ($this->isEditMode) {
            $rules['name'] = 'required|string|max:255|unique:formations,name,' . $this->formation_id;
        }

        return $rules;
    }

    public function render()
    {
        $formations = Formation::latest()->paginate(10);
        return view('livewire.admin.formations.index', [
            'formations' => $formations,
        ])->layout('components.layouts.app'); // Menggunakan layout utama Anda
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->short_description = '';
        $this->formation_id = null;
        $this->isEditMode = false;
    }

    public function create()
    {
        $this->resetForm();
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        Formation::updateOrCreate(['id' => $this->formation_id], [
            'name' => $this->name,
            'short_description' => $this->short_description,
            'slug' => Str::slug($this->name),
        ]);

        session()->flash('message', $this->formation_id ? 'Formation berhasil diperbarui.' : 'Formation berhasil dibuat.');
        $this->closeModal();
    }

    public function edit(Formation $formation)
    {
        $this->formation_id = $formation->id;
        $this->name = $formation->name;
        $this->short_description = $formation->short_description;
        $this->isEditMode = true;
        $this->openModal();
    }

    public function delete(Formation $formation)
    {
        $formation->delete();
        session()->flash('message', 'Formation berhasil dihapus.');
    }
}

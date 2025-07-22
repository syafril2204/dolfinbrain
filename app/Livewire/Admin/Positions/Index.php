<?php

namespace App\Livewire\Admin\Positions;

use App\Models\Formation;
use App\Models\Position;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    public Formation $formation;

    // Properti form
    public $name;
    public $position_id;

    // Properti modal
    public $isModalOpen = false;
    public $isEditMode = false;

    // Aturan validasi
    protected function rules()
    {
        return ['name' => 'required|string|max:255'];
    }

    // Lifecycle hook untuk menerima data dari route
    public function mount(Formation $formation)
    {
        $this->formation = $formation;
    }

    public function render()
    {
        return view('livewire.admin.positions.index', [
            'positions' => $this->formation->positions()->latest()->get()
        ])->layout('components.layouts.app');
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
        $this->position_id = null;
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

        $this->formation->positions()->updateOrCreate(['id' => $this->position_id], [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        session()->flash('message', $this->position_id ? 'Posisi berhasil diperbarui.' : 'Posisi berhasil dibuat.');
        $this->closeModal();
    }

    public function edit(Position $position)
    {
        $this->position_id = $position->id;
        $this->name = $position->name;
        $this->isEditMode = true;
        $this->openModal();
    }

    public function delete(Position $position)
    {
        $position->delete();
        session()->flash('message', 'Posisi berhasil dihapus.');
    }
}

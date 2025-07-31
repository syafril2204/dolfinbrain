<?php

namespace App\Livewire\Admin\Positions;

use App\Models\Formation;
use App\Models\Position;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    public Formation $formation;

    public $name;
    public $price = 0;
    public $position_id;

    public $isModalOpen = false;
    public $isEditMode = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Nama posisi tidak boleh kosong.',
            'price.required' => 'Harga harus diisi.',
            'price.integer' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
        ];
    }

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
        $this->price = 0;
        $this->position_id = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
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
            'price' => $this->price,
        ]);

        session()->flash('message', $this->position_id ? 'Posisi berhasil diperbarui.' : 'Posisi berhasil dibuat.');
        $this->closeModal();
    }

    public function edit(Position $position)
    {
        $this->position_id = $position->id;
        $this->name = $position->name;
        $this->price = $position->price;
        $this->isEditMode = true;
        $this->openModal();
    }

    public function delete(Position $position)
    {
        $position->delete();
        session()->flash('message', 'Posisi berhasil dihapus.');
    }
}

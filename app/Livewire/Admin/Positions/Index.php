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
    public $price_mandiri = 0;
    public $price_bimbingan = 0;
    public $position_id;

    public $isModalOpen = false;
    public $isEditMode = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price_mandiri' => 'required|integer|min:0',
            'price_bimbingan' => 'required|integer|min:0',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Nama Jabatan tidak boleh kosong.',
            'price_mandiri.required' => 'Harga Paket Mandiri harus diisi.',
            'price_mandiri.integer' => 'Harga Paket Mandiri harus berupa angka.',
            'price_mandiri.min' => 'Harga Paket Mandiri tidak boleh negatif.',
            'price_bimbingan.required' => 'Harga Paket Bimbingan harus diisi.',
            'price_bimbingan.integer' => 'Harga Paket Bimbingan harus berupa angka.',
            'price_bimbingan.min' => 'Harga Paket Bimbingan tidak boleh negatif.',
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
        $this->price_mandiri = 0;
        $this->price_bimbingan = 0;
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
            'price_mandiri' => $this->price_mandiri,
            'price_bimbingan' => $this->price_bimbingan,
        ]);

        session()->flash('message', $this->position_id ? 'Jabatan berhasil diperbarui.' : 'Jabatan berhasil dibuat.');
        $this->closeModal();
    }

    public function edit(Position $position)
    {
        $this->position_id = $position->id;
        $this->name = $position->name;
        $this->price_mandiri = $position->price_mandiri;
        $this->price_bimbingan = $position->price_bimbingan;
        $this->isEditMode = true;
        $this->openModal();
    }

    public function delete(Position $position)
    {
        $position->delete();
        session()->flash('message', 'Jabatan berhasil dihapus.');
    }
}

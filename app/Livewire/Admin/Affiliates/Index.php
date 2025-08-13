<?php

namespace App\Livewire\Admin\Affiliates;

use App\Models\Affiliate;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Properti untuk form
    public $name, $code;
    public ?Affiliate $editingAffiliate = null;
    public $isModalOpen = false;

    // Properti untuk modal detail
    public ?Affiliate $viewingAffiliate = null;
    public $isDetailModalOpen = false;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:affiliates,code',
        ];

        if ($this->editingAffiliate) {
            $rules['code'] .= ',' . $this->editingAffiliate->id;
        }
        return $rules;
    }

    public function create()
    {
        $this->resetForm();
        $this->code = strtoupper(Str::random(8)); // Buat kode acak
        $this->isModalOpen = true;
    }

    public function edit(Affiliate $affiliate)
    {
        $this->resetForm();
        $this->editingAffiliate = $affiliate;
        $this->name = $affiliate->name;
        $this->code = $affiliate->code;
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();
        Affiliate::updateOrCreate(['id' => $this->editingAffiliate?->id], [
            'name' => $this->name,
            'code' => $this->code,
        ]);
        session()->flash('message', 'Affiliator berhasil disimpan.');
        $this->closeModal();
    }

    public function showDetail(Affiliate $affiliate)
    {
        $this->viewingAffiliate = $affiliate->load('transactions.user');
        $this->isDetailModalOpen = true;
    }

    public function delete(Affiliate $affiliate)
    {
        $affiliate->delete();
        session()->flash('message', 'Affiliator berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->isDetailModalOpen = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['name', 'code', 'editingAffiliate', 'viewingAffiliate']);
        $this->resetErrorBag();
    }

    public function render()
    {
        $affiliates = Affiliate::withCount('transactions')->latest()->paginate(10);
        return view('livewire.admin.affiliates.index', [
            'affiliates' => $affiliates,
        ])->layout('components.layouts.app');
    }
}

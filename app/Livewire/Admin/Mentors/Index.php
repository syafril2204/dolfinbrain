<?php

namespace App\Livewire\Admin\Mentors;

use App\Models\Mentor;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $isModalOpen = false;
    public $isEditMode = false;
    public ?Mentor $mentor = null;

    public $name, $position_id, $description, $photo;
    public $existingPhotoUrl = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'position_id' => 'required|exists:positions,id',
        'description' => 'nullable|string|max:500',
        'photo' => 'nullable|image', // 1MB Max
    ];

    public function create()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->isModalOpen = true;
    }

    public function edit(Mentor $mentor)
    {
        $this->mentor = $mentor;
        $this->name = $mentor->name;
        $this->position_id = $mentor->position_id;
        $this->description = $mentor->description;
        $this->existingPhotoUrl = $mentor->photo;
        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'position_id' => $this->position_id,
            'description' => $this->description,
        ];

        if ($this->photo) {
            if ($this->isEditMode && $this->mentor->photo) {
                Storage::disk('public')->delete($this->mentor->photo);
            }
            $data['photo'] = $this->photo->store('mentors', 'public');
        }

        if ($this->isEditMode) {
            $this->mentor->update($data);
        } else {
            Mentor::create($data);
        }

        session()->flash('message', 'Data mentor berhasil disimpan.');
        $this->closeModal();
    }

    public function delete(Mentor $mentor)
    {
        if ($mentor->photo && Storage::disk('public')->exists($mentor->photo)) {
            Storage::disk('public')->delete($mentor->photo);
        }
        $mentor->delete();
        session()->flash('message', 'Data mentor berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->mentor = null;
        $this->name = '';
        $this->position_id = '';
        $this->description = '';
        $this->photo = null;
        $this->existingPhotoUrl = null;
    }

    public function render()
    {
        return view('livewire.admin.mentors.index', [
            'mentors' => Mentor::with('position.formation')->latest()->paginate(10),
            'positions' => Position::with('formation')->get(),
        ])->layout('components.layouts.app');
    }
}

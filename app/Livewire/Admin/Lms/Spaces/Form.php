<?php

namespace App\Livewire\Admin\Lms\Spaces;

use App\Models\LmsSpace;
use App\Models\Position;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Form extends Component
{
    use WithFileUploads;

    public ?LmsSpace $lms_space = null;
    public $title = '', $description = '', $image, $existing_image_path, $is_active = true, $assignedPositions = [];
    public $isEditMode = false;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048', // 2MB Max
            'is_active' => 'required|boolean',
            'assignedPositions' => 'required|array|min:1',
        ];
    }

    protected function messages()
    {
        return [
            'title.required' => 'Judul harus diisi.',
            'image.required' => 'Gambar sampul harus diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'assignedPositions.required' => 'Pilih setidaknya satu jabatan.',
        ];
    }

    public function mount($lms_space = null, $position_id = null)
    {
        if ($lms_space) {
            $this->isEditMode = true;
            $this->lms_space = LmsSpace::with('positions')->findOrFail($lms_space->id);
            $this->title = $this->lms_space->title;
            $this->description = $this->lms_space->description;
            $this->existing_image_path = $this->lms_space->image_path;
            $this->is_active = $this->lms_space->is_active;
            $this->assignedPositions = $this->lms_space->positions->pluck('id')->toArray();
        }
        if ($position_id) {
            $this->assignedPositions = [$position_id];
        }
    }

    public function store()
    {
        $this->validate();
        $dataToSave = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            if ($this->isEditMode && $this->lms_space->image_path) {
                Storage::disk('public')->delete($this->lms_space->image_path);
            }
            $dataToSave['image_path'] = $this->image->store('lms_images', 'public');
        }

        if ($this->isEditMode) {
            $this->lms_space->update($dataToSave);
        } else {
            $this->lms_space = LmsSpace::create($dataToSave);
        }

        $this->lms_space->positions()->sync($this->assignedPositions);
        session()->flash('message', 'Data LMS Space berhasil disimpan.');
        return $this->redirectRoute('admin.lms-spaces.index');
    }

    public function render()
    {
        $allPositions = Position::with('formation')->get();
        return view('livewire.admin.lms.spaces.form', [
            'allPositions' => $allPositions,
        ])->layout('components.layouts.app');
    }
}

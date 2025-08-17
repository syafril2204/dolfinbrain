<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Material;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public ?Material $material = null;
    public $position_id = null;
    public $title = '';
    public $description = '';
    public $file;
    public $assignedPositions = [];
    public $isEditMode = false;

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assignedPositions' => 'required|array|min:1',
            'file' => $this->isEditMode ? 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240' : 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240',
        ];
        return $rules;
    }

    public function mount($material = null, $position_id = null)
    {
        if ($material) {
            $this->isEditMode = true;
            $this->material = Material::with('positions')->findOrFail($material->id);
            $this->title = $this->material->title;
            $this->description = $this->material->description;
            $this->assignedPositions = $this->material->positions->pluck('id')->toArray();
        }
        if ($position_id) {
            $this->position_id = $position_id;
        }
    }

    public function store()
    {
        $validatedData = $this->validate();

        $dataToSave = [
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']),
            'description' => $validatedData['description'],
        ];

        if ($this->file) {
            if ($this->isEditMode && $this->material->file_path && Storage::exists($this->material->file_path)) {
                Storage::delete($this->material->file_path);
            }
            $dataToSave['file_path'] = $this->file->store('public/materials');
            $dataToSave['file_size'] = $this->file->getSize();
            $dataToSave['file_type'] = $this->file->extension();
        }

        if ($this->isEditMode) {
            $this->material->update($dataToSave);
        } else {
            $newMaterial = Material::create([
                'title' => $this->title,
                'description' => $this->description,
                'file_path' => $this->file->store('materials', 'public'),
                'file_size' => $this->file->getSize(),
                'file_type' => $this->file->getClientOriginalExtension(),
            ]);

            if ($this->position_id) {
                $newMaterial->positions()->attach($this->position_id);
            }
        }

        $this->material->positions()->sync($validatedData['assignedPositions']);

        session()->flash('message', 'Data materi berhasil disimpan.');

        return $this->redirectRoute('admin.materials.index', navigate: true);
    }

    public function render()
    {
        $allPositions = Position::with('formation')->get();

        return view('livewire.admin.materials.form', [
            'allPositions' => $allPositions,
        ])->layout('components.layouts.app');
    }
}

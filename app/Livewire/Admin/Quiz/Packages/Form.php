<?php

namespace App\Livewire\Admin\Quiz\Packages;

use App\Models\Position;
use App\Models\QuizPackage;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component
{
    // 1. Ubah properti ke snake_case
    public ?QuizPackage $quiz_package = null;

    public $title = '';
    public $description = '';
    public $duration_in_minutes = 60;
    public $is_active = true;
    public $assignedPositions = [];
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration_in_minutes' => 'required|integer|min:1',
        'is_active' => 'required|boolean',
        'assignedPositions' => 'required|array|min:1',
    ];

    protected function messages()
    {
        return [
            'title.required' => 'Judul paket harus diisi.',
            'duration_in_minutes.required' => 'Durasi harus diisi.',
            'duration_in_minutes.integer' => 'Durasi harus berupa angka.',
            'duration_in_minutes.min' => 'Durasi minimal 1 menit.',
            'assignedPositions.required' => 'Jabatan harus dipilih.',
            'assignedPositions.min' => 'Pilih setidaknya satu Jabatan.',
        ];
    }

    // 2. Ubah argumen mount ke snake_case agar cocok dengan route
    public function mount($quiz_package = null, $position_id = null)
    {
        if ($quiz_package) {
            $this->isEditMode = true;
            $this->quiz_package = QuizPackage::with('positions')->findOrFail($quiz_package->id);
            $this->title = $this->quiz_package->title;
            $this->description = $this->quiz_package->description;
            $this->duration_in_minutes = $this->quiz_package->duration_in_minutes;
            $this->is_active = $this->quiz_package->is_active;
            $this->assignedPositions = $this->quiz_package->positions->pluck('id')->toArray();
        }
        if ($position_id) {
            $this->assignedPositions = [$position_id];
        }
    }

    public function store()
    {
        $validatedData = $this->validate();

        $dataToSave = [
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']),
            'description' => $validatedData['description'],
            'duration_in_minutes' => $validatedData['duration_in_minutes'],
            'is_active' => $validatedData['is_active'],
        ];

        if ($this->isEditMode) {
            $this->quiz_package->update($dataToSave);
        } else {
            $this->quiz_package = QuizPackage::create($dataToSave);
        }

        $this->quiz_package->positions()->sync($validatedData['assignedPositions']);

        session()->flash('message', 'Paket kuis berhasil disimpan.');
        return $this->redirectRoute('admin.quiz-packages.index', navigate: true);
    }

    public function render()
    {
        $allPositions = Position::with('formation')->get();
        return view('livewire.admin.quiz.packages.form', [
            'allPositions' => $allPositions
        ])->layout('components.layouts.app');
    }
}

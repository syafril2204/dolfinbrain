<?php

namespace App\Livewire\Admin\Lms\Content\Coaching;

use App\Models\LmsCoaching;
use App\Models\LmsSpace;
use Livewire\Component;

class Form extends Component
{
    public LmsSpace $lms_space;
    public ?LmsCoaching $coaching = null;

    public $title = '', $trainer_name = '', $meeting_url = '', $start_at, $end_at;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'trainer_name' => 'nullable|string|max:255',
        'meeting_url' => 'required|url',
        'start_at' => 'required|date',
        'end_at' => 'required|date|after:start_at',
    ];


    public function mount($lms_space, $coaching = null)
    {
        $this->lms_space = LmsSpace::findOrFail($lms_space->id);

        if ($coaching) {
            $this->isEditMode = true;
            $this->coaching = LmsCoaching::findOrFail($coaching->id);
            $this->title = $this->coaching->title;
            $this->trainer_name = $this->coaching->trainer_name;
            $this->meeting_url = $this->coaching->meeting_url;
            $this->start_at = $this->coaching->start_at->format('Y-m-d\TH:i');
            $this->end_at = $this->coaching->end_at->format('Y-m-d\TH:i');
        }
    }

    public function store()
    {
        $validatedData = $this->validate();

        if ($this->isEditMode) {
            $this->coaching->update($validatedData);
        } else {
            $this->lms_space->coachings()->create($validatedData);
        }

        session()->flash('message', 'Jadwal coaching berhasil disimpan.');
        return $this->redirectRoute('admin.lms-spaces.content.coaching.index', ['lms_space' => $this->lms_space]);
    }

    public function render()
    {
        return view('livewire.admin.lms.content.coaching.form')
            ->layout('components.layouts.app');
    }
}

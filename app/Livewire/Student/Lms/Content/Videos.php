<?php

namespace App\Livewire\Student\Lms\Content;

use App\Models\LmsSpace;
use App\Models\LmsVideo;
use Livewire\Component;

class Videos extends Component
{
    public LmsSpace $lms_space;
    public ?LmsVideo $playingVideo;

    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
        $this->playingVideo = $lms_space->videos()->orderBy('order')->first();
    }

    public function playVideo(LmsVideo $video)
    {
        $this->playingVideo = $video;
    }

    public function render()
    {
        return view('livewire.student.lms.content.videos', [
            'videos' => $this->lms_space->videos()->orderBy('order')->get()
        ])->layout('components.layouts.app');
    }
}

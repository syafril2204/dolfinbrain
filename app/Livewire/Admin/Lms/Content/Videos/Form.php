<?php

namespace App\Livewire\Admin\Lms\Content\Videos;

use App\Models\LmsSpace;
use App\Models\LmsVideo;
use Livewire\Component;

class Form extends Component
{
    public LmsSpace $lms_space;
    public ?LmsVideo $video = null;

    public $title = '', $youtube_url = '', $duration = '', $order = 0;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'youtube_url' => 'required|url',
        'duration' => 'nullable|string|max:50',
        'order' => 'required|integer',
    ];

    public function mount($lms_space, $video = null)
    {
        $this->lms_space = LmsSpace::findOrFail($lms_space->id);

        if ($video) {
            $this->isEditMode = true;
            $this->video = LmsVideo::findOrFail($video->id);
            $this->title = $this->video->title;
            $this->youtube_url = $this->video->youtube_url;
            $this->duration = $this->video->duration;
            $this->order = $this->video->order;
        }
    }

    private function extractYoutubeId($url)
    {
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }

    public function store()
    {
        $validatedData = $this->validate();

        $videoId = $this->extractYoutubeId($validatedData['youtube_url']);
        if ($videoId) {
            $validatedData['youtube_url'] = 'https://www.youtube.com/embed/' . $videoId;
        } else {
            $this->addError('youtube_url', 'Format URL YouTube tidak valid.');
            return;
        }

        if ($this->isEditMode) {
            $this->video->update($validatedData);
        } else {
            $this->lms_space->videos()->create($validatedData);
        }

        session()->flash('message', 'Video rekaman berhasil disimpan.');
        return $this->redirectRoute('admin.lms-spaces.content.videos.index', ['lms_space' => $this->lms_space]);
    }

    public function render()
    {
        return view('livewire.admin.lms.content.videos.form')
            ->layout('components.layouts.app');
    }
}

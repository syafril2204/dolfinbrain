<?php

namespace App\Livewire\Admin\Lms\Content\Videos;

use App\Models\LmsSpace;
use App\Models\LmsVideo;
use Livewire\Component;

class Index extends Component
{
    public LmsSpace $lms_space;

    public $isPreviewModalOpen = false;
    public ?LmsVideo $previewingVideo = null;

    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
    }

    public function showPreview(LmsVideo $video)
    {
        $this->previewingVideo = $video;
        $this->isPreviewModalOpen = true;
    }

    public function closePreviewModal()
    {
        $this->isPreviewModalOpen = false;
        $this->previewingVideo = null;
    }

    public function delete(LmsVideo $video)
    {
        $video->delete();
        session()->flash('message', 'Video rekaman berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.lms.content.videos.index', [
            'videos' => $this->lms_space->videos()->orderBy('order')->get()
        ])->layout('components.layouts.app');
    }
}

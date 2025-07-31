<?php

namespace App\Livewire\Admin\Lms\Content;

use App\Models\LmsResource;
use App\Models\LmsSpace;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Files extends Component
{
    use WithFileUploads;

    public LmsSpace $lms_space;
    public $activeTab = 'files';
    protected $queryString = ['activeTab' => ['except' => 'files', 'as' => 'tab']];

    // Properti untuk Modal Form
    public $isModalOpen = false;
    public $isEditMode = false;
    public ?LmsResource $resource = null;
    public $title = '', $type = '', $file;

    // 👇 [PROPERTI BARU] Untuk Modal Preview Audio
    public $isPreviewModalOpen = false;
    public ?LmsResource $previewingAudio = null;

    // ... (Metode rules, mount, switchTab, create, edit, store tidak berubah) ...

    public function mount(LmsSpace $lms_space)
    {
        $this->lms_space = $lms_space;
    }

    public function switchTab($tabName)
    {
        $this->activeTab = $tabName;
    }

    public function create($type)
    {
        $this->resetForm();
        $this->type = ($type === 'files') ? 'recap_file' : 'audio_recording';
        $this->isModalOpen = true;
    }

    public function edit(LmsResource $resource)
    {
        $this->resetForm();
        $this->isEditMode = true;
        $this->resource = $resource;
        $this->title = $resource->title;
        $this->type = $resource->type;
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();
        $dataToSave = ['title' => $this->title, 'type' => $this->type];

        if ($this->file) {
            if ($this->isEditMode && $this->resource->file_path) {
                Storage::disk('public')->delete($this->resource->file_path);
            }
            $dataToSave['file_path'] = $this->file->store('lms_resources', 'public');
            $dataToSave['file_size'] = $this->file->getSize();
            $dataToSave['file_type'] = $this->file->extension();
        }

        if ($this->isEditMode) {
            $this->resource->update($dataToSave);
        } else {
            $this->lms_space->resources()->create($dataToSave);
        }

        session()->flash('message', 'Resource berhasil disimpan.');
        $this->closeModal();
    }

    // 👇 [FUNGSI BARU] Untuk menampilkan modal preview
    public function showPreview(LmsResource $resource)
    {
        $this->previewingAudio = $resource;
        $this->isPreviewModalOpen = true;
    }

    // 👇 [FUNGSI BARU] Untuk menutup modal preview
    public function closePreviewModal()
    {
        $this->isPreviewModalOpen = false;
        $this->previewingAudio = null;
    }

    public function delete(LmsResource $resource)
    {
        if ($resource->file_path && Storage::disk('public')->exists($resource->file_path)) {
            Storage::disk('public')->delete($resource->file_path);
        }
        $resource->delete();
        session()->flash('message', 'Resource berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['isModalOpen', 'isEditMode', 'resource', 'title', 'type', 'file']);
        $this->resetErrorBag();
    }

    public function render()
    {
        $files = $this->lms_space->resources()->where('type', 'recap_file')->latest()->get();
        $audios = $this->lms_space->resources()->where('type', 'audio_recording')->latest()->get();

        return view('livewire.admin.lms.content.files', [
            'recapFiles' => $files,
            'audioRecordings' => $audios,
        ])->layout('components.layouts.app');
    }
}

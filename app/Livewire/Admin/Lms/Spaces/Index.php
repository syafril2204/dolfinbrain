<?php

namespace App\Livewire\Admin\Lms\Spaces;

use App\Models\LmsSpace;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $spaces = LmsSpace::latest()->paginate(9);
        return view('livewire.admin.lms.spaces.index', [
            'spaces' => $spaces
        ])->layout('components.layouts.app');
    }

    public function delete(LmsSpace $lms_space)
    {
        if ($lms_space->image_path && Storage::disk('public')->exists($lms_space->image_path)) {
            Storage::disk('public')->delete($lms_space->image_path);
        }
        $lms_space->delete();
        session()->flash('message', 'LMS Space berhasil dihapus.');
    }
}

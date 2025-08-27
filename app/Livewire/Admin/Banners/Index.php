<?php

namespace App\Livewire\Admin\Banners;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $banners;
    public $newImage;
    public $editingBannerId = null;
    public $editingImage;

    protected $rules = [
        'newImage' => 'required|image|max:2048', // Maks 2MB
        'editingImage' => 'required|image|max:2048',
    ];

    public function mount()
    {
        $this->loadBanners();
    }

    public function loadBanners()
    {
        $this->banners = Banner::orderBy('id')->get();
    }

    public function addBanner()
    {
        // Batasi hanya 3 banner
        if (Banner::count() >= 3) {
            session()->flash('error', 'Anda hanya dapat menambahkan maksimal 3 banner.');
            return;
        }

        $this->validate(['newImage' => 'required|image']);

        $path = $this->newImage->store('banners', 'public');
        Banner::create(['image_path' => $path]);

        session()->flash('message', 'Banner baru berhasil ditambahkan.');
        $this->reset('newImage');
        $this->loadBanners();
    }

    public function editBanner($bannerId)
    {
        $this->editingBannerId = $bannerId;
        $this->reset('editingImage');
    }

    public function cancelEdit()
    {
        $this->reset('editingBannerId', 'editingImage');
    }

    public function updateBanner($bannerId)
    {
        $this->validate(['editingImage' => 'required|image']);

        $banner = Banner::findOrFail($bannerId);

        // Hapus gambar lama
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        // Simpan gambar baru
        $path = $this->editingImage->store('banners', 'public');
        $banner->update(['image_path' => $path]);

        session()->flash('message', 'Banner berhasil diperbarui.');
        $this->cancelEdit();
        $this->loadBanners();
    }

    public function deleteBanner(Banner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();

        session()->flash('message', 'Banner berhasil dihapus.');
        $this->loadBanners();
    }

    public function render()
    {
        return view('livewire.admin.banners.index')->layout('components.layouts.app');
    }
}

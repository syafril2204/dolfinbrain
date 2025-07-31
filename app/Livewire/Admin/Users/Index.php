<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public ?User $selectedUser = null;
    public $isDetailModalOpen = false;

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function toggleStatus(User $user)
    {
        $user->status = ($user->status === 'active') ? 'blocked' : 'active';
        $user->save();
        session()->flash('message', 'Status pengguna berhasil diperbarui.');
    }

    public function showDetail(User $user)
    {
        $this->selectedUser = $user->load('purchasedPositions.formation');
        $this->isDetailModalOpen = true;
    }

    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->selectedUser = null;
    }

    public function render()
    {
        $adminId = Auth::id();
        $users = User::where('id', '!=', $adminId)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users.index', [
            'users' => $users,
        ])->layout('components.layouts.app');
    }
}

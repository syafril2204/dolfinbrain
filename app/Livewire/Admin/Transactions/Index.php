<?php

namespace App\Livewire\Admin\Transactions;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Properti untuk filter
    public string $search = '';
    public string $filterStatus = '';
    public string $startDate = '';
    public string $endDate = '';

    // Reset halaman saat filter berubah
    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingStartDate() { $this->resetPage(); }
    public function updatingEndDate() { $this->resetPage(); }

    public function resetFilters()
    {
        $this->reset('search', 'filterStatus', 'startDate', 'endDate');
        $this->resetPage();
    }

    public function render()
    {
        $query = Transaction::with('user', 'position.formation')
            // Filter berdasarkan pencarian nama user atau referensi
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('reference', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            // Filter berdasarkan status
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            // Filter berdasarkan tanggal mulai
            ->when($this->startDate, function ($q) {
                $q->whereDate('created_at', '>=', $this->startDate);
            })
            // Filter berdasarkan tanggal selesai
            ->when($this->endDate, function ($q) {
                $q->whereDate('created_at', '<=', $this->endDate);
            });

        $transactions = $query->latest()->paginate(15);

        return view('livewire.admin.transactions.index', [
            'transactions' => $transactions,
        ])->layout('components.layouts.app');
    }
}

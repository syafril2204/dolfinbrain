<?php

namespace App\Livewire\Admin\Transactions;

use App\Models\Transaction;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
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
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingFilterStatus()
    {
        $this->resetPage();
    }
    public function updatingStartDate()
    {
        $this->resetPage();
    }
    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('search', 'filterStatus', 'startDate', 'endDate');
        $this->resetPage();
    }
    /**
     * Method untuk memicu unduhan file Excel.
     */
    public function exportExcel()
    {
        // Berikan nama file yang dinamis berdasarkan tanggal
        $fileName = 'transaksi-' . now()->format('d-m-Y') . '.xlsx';

        // Panggil class export dengan membawa semua nilai filter saat ini
        return Excel::download(
            new TransactionsExport($this->search, $this->filterStatus, $this->startDate, $this->endDate),
            $fileName
        );
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

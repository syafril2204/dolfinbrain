<?php

namespace App\Livewire\Student\Transactions;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('position.formation')
            ->latest()
            ->paginate(10);

        return view('livewire.student.transactions.index', [
            'transactions' => $transactions,
        ])->layout('components.layouts.app');
    }
}

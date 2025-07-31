<?php

namespace App\Livewire\Student\Packages;

use App\Models\Transaction;
use Livewire\Component;

class Instruction extends Component
{
    public Transaction $transaction;
    public $timeRemaining;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction->load('position.formation');

        if ($this->transaction->expired_at && $this->transaction->expired_at->isFuture()) {
            $this->timeRemaining = now()->diffInSeconds($this->transaction->expired_at, false);
        } else {
            $this->timeRemaining = 0;
        }
    }

    public function render()
    {
        return view('livewire.student.packages.instruction')
            ->layout('components.layouts.app');
    }
}

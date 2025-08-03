<?php

namespace App\Livewire\Student\Contact;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.student.contact.index')
            ->layout('components.layouts.app');
    }
}

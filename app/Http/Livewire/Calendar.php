<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Calendar extends Component
{
    public $year;

    public function mount()
    {
        $this->year = 2025;
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}

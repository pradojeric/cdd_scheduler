<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Schedules extends Component
{
    public $selected = "course";

    public function render()
    {
        return view('livewire.schedules');
    }
}

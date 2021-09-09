<?php

namespace App\Http\Livewire\Others;

use Livewire\Component;

class Modal extends Component
{
    public $isModalOpen;



    public function render()
    {
        return view('livewire.others.modal');
    }
}

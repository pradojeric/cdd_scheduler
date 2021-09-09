<?php

namespace App\Http\Livewire\Admin;

use App\Models\Configurations\RoomType;
use Livewire\Component;

class RoomTypes extends Component
{
    public function render()
    {
        return view('livewire.admin.room-types', [
            'roomTypes' => RoomType::all(),
        ]);
    }
}

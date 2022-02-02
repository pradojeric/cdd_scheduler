<?php

namespace App\Http\Livewire\Admin;

use Auth;
use Livewire\Component;

class ApiTokens extends Component
{
    public $isModalOpen;

    public function close()
    {
        $this->isModalOpen = false;
    }

    public function render()
    {
        return view('livewire.admin.api-tokens', [
            'tokens' => Auth::user()->tokens,
        ]);
    }
}

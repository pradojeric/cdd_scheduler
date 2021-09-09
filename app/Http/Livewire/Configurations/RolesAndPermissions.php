<?php

namespace App\Http\Livewire\Configurations;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesAndPermissions extends Component
{

    protected $listeners = [
        'addedRole' => '$refresh'
    ];

    public function deleteRole(Role $role)
    {
        $role->delete();
    }

    public function render()
    {

        return view('livewire.configurations.roles-and-permissions', [
            'roles' => Role::all(),
        ]);
    }
}

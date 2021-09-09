<?php

namespace App\Http\Livewire\Configurations;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesSettings extends Component
{
    public $isModalOpen;
    public $isEditing;
    public $role;
    public $roleModel;

    protected $rules = [
        'name' => 'required'
    ];

    protected $listeners = [
        'rolesSettings'
    ];

    public function rolesSettings(Role $mRole = null)
    {
        $this->isModalOpen = true;

        if($mRole->getAttribute('name')) {
            $this->roleModel = $mRole;
            $this->role = $mRole->name;
            $this->isEditing = true;
        }
    }

    public function addRole()
    {
        if($this->isEditing){
            $this->roleModel->update([
                'name' => $this->role,
            ]);
        }else{
            Role::create([
                'name' => $this->role
            ]);

        }
        $this->close();
        $this->emit('addedRole');
    }

    public function close()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.configurations.roles-settings');
    }
}

<?php

namespace App\Http\Livewire\Configurations;

use App\Models\User;
use Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UsersSettings extends Component
{
    public $isModalOpen;
    public $isEditing;
    public $user;
    public $name;
    public $email;
    public $password;
    public $passwordConfirmation;
    public $role;

    protected $rules = [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required_with:passwordConfirmation|same:passwordConfirmation',
        'role' => 'required',
    ];

    public function openUserModal(User $user = null)
    {
        $this->isModalOpen = true;
        if($user->getAttribute('name')){
            $this->user = $user;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->roles()->first()->id ?? '';
            $this->isEditing = true;
        }
    }

    public function addUser()
    {
        $this->validate();

        if($this->user->getAttribute('name')){
            $user = $this->user->update(
                [
                    'id' => $this->user->id,
                ],
                [
                    'name' => $this->name,
                    'email' => $this->email,
                ]
            );
        }else{
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
            ]);
        }

        if($this->password)
        {
            $user->update([
                'password' => Hash::make($this->password),
            ]);
        }

        $user->assignRole($this->role);

        $this->close();
    }

    public function close()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.configurations.users-settings', [
            'users' => User::with('roles')->get(),
            'roles' => Role::all(),
        ]);
    }
}

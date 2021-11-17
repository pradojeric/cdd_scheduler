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

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.optional($this->user)->id,
            'password' => 'nullable|required_with:passwordConfirmation|same:passwordConfirmation',
            'role' => 'required',
        ];
    }

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

        if($this->user){
            $this->user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);

            if($this->password)
            {
                $this->user->update([
                    'password' => Hash::make($this->password),
                ]);
            }
        }else{
            if(!$this->password) return $this->addError('password', 'Password is required!');

            $this->user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
        }

        $this->user->assignRole($this->role);

        $this->close();
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
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

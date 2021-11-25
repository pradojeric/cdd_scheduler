<?php

namespace App\Http\Livewire\Admin;

use App\Models\Configurations\Department;
use Livewire\Component;

class Departments extends Component
{
    public $department;
    public $code;
    public $name;

    public $isEditing = false;

    protected $rules = [
        'code' => 'required',
        'name' => 'required',
    ];

    public function addDepartment()
    {
        $this->validate();
        Department::create([
            'code' => $this->code,
            'name' => $this->name,
        ]);
        session()->flash('success', 'Section successfully added');
        $this->reset();
    }

    public function updateDepartment()
    {
        $this->validate();
        $this->department->update([
            'code' => $this->code,
            'name' => $this->name,
        ]);
        session()->flash('success', 'Section successfully updated');
        $this->reset();
    }

    public function editDepartment(Department $dept)
    {
        $this->department = $dept;
        $this->name = $dept->name;
        $this->code = $dept->code;
        $this->isEditing = true;
    }

    public function deleteDepartment(Department $dept)
    {
        $dept->delete();
    }

    public function render()
    {
        return view('livewire.admin.departments', [
            'departments' => Department::orderBy('name')->get(),
        ]);
    }
}

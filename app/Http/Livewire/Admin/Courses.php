<?php

namespace App\Http\Livewire\Admin;

use App\Models\Configurations\Course;
use App\Models\Configurations\Department;
use Livewire\Component;

class Courses extends Component
{
    public $course;

    public $code;
    public $name;
    public $department;

    public $isEditing = false;

    protected $rules = [
        'code' => 'required',
        'name' => 'required',
        'department' => 'required',
    ];

    public function addCourse()
    {
        $this->validate();
        Course::create([
            'code' => $this->code,
            'name' => $this->name,
            'department_id' => $this->department,
        ]);
        session()->flash('success', 'Section successfully added');
        $this->reset();
    }

    public function updateCourse()
    {
        $this->validate();
        $this->course->update([
            'code' => $this->code,
            'name' => $this->name,
            'department_id' => $this->department,
        ]);
        session()->flash('success', 'Section successfully updated');
        $this->reset();
    }

    public function editCourse(Course $course)
    {
        $this->course = $course;
        $this->name = $course->name;
        $this->code = $course->code;
        $this->department = $course->department_id;
        $this->isEditing = true;
    }

    public function deleteCourse(Course $course)
    {
        $course->delete();
    }


    public function render()
    {
        return view('livewire.admin.courses', [
            'courses' => Course::orderBy('name')->get(),
            'departments' => Department::orderBy('name')->get(),
        ]);
    }
}

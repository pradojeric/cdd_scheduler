<?php

namespace App\Http\Livewire\Configurations;

use App\Models\Configurations\Course;
use App\Models\Configurations\Curriculum;
use Livewire\Component;

class CurriculumIndex extends Component
{
    public $course;

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function deleteCurriculum(Curriculum $curriculum)
    {
        $course = $curriculum->course;
        $curriculum->subjects()->delete();
        $curriculum->delete();
        $this->course = $course;
    }

    public function activateCurriculum(Curriculum $curriculum)
    {
        //$curriculum->activateCurriculum();
        $curriculum->update([
            'active' => !$curriculum->active,
        ]);
        Curriculum::where('id', '<>', $curriculum->id)->where('course_id', $curriculum->course_id)->update(['active' => 0]);
        $this->course = $curriculum->course;
    }

    public function render()
    {
        return view('livewire.configurations.curriculum-index', [
            'curricula' => $this->course->curricula,
        ]);
    }
}

<?php

namespace App\Http\Livewire\Sections;

use App\Models\Faculty;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Schedule;
use App\Models\TimeSchedule;
use App\Services\SectionService;
use App\Models\Configurations\Course;
use App\Models\Configurations\Settings;

class CourseShow extends Component
{
    public $config;
    public Course $course;

    protected $listeners = [
        'updateFaculty',
        'updateSchedule' => '$refresh',
    ];

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->config = Settings::first();
    }

    public function updateFaculty(Schedule $schedule, Faculty $faculty)
    {
        $schedule->update([
            'faculty_id' => $faculty->id,
        ]);
    }

    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();
    }

    public function deleteTimeSchedule(TimeSchedule $timeSchedule)
    {
        $schedule = $timeSchedule->schedule;
        $timeSchedule->delete();
        if(count($schedule->timeSchedules) < 1)
        {
            $schedule->delete();
        }
    }

    public function render()
    {
        foreach($this->course->sections as $s)
        {
            $blockSubjects[$s->section_name] = resolve(SectionService::class)->getSubjects($s);
            $customSubjects[$s->section_name] = Subject::with([
                    'schedules',
                    'schedules.timeSchedules'
                ])->whereHas('schedules', function($query) use ($s) {
                    $query->where('section_id', $s->id);
                }
            )->whereNotIn('id', $blockSubjects[$s->section_name]->subjects->pluck('id'))
            ->get();
        }

        return view('livewire.sections.course-show', [
            'blockSubjects' => $blockSubjects,
            'customSubjects' => $customSubjects,
        ]);
    }
}

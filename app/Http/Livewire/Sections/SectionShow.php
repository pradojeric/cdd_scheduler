<?php

namespace App\Http\Livewire\Sections;

use App\Models\Faculty;
use App\Models\Section;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Schedule;
use App\Models\TimeSchedule;
use App\Services\SectionService;
use App\Services\ScheduleService;
use App\Models\Configurations\Course;
use App\Models\Configurations\Settings;

class SectionShow extends Component
{
    private $dayNames = [
        'M' => 'monday',
        'T' => 'tuesday',
        'W' => 'wednesday',
        'TH' => 'thursday',
        'F' => 'friday',
        'SAT' => 'saturday',
        'SUN' => 'sunday'
    ];

    public Section $section;
    public $config;

    protected $listeners = [
        'updateFaculty',
        'updateSchedule' => '$refresh',
    ];

    public function mount(Section $section)
    {
        $this->section = $section;
        $this->config = Settings::first();
    }

    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();
    }

    public function deleteTimeSchedule(TimeSchedule $timeSchedule)
    {
        $timeSchedule->delete();
    }

    public function updateFaculty(Schedule $schedule, Faculty $faculty)
    {
        $schedule->update([
            'faculty_id' => $faculty->id,
        ]);
    }

    public function render()
    {
        $blockSubjects = resolve(SectionService::class)->getSubjects($this->section);
        $customSubjects = Subject::with([
                'schedules',
                'schedules.timeSchedules'
            ])->whereHas('schedules', function($query){
                $query->where('section_id', $this->section->id);
            }
        )->whereNotIn('id', $blockSubjects->subjects->pluck('id'))
        ->get();

        $r = TimeSchedule::with([
                'schedule',
                'schedule.timeSchedules'
            ])->whereHas('schedule', function($query){
                $query->where('section_id', $this->section->id);
            });

        $schedules = resolve(ScheduleService::class)->getTimeSchedules($r, true);

        return view('livewire.sections.section-show', [
            'blockSubjects' => $blockSubjects->subjects ?? [],
            'days' => $this->dayNames,
            'schedules' => $schedules,
            'customSubjects' => $customSubjects ?? [],
        ]);
    }
}

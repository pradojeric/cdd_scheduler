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

use Illuminate\Support\Facades\Http;

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
        $sy = $schedule->school_year;
        $section = $schedule->section->section_name;
        $room_name = $schedule->subject->title;

        if($schedule->lab) {
            $room_name = $room_name . " (Laboratory)";
        }

        $step_room = [
            'name' => $room_name,
            'section' => $section,
            'sy' => $sy,
        ];

        $token = config('step.step.token');
        $url = config('step.step.url');

        // find and delete step room
        $response = Http::withToken($token)
            ->accept('application/json')
            ->post($url.'/api/rooms/delete', $step_room);

        $schedule->delete();
    }

    public function deleteTimeSchedule(TimeSchedule $timeSchedule)
    {

        $schedule = $timeSchedule->schedule;

        if($schedule->timeSchedules->count() == 1)
        {
            $schedule->delete();
        }
        else
        {
            $timeSchedule->delete();
        }

    }

    public function updateFaculty(Schedule $schedule, Faculty $faculty)
    {
        $schedule->update([
            'faculty_id' => $faculty->id,
        ]);
    }

    public function render()
    {
        // $blockSubjects = resolve(SectionService::class)->getSubjects($this->section);

        // $customSubjects = Subject::with([
        //         'schedules',
        //         'schedules.timeSchedules'
        //     ])->whereHas('schedules', function($query){
        //         $query->where('section_id', $this->section->id);
        //     }
        // )->whereNotIn('id', $blockSubjects->subjects->pluck('id'))
        // ->get();

        $r = TimeSchedule::with([
                'schedule',
                'schedule.timeSchedules'
            ])->whereHas('schedule', function($query){
                $query->where('section_id', $this->section->id);
            });

        $schedules = resolve(ScheduleService::class)->getTimeSchedules($r, true);

        return view('livewire.sections.section-show', [
            // 'blockSubjects' => $blockSubjects->subjects ?? [],
            'blockSubjects' => $this->section->getBlockSubjects() ?? [],
            'days' => $this->dayNames,
            'schedules' => $schedules,
            // 'customSubjects' => $customSubjects ?? [],
            'customSubjects' => $this->section->getCustomSubjects() ?? [],
        ]);
    }
}

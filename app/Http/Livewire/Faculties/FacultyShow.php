<?php

namespace App\Http\Livewire\Faculties;

use App\Models\Faculty;
use Livewire\Component;
use App\Models\TimeSchedule;
use App\Services\ScheduleService;

class FacultyShow extends Component
{
    public $faculty;

    public function mount(Faculty $faculty)
    {
        $this->faculty = $faculty;
    }

    public function render()
    {
        $r = TimeSchedule::whereHas('schedule', function($query){
            $query->where('faculty_id', $this->faculty->id);
        });

        $schedules = resolve(ScheduleService::class)->getTimeSchedules($r, true);
        $days = [
            'M' => 'monday',
            'T' => 'tuesday',
            'W' => 'wednesday',
            'TH' => 'thursday',
            'F' => 'friday',
            'SAT' => 'saturday',
            'SUN' => 'sunday'
        ];

        return view('livewire.faculties.faculty-show', [
            'schedules' => $schedules,
            'days' => $days,
        ]);
    }
}

<?php

namespace App\Http\Livewire\Faculties;

use App\Models\Faculty;
use Livewire\Component;
use App\Models\TimeSchedule;
use App\Services\ScheduleService;

class FacultyShow extends Component
{
    public $faculty;
    public $schedules = [];
    public $days = [];

    public function mount(Faculty $faculty)
    {
        $this->faculty = $faculty;
    }

    public function init()
    {
        $r = TimeSchedule::whereHas('schedule', function($query){
            $query->where('faculty_id', $this->faculty->id);
        });

        $this->schedules = resolve(ScheduleService::class)->getTimeSchedules($r, true);
        $this->days = [
            'M' => 'monday',
            'T' => 'tuesday',
            'W' => 'wednesday',
            'TH' => 'thursday',
            'F' => 'friday',
            'SAT' => 'saturday',
            'SUN' => 'sunday'
        ];
    }

    public function render()
    {
        return view('livewire.faculties.faculty-show');
    }
}

<?php

namespace App\Http\Livewire\Faculties;

use App\Models\Faculty;
use Livewire\Component;
use Carbon\CarbonInterval;
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
        $days = [
            'M' => 'monday',
            'T' => 'tuesday',
            'W' => 'wednesday',
            'TH' => 'thursday',
            'F' => 'friday',
            'SAT' => 'saturday',
            'SUN' => 'sunday'
        ];
        $r = TimeSchedule::whereHas('schedule', function($query){
            $query->where('faculty_id', $this->faculty->id);
        });

        $schedules = resolve(ScheduleService::class)->getTimeSchedules($r, true);

        $timeRange = CarbonInterval::minutes(30)->toPeriod('7:00', '20:00');

        $data = [];
        foreach($timeRange as $time)
        {
            $t = $time->format('h:i A');


            foreach($days as $day)
            {
                $exists = (clone $r)->where(function($query) use ($time){
                            $query->where('start', '<=', $time)
                                ->where('end', '>', $time);
                        })
                        ->where($day, 1)
                        ->dd();

                $data[$day] = $exists;
            }


            $roomsAvailable["$t"] = $data;
        }


        return view('livewire.faculties.faculty-show', [
            'schedules' => $schedules,
            'days' => $days,
            'r' => $roomsAvailable,
        ]);
    }
}

<?php

namespace App\Services;

use App\Models\Faculty;
use Carbon\CarbonInterval;
use App\Models\TimeSchedule;
use App\Models\Configurations\Settings;
use App\Models\Subject;

class FacultyService
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
    private Settings $config;

    public function __construct()
    {
        $this->config = Settings::first();
    }

    public function checkFacultyConflict(Faculty $selectedFaculty, $start, $end, $pickedDays)
    {
        return TimeSchedule::whereHas('schedule', function($query) use ($selectedFaculty){
                $query->where('faculty_id', $selectedFaculty->id);
            })
            ->where(function ($query) use ($start, $end, $pickedDays) {
                foreach($this->dayNames as $day)
                {
                    $query->when($pickedDays[$day], function($query) use ($day, $start, $end, $pickedDays){
                        $query->orWhere(function($query) use ($start, $end) {
                            $query->where(function($query) use ($start) {
                                $query->where('start', '<=', $start)
                                    ->where('end', '>', $start);
                            })->orWhere(function($query) use ($end){
                                $query->where('start', '<', $end)
                                    ->where('end', '>=', $end);
                            });
                        })->where($day, $pickedDays[$day]);
                    });
                }
            })->exists();
    }


    public function getPreferredFaculty(Subject $subject)
    {
        return Faculty::active()->whereHas('preferredSubjects', function($query) use ($subject){
            $query->where('subject_code', $subject->code);
        })->get();
    }

    public function getHoursPerWeek(Faculty $faculty)
    {

    }
}

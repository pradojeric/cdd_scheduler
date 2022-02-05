<?php

namespace App\Services;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;

class ScheduleService
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

    public function getTimeSchedules(Builder $r, $get = null)
    {
        $timeRange = CarbonInterval::minutes(30)->toPeriod('7:00', '21:00');

        $data = [];
        foreach($timeRange as $time)
        {
            $t = $time->format('h:i A');

            if($get) {

                foreach($this->dayNames as $day)
                {
                    $exists = (clone $r)->where(function($query) use ($time, $day){
                                $query->where('start', '<=', $time->toTimeString())
                                    ->where('end', '>', $time->toTimeString())
                                    ->where($day, 1);
                            })
                            ->get();

                    $data[$day] = $exists;

                }

            }

            $roomsAvailable["$t"] = $data;
        }

        return $roomsAvailable;
    }

    // public function getTimeSchedules(Builder $r, $get = null)
    // {
    //     $timeRange = CarbonInterval::minutes(30)->toPeriod('7:00', '20:00');

    //     $data = [];
    //     foreach($timeRange as $time)
    //     {
    //         $t = $time->format('h:i A');

    //         if($get) {

    //             foreach($this->dayNames as $day)
    //             {
    //                 $exists = (clone $r)->where(function($query) use ($time, $day){
    //                             $query->where('start', '<=', $time->toTimeString())
    //                                 ->where('end', '>', $time->toTimeString())
    //                                 ->where($day, 1);
    //                         })
    //                         ->orderBy('start')
    //                         ->first();

    //                 $data[$day] = $exists ?? null;
    //             }
    //         }

    //         $roomsAvailable["$t"] = $data;
    //     }

    //     return $roomsAvailable;
    // }

    public function checkInputHours($start, $end, $pickdays)
    {
        $hours = 0;
        foreach($this->dayNames as $day)
        {
            if($pickdays[$day]){
                $hours += abs(strtotime($end) - strtotime($start)) / 3600;
            }
        }
        return $hours;
    }
}

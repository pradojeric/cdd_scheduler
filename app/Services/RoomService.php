<?php

namespace App\Services;

use App\Models\TimeSchedule;
use App\Models\Configurations\Settings;
use App\Models\Room;

class RoomService
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

    public function checkOccupiedRoom($selectedRoom, $start, $end, $pickedDays)
    {
        return TimeSchedule::whereHas('room', function($query) use ($selectedRoom){
                $query->where('id', $selectedRoom)
                    ->where('is_room', true);
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

    public function getAllUnoccupiedRoom($start, $end, $pickedDays, $except = null)
    {

        $occupiedRoomById = Room::with('timeSchedules')->whereHas('timeSchedules', function($query) use ($start, $end, $pickedDays) {
            $query->where(function($query) use ($start, $end, $pickedDays) {
                foreach($this->dayNames as $day)
                {
                    if($pickedDays[$day]){
                        $query->when($pickedDays[$day], function($query) use ($day, $start, $end, $pickedDays){
                            $query->orWhere(function($query) use ($day, $start, $end, $pickedDays) {
                                $query->where(function($query) use ($start, $end) {
                                    $query->orWhere(function($query) use ($start) {
                                        $query->where('start', '<=', $start)
                                            ->where('end', '>', $start);
                                    })->orWhere(function($query) use ($end){
                                        $query->where('start', '<', $end)
                                            ->where('end', '>=', $end);
                                    });
                                })->where($day, $pickedDays[$day]);
                            });
                        });
                    }
                }
            });
        })->when($except, function($query) use ($except) {
            $query->where('id', '!=', $except);
        })->where('is_room', true)
        ->get()->pluck('id');


        return Room::whereNotIn('id', $occupiedRoomById);
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'schedule_id', 'start', 'end', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'lab',
    ];

    public function getTimeAttribute()
    {
        $dayNames = [
            'M' => 'monday',
            'T' => 'tuesday',
            'W' => 'wednesday',
            'TH' => 'thursday',
            'F' => 'friday',
            'SAT' => 'saturday',
            'SUN' => 'sunday'
        ];

        $start = Carbon::parse($this->start)->format('h:iA');
        $end = Carbon::parse($this->end)->format('h:iA');

        $days = "";
        foreach($dayNames as $i => $day)
        {
            if($this->$day){
                $days .= $i;
            }
        }

        return $start . " - ".$end." ".$days;
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getBlockPer($minutePeriod)
    {
        return abs((strtotime($this->end) - strtotime($this->start))) / 60 / $minutePeriod;
    }
}

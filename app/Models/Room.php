<?php

namespace App\Models;

use App\Models\Configurations\Building;
use App\Models\Configurations\RoomType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'capacity', 'building_id', 'room_type_id', 'status', 'is_room'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function timeSchedules()
    {
        return $this->hasMany(TimeSchedule::class);
    }

    public function scopeLaboratory($query)
    {
        $query->whereHas('roomType', function($q){
            $q->where('lab', 1);
        });
    }

}

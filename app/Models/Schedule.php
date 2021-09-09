<?php

namespace App\Models;

use App\Models\Configurations\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('current_sy', function (Builder $builder) {
            $builder->where('school_year', Settings::first()->getRawOriginal('school_year'))
                ->where('term', Settings::first()->term);
        });
    }

    protected $fillable = [
        'room_id', 'section_id', 'subject_id', 'faculty_id', 'school_year', 'term',
    ];

    public function timeSchedules()
    {
        return $this->hasMany(TimeSchedule::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}

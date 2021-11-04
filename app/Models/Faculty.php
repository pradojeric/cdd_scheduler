<?php

namespace App\Models;

use App\Http\Livewire\Others\PreferredSubjects;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configurations\Department;
use App\Services\ScheduleService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'department_id', 'first_name', 'middle_name', 'last_name', 'rate', 'status', 'user_id'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getActiveStatusAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function preferredSubjects()
    {
        return $this->hasMany(FacultySubject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function countUnits()
    {
        return $this->schedules->sum(function($row){
            return $row->subject->lab_units + $row->subject->lec_units;
        });
    }

    public function countRemainingUnits()
    {
        return $this->rate - $this->countUnits();
    }

    public function hasNoUnits()
    {
        return $this->countRemainingUnits() < 1;
    }

    public function numberOfHoursPerWeek()
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

        $hours = 0;

        foreach($this->schedules->map->timeSchedules->flatten() as $t)
        {

            foreach($dayNames as $day)
            {
                if($t->$day)
                    $hours += abs(strtotime($t->end) - strtotime($t->start)) / 3600;
            }
        }

        return $hours;
    }

}

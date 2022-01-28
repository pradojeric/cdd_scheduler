<?php

namespace App\Models;

use App\Models\Configurations\Course;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configurations\Curriculum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id' ,'year', 'term' ,'curriculum_id' ,'code', 'title', 'lec_hours', 'lab_hours', 'lec_units', 'lab_units', 'prereq', 'uuid', 'active'
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_replace(' ', '', strtoupper($value));
    }

    public function getCodeAttribute()
    {
        return str_replace(' ', '', strtoupper($this->attributes['code']));
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtoupper($value);
    }

    public function getTotalUnitsAttribute()
    {
        return $this->attributes['lec_units'] + $this->attributes['lab_units'];
    }

    public function setPrereqAttribute($value)
    {
        $this->attributes['prereq'] = strtoupper($value);
    }

    public function hasLab()
    {
        return $this->lab_units > 0;
    }

    public function totalUnits()
    {
        return $this->lab_units + $this->lec_units;
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeTerm($query, $year, $term)
    {
        return $query->where('term', $term)->where('year', $year);
    }

    public function scopeTermSubjects($query, $term)
    {
        return $query->where('term', $term);
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function getHoursPerWeek($lab = false)
    {
        if($lab)
            return $this->lab_hours;
        else
            return $this->lec_hours;
    }

    public function getCodeTitle($isLab = false)
    {
        $subject = "{$this->code}";
        $lab = $isLab ? "L" : "";

        return "{$subject}{$lab}";
    }

    public function getSubjectTitle($isLab = false)
    {
        $subject = "{$this->code} - {$this->title}";
        $lab = $isLab ? "(LAB)" : "";
        $hours = $isLab ? "{$this->lab_hours}" : "{$this->lec_hours}";

        return "$subject $lab ($hours hrs/wk)";
    }
}

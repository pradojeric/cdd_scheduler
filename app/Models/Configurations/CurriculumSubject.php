<?php

namespace App\Models\Configurations;

use Illuminate\Database\Eloquent\Model;
use App\Models\Configurations\Curriculum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurriculumSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'year', 'term' ,'curriculum_id' ,'code', 'title', 'lec_hours', 'lab_hours', 'lec_units', 'lab_units', 'prereq', 'status', 'uuid'
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
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

    public function curriuclum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}

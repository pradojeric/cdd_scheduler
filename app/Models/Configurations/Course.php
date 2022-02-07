<?php

namespace App\Models\Configurations;

use App\Models\Section;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id', 'code', 'name', 'senior_high'
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function curricula()
    {
        return $this->hasMany(Curriculum::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('course_id')->orderBy('year');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

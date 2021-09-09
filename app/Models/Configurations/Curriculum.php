<?php

namespace App\Models\Configurations;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'effective_sy', 'description', 'active'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subjects()
    {
        return $this->hasMany(CurriculumSubject::class);
    }

    // public function subjects()
    // {
    //     return $this->hasMany(Subject::class);
    // }

    public function activateCurriculum()
    {
        $this->update([
            'active' => !$this->active,
        ]);
    }
}

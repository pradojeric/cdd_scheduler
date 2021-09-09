<?php

namespace App\Models;

use App\Models\Configurations\Course;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configurations\Department;
use App\Models\Configurations\Settings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
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
        'school_year', 'year', 'term', 'block', 'graduating', 'course_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function getSectionNameAttribute()
    {
        $block = str_pad($this->block, 2, '0', STR_PAD_LEFT);

        return "{$this->year}{$this->term}-{$this->course->code}-{$block}";
    }
}

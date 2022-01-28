<?php

namespace App\Models;

use App\Models\Subject;
use App\Services\SectionService;
use App\Models\Configurations\Course;
use App\Models\Configurations\Settings;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configurations\Department;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('current_sy', function (Builder $builder) {
            $builder->where('school_year', Settings::getSettings()->getRawOriginal('school_year'))
                ->where('term', Settings::getSettings()->term);
        });
    }

    protected $fillable = [
        'school_year', 'year', 'term', 'block', 'graduating', 'course_id'
    ];

    protected $with = ['course'];

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

    public function getBlockSubjects()
    {
        //return resolve(SectionService::class)->getSubjectsQuery($this) ?? [];
        return $this->course->subjects()
            ->with([
                'schedules' => function ($query) {
                    $query->where('section_id', $this->id);
                },
                'schedules.timeSchedules'
            ])->where(function ($query) {
                $query->term($this->year, $this->term)
                    ->active();
            })
            ->get();
    }

    public function getCustomSubjects()
    {
        return Subject::with([
                    'schedules',
                    'schedules.timeSchedules'
                ])->whereHas('schedules', function($query){
                    $query->where('section_id', $this->id);
                }
            )->whereNotIn('id', $this->getBlockSubjects()->pluck('id'))
            ->get();

    }
}

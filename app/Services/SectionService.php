<?php

namespace App\Services;

use App\Models\Section;
use App\Models\Subject;
use App\Models\Configurations\Course;
use App\Models\Configurations\Settings;

class SectionService
{
    private $dayNames = [
        'M' => 'monday',
        'T' => 'tuesday',
        'W' => 'wednesday',
        'TH' => 'thursday',
        'F' => 'friday',
        'SAT' => 'saturday',
        'SUN' => 'sunday'
    ];

    private Settings $config;

    public function __construct()
    {
        $this->config = Settings::first();
    }

    public function getSubjects(Section $section)
    {
        return Course::with([
            'subjects' => function($query) use ($section){
                $query->where('year', $section->year)
                    ->where('term', $section->term)
                    ->where('active', true);
            },
            'subjects.schedules' => function($query) use ($section){
                $query->where('section_id', $section->id);
            },
            'subjects.schedules.section' => function($query) {
                $query->where('school_year', $this->config->getRawOriginal('school_year'));
            },
        ])
        ->where('id', $section->course_id)
        ->first();
    }

    public function getSections(Subject $subject)
    {
        return Course::with([
            'sections' => function($query) use ($subject){
                $query->where('year', $subject->year)
                    ->where('term', $subject->term);
            },
            'sections.schedules' => function($query) use ($subject){
                $query->whereHas('subject', function($query) use ($subject){
                    $query->where('code', $subject->code);
                });
            }
        ])
        ->whereHas('subjects', function($query) use ($subject){
            $query->where('code', $subject->code);
        })->get()->map->sections->flatten();


    }

    public function checkSectionTime($section, $start, $end, $pickedDays, $except = null)
    {
        return Section::where('id', $section)
            ->whereHas('schedules', function($query) use ($start, $end, $pickedDays, $except){
                $query->whereHas('timeSchedules', function ($query) use ($start, $end, $pickedDays, $except) {
                    $query->where(function($query) use ($start, $end, $pickedDays){
                        foreach($this->dayNames as $day)
                        {
                            $query->when($pickedDays[$day], function($query) use ($day, $start, $end, $pickedDays){
                                $query->orWhere(function($query) use ($start, $end) {
                                    $query->where(function($query) use ($start){
                                        $query->where('start', '<=', $start)
                                            ->where('end', '>', $start);
                                    })->orWhere(function($query) use ($end){
                                        $query->where('start', '<', $end)
                                            ->where('end', '>=', $end);
                                    });
                                })->where($day, $pickedDays[$day]);
                            });
                        }
                    })->when($except, function($query) use ($except){
                        $query->where('id', '!=' , $except);
                    });
                });
            })->first();
    }

    public function checkSubjectHours($schedule, $lab = false, $except = null)
    {
        $hours = 0;

        if($schedule != null) {
            if($schedule->load(['timeSchedules']))
            {
                $timeArrays = $schedule->timeSchedules->toQuery()->where('lab', $lab)
                    ->when($except, function($query) use ($except){
                        $query->where('id', '!=', $except);
                    })->get();
                foreach($timeArrays as $array)
                {
                    foreach($this->dayNames as $day)
                    {
                        if($array->$day)
                            $hours += $array->getBlockPer(60);
                    }
                }
            }
        }

        return $hours;
    }
}

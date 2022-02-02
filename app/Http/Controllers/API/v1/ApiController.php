<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //
    public function getSchedules()
    {
        $schedules = DB::table('schedules')
            ->selectRaw(
                '*, courses.name as course_name, rooms.name as room_name, departments.name as dept_name, subjects.code as subject_code,
                CONCAT(sections.year,sections.term,"-",courses.code,"-0",sections.block) as section_name'
            )
            ->join('time_schedules', 'schedules.id', 'time_schedules.schedule_id')
            ->leftJoin('rooms', 'time_schedules.room_id', 'rooms.id')
            ->leftJoin('faculties', 'schedules.faculty_id', 'faculties.id')
            ->join('subjects', 'schedules.subject_id', 'subjects.id')
            ->join('sections', 'schedules.section_id', 'sections.id')
            ->join('courses', 'sections.course_id', 'courses.id')
            ->join('departments', 'courses.department_id', 'departments.id')
            ->orderBy('departments.name')
            ->orderBy('courses.name')
            ->orderBy('schedules.section_id')
            ->get();
        return response()->json($schedules);
    }
}

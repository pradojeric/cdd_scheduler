<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Faculties;
use App\Http\Resources\Schedule as ResourcesSchedule;
use App\Models\Faculty;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //
    public function getSchedules(Request $request)
    {
        // $schedules = DB::table('schedules')
        //     ->selectRaw(
        //         '*, courses.name as course_name, rooms.name as room_name, departments.name as dept_name, subjects.code as subject_code,
        //         CONCAT(sections.year,sections.term,"-",courses.code,"-0",sections.block) as section_name'
        //     )
        //     ->join('time_schedules', 'schedules.id', 'time_schedules.schedule_id')
        //     ->leftJoin('rooms', 'time_schedules.room_id', 'rooms.id')
        //     ->leftJoin('faculties', 'schedules.faculty_id', 'faculties.id')
        //     ->join('subjects', 'schedules.subject_id', 'subjects.id')
        //     ->join('sections', 'schedules.section_id', 'sections.id')
        //     ->join('courses', 'sections.course_id', 'courses.id')
        //     ->join('departments', 'courses.department_id', 'departments.id')
        //     ->orderBy('departments.name')
        //     ->orderBy('courses.name')
        //     ->orderBy('schedules.section_id')
        //     ->get();


        $schedules = Schedule::with([
                'faculty',
                'section' => function ($query) use ($request) {
                    $query->where('school_year', $request->school_year)
                        ->where('term', $request->term);
                },
                'room',
                'subject',
                'subject.course'
            ])
            ->without([
                'timeSchedules'
            ])
            ->get();

        return response()->json(ResourcesSchedule::collection($schedules));
    }

    public function getFaculties(Request $request)
    {
        $faculties = Faculty::when($request->code != '', function ($query) use ($request) {
            $query->whereHas('department', function($query) use ($request) {
                $query->where('code', $request->code);
            });
        })->get();


        return response()->json(Faculties::collection($faculties));
    }

}

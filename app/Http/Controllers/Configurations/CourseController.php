<?php

namespace App\Http\Controllers\Configurations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configurations\Course;
use App\Models\Configurations\Department;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $courses = Course::orderBy('name')->get();
        return view('pages.configurations.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $departments = Department::orderBy('name')->get();
        return view('pages.configurations.courses.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'department_id' => 'required',
            'code' => 'required',
            'name' => 'required',
        ]);

        Course::create([
            'department_id' => $request->department_id,
            'code' => $request->code,
            'name' => $request->name,
        ]);

        if($request->has('more')){
            return redirect()->route('courses.create')->with('success', 'Subject successfully added');
        }

        return redirect()->route('courses.index')->with('success', 'Course Successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
        return view('pages.curricula.index', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
        $departments = Department::orderBy('name')->get();
        return view('pages.configurations.courses.edit', compact('course','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
        $request->validate([
            'department_id' => 'required',
            'code' => 'required',
            'name' => 'required',
        ]);

        $course->update([
            'department_id' => $request->department_id,
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return redirect()->route('courses.index')->with('success', 'Course Successfully added!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    public function showAllSections(Course $course)
    {
        return view('pages.sections.show-all-sections', compact('course'));
    }
}

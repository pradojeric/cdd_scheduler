<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Configurations\Course;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $subjects = Subject::orderBy('code')->get();
        return view('pages.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $courses = Course::all();
        return view('pages.subjects.create', compact('courses'));
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
            'course_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'units' => 'required|numeric|min:1',
        ]);

        Subject::create([
            'course_id' => $request->course_id,
            'code' => $request->code,
            'name' => $request->name,
            'units' => $request->units,
        ]);

        if($request->has('more')){
            return redirect()->route('subjects.create')->with('success', 'Subject successfully added');
        }

        return redirect()->route('subjects.index')->with('success', 'Subject successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
        $courses = Course::all();
        return view('pages.subjects.edit', compact('subject', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'course_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'units' => 'required|numeric|min:1',
        ]);

        $subject->update([
            'course_id' => $request->course_id,
            'code' => $request->code,
            'name' => $request->name,
            'units' => $request->units,
        ]);


        return redirect()->route('subjects.index')->with('success', 'Subject successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }
}

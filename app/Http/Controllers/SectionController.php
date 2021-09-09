<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configurations\Department;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('pages.sections.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $departments = Department::all();
        return view('pages.sections.create', compact('departments'));
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
            'name' => 'required',
            'department' => 'required|exists:departments,id',
        ]);

        Section::create([
            'name' => $request->name,
            'department_id' => $request->department,
            'graduating' => $request->graduating ?? false
        ]);

        if($request->has('more')){
            return redirect()->route('sections.create')->with('success', 'Section successfully added');
        }

        return redirect()->route('sections.index')->with('success', 'Section successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
        return view('pages.sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
        $departments = Department::all();
        return view('pages.sections.edit', compact('section', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        //
        $request->validate([
            'name' => 'required',
            'department' => 'required|exists:departments,id',
        ]);

        $section->update([
            'name' => $request->name,
            'department_id' => $request->department,
            'graduating' => $request->graduating ?? false
        ]);


        return redirect()->route('sections.index')->with('success', 'Section successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
}

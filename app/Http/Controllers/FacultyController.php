<?php

namespace App\Http\Controllers;

use Str;
use Hash;
use App\Models\User;
use App\Models\Faculty;
use Carbon\CarbonInterval;
use App\Models\TimeSchedule;
use Illuminate\Http\Request;
use App\Services\FacultyService;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\Http;
use App\Models\Configurations\Department;

class FacultyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:superadmin|admin'])->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $faculties = Faculty::with('department')->orderBy('last_name')->orderBy('first_name')->paginate(25);
        return view('pages.faculties.index', compact('faculties'));
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
        return view('pages.faculties.create', compact('departments'));
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
            'name' => 'required|unique:users,name',
            'email' => 'email|required|unique:users,email',
            'code' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'department' => 'required|exists:departments,id',
            'rate' => 'required|numeric|min:0',
        ]);

        $first_name = ucwords($request->first_name);
        $last_name = ucwords($request->last_name);
        $middle_name = ucwords($request->middle_name);
        // $name = $first_name. " ".$middle_name." ".$last_name;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('colegio2021'),
        ]);

        $user->assignRole('faculty');

        Faculty::create([
            'user_id' => $user->id,
            'code' => $request->code,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'middle_name' => $middle_name ?? null,
            'department_id' => $request->department,
            'rate' => $request->rate,
        ]);

        if($request->has('more')){
            return redirect()->route('faculties.create')->with('success', 'Faculty successfully added');
        }

        return redirect()->route('faculties.index')->with('success', 'Faculty successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty $faculty)
    {
        //
        $this->authorize('view-schedule', $faculty);

        return view('pages.faculties.show', compact('faculty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        //
        $departments = Department::all();
        return view('pages.faculties.edit', compact('departments', 'faculty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty $faculty)
    {
        //
        $request->validate([
            'name' => 'required|unique:users,name,'.$faculty->user->id,
            'email' => 'email|required|unique:users,email,'.$faculty->user->id,
            'code' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'department' => 'required|exists:departments,id',
            'rate' => 'required|numeric|min:0',
        ]);

        $first_name = ucwords($request->first_name);
        $last_name = ucwords($request->last_name);
        $middle_name = ucwords($request->middle_name);

        if($faculty->user == null ){

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('colegio2021'),
            ]);

            $user->assignRole('faculty');
        }else{
            $faculty->user()->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user = $faculty->user;
        }

        $faculty->update([
            'user_id' => $user->id,
            'code' => $request->code,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'middle_name' => $middle_name ?? null,
            'department_id' => $request->department,
            'rate' => $request->rate,
            'status' => $request->status ?? false,
        ]);


        return redirect()->route('faculties.index')->with('success', 'Faculty successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        //
        $faculty->delete();

        return redirect()->route('faculties.index')->with('success', 'Faculty successfully deleted');
    }

    public function storeStep()
    {

        $token = config('step.step.token');
        $url = config('step.step.url');

        $faculties = Faculty::with(['user', 'department'])->get();


        $response = Http::withToken($token)
            ->accept('application/json')
            ->post($url.'/api/faculties/store', $faculties->toArray());

        dd($response->json());

    }
}

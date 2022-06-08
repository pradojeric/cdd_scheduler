<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {

        $faculties = Faculty::with(['schedules', 'schedules.subject'])->orderBy('last_name')->orderBy('first_name')->take(10)->get();

        return view('dashboard', compact('faculties'));
    }
}

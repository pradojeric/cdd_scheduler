<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $faculties = Faculty::orderBy('last_name')->orderBy('first_name')->get();

        return view('dashboard', compact('faculties'));
    }
}

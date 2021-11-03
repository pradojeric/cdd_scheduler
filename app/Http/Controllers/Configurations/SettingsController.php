<?php

namespace App\Http\Controllers\Configurations;


use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.configurations.settings.index');
    }

    public function changePassword()
    {
        return view('pages.configurations.settings.change-password');
    }

    public function updatePassword(Request $request)
    {
        if(Hash::check($request->old, Auth::user()->password)){

            $request->validate([
                'password' => 'required|confirmed',
            ]);

            Auth::user()->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect('/')->with('success', 'Password successfully changed');
        }

        return back()->withErrors( 'Incorrect password');
    }

    public function rolesAndPermissions()
    {
        return view('pages.configurations.roles_and_permissions.index');
    }

    public function backupDatabase()
    {


    }

}

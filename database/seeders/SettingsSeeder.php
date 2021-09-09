<?php

namespace Database\Seeders;

use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $year = Carbon::now()->year;
        $nextYear = Carbon::now()->addYear()->year;
        DB::table('settings')->insert([
            'school_year' => $year."-".$nextYear,
            'term' => 1,
        ]);
    }
}

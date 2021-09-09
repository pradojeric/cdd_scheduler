<?php

namespace Database\Seeders;

use App\Models\Configurations\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $department = Department::create([
            'code' => 'SITE',
            'name' => 'SCHOOL OF INFORMATION TECHNOLOGY EDUCATION',
        ]);

        $department->courses()->create([
            'name' => 'BS INFORMATION TECHNOLOGY',
            'code' => 'ITE',
        ]);
    }
}

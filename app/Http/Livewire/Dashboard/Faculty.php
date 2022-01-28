<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Configurations\Department;
use Livewire\Component;
use App\Models\Configurations\Settings;
use App\Models\Faculty as FacultyModel;

class Faculty extends Component
{
    public $selectedDepartment;

    public function render()
    {
        $faculties = FacultyModel::with(['schedules', 'schedules.subject'])->when($this->selectedDepartment != '', function($query){
            $query->where('department_id', $this->selectedDepartment);
        })->get();

        $allRemaining = $faculties->sum(function($item){
            return $item->countRemainingUnits();
        });

        $usedUnits = $faculties->sum(function($item){
            return $item->countUnits();
        });

        $totalUnits = $faculties->sum('rate');

        if($totalUnits > 0) {

            $remaining = ($allRemaining / $totalUnits) * 100;
            $used = ($usedUnits / $totalUnits) * 100;
        }else{
            $remaining = 100;
            $used = 0;
        }

        $datasets = [ $used, $remaining ];
        $labels = ['Used Units', 'Remaining Units'];


        $this->dispatchBrowserEvent('updateFaculty', ['d' => $datasets]);

        return view('livewire.dashboard.faculty', [
            'datasets' => json_encode($datasets),
            'labels' => json_encode($labels),
            'departments' => Department::all(),
        ]);
    }
}

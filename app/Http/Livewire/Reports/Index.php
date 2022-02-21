<?php

namespace App\Http\Livewire\Reports;

use App\Models\Configurations\Course;
use App\Models\Configurations\Department;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $readyToLoad = false;

    public $selectedCourse = '';
    public $selectedDept = '';

    public $reportType = 'section';

    public function loadInit()
    {
        $this->readyToLoad = true;
    }

    public function updatingSelectedDept()
    {
        $this->resetPage();
    }

    public function updatingSelectedCourse()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.reports.index', [
            'courses' => $this->readyToLoad ? Course::with([
                    'department',
                    'sections',
                    'subjects'
                    ])
                ->when($this->selectedCourse != '', function ($query) {
                    $query->whereId($this->selectedCourse);
                })
                ->when($this->selectedDept != '', function ($query) {
                    $query->whereHas('department', function ($query) {
                        $query->whereId($this->selectedDept);
                    });
                })
                ->orderBy('name')
                ->paginate(1)
                : [],
            'allDept' => Department::orderBy('name')->get(),
            'allCourses' => Course::when($this->selectedDept != '', function ($query) {
                    $query->where('department_id', $this->selectedDept);
                })->orderBy('name')->get(),
            'departments' => Department::with([
                    'faculties',
                    'faculties.schedules',
                    'faculties.schedules.section',
                    'faculties.schedules.subject',
                ])
                ->when($this->selectedDept != '', function ($query) {
                    $query->whereId($this->selectedDept);
                })
                ->orderBy('name')
                ->paginate(1),
        ]);
    }
}

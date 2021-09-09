<?php

namespace App\Http\Livewire\Others;

use App\Models\Faculty;
use App\Models\Schedule;
use App\Services\FacultyService;
use Livewire\Component;

class AddFaculty extends Component
{
    public $isModalOpen;

    public $search = '';
    public $schedule = null;
    public $selectedFaculty = null;

    private $dayNames = [
        'M' => 'monday',
        'T' => 'tuesday',
        'W' => 'wednesday',
        'TH' => 'thursday',
        'F' => 'friday',
        'SAT' => 'saturday',
        'SUN' => 'sunday'
    ];


    protected $rules = [
        'selectedFaculty' => 'required'
    ];

    protected $messages = [
        'selectedFaculty.required' => 'A faculty is required',
    ];

    protected $listeners = [
        'addFaculty'
    ];

    public function addFaculty(Schedule $schedule)
    {
        $this->isModalOpen = true;
        $this->schedule = $schedule;
    }

    public function selectFaculty(Faculty $faculty)
    {

        $this->selectedFaculty = $faculty;
    }

    public function updateFaculty()
    {
        $this->validate();
        if($this->selectedFaculty->hasNoUnits())
        {
            $this->addError('error', 'The faculty has no units');
            return;
        }
        $exists = false;
        $pickedDays = [];

        // dd($this->schedule->timeSchedules);
        foreach($this->schedule->timeSchedules as $schedule) {
            foreach($this->dayNames as $day)
            {
                $pickedDays[$day] = $schedule->$day;
            }
            $exists = resolve(FacultyService::class)->checkFacultyConflict($this->selectedFaculty, $schedule->start, $schedule->end, $pickedDays);

            if($exists)
            {
                $this->addError('error', 'Faculty is conflicted to other schedule');
                return;
            }
        }

        $this->emitUp('updateFaculty', $this->schedule, $this->selectedFaculty);
        $this->close();
    }

    public function close()
    {
        $this->reset();
    }

    public function render()
    {

        $suggestedFaculties = [];

        if($this->schedule){

            $suggestedFaculties = resolve(FacultyService::class)->getPreferredFaculty($this->schedule->subject) ?? Faculty::where(function($query){
                    $query->where('department_id', $this->schedule->section->course->department_id);
                }
            )->orderBy('name')->get();
        }

        $faculties = Faculty::query();

        $faculties->when($this->search != '', function($query){
            $query->whereRaw("UPPER(name) LIKE '%". strtoupper($this->search) ."%'");
        })->orderBy('name');

        return view('livewire.others.add-faculty', [
            'faculties' => $faculties->get(),
            'suggestedFaculties' => $suggestedFaculties,
        ]);
    }
}

<?php

namespace App\Http\Livewire\Others;

use App\Models\Faculty;
use App\Models\Schedule;
use App\Services\FacultyService;
use Livewire\Component;

use Illuminate\Support\Facades\Http;

class AddFaculty extends Component
{
    public $isModalOpen;

    public $search = '';
    public $schedule = null;
    public $selectedFaculty = null;
    public $override = false;

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
        if(!$this->override){
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
        }

        $this->emitUp('updateFaculty', $this->schedule, $this->selectedFaculty);

        // update faculty (step)
        $sy = $this->schedule->school_year;
        $section = $this->schedule->section->section_name;
        $room_name = $this->schedule->subject->title;

        if($this->schedule->lab) {
            $room_name = $room_name . " (Laboratory)";
        }

        $step_room = [
            'name' => $room_name,
            'section' => $section,
            'sy' => $sy,
            'faculty' => ['firstname' => $this->selectedFaculty->first_name, 'lastname' => $this->selectedFaculty->last_name, 'email' => $this->selectedFaculty->user->email ]
        ];

        $token = config('step.step.token');
        $url = config('step.step.url');

        $response = Http::withToken($token)
            ->accept('application/json')
            ->post($url.'/api/rooms/update/teacher', $step_room);

        if($response->failed()) {
            dd($response->throw());
        }
        dd($response->json());

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

            $suggestedFaculties = resolve(FacultyService::class)->getPreferredFaculty($this->schedule->subject) ?? Faculty::active()->where(function($query){
                    $query->where('department_id', $this->schedule->section->course->department_id);
                }
            )->orderBy('last_name')->get();
        }

        $faculties = Faculty::query();

        $faculties->when($this->search != '', function($query){
            $query->whereRaw("UPPER(last_name) LIKE '%". strtoupper($this->search) ."%'");
        })->orderBy('last_name');

        return view('livewire.others.add-faculty', [
            'faculties' => $faculties->get(),
            'suggestedFaculties' => $suggestedFaculties,
        ]);
    }
}

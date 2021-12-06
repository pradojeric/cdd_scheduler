<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Room;
use App\Models\Faculty;
use App\Models\Section;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Schedule;
use App\Models\TimeSchedule;
use App\Services\RoomService;
use App\Services\FacultyService;
use App\Services\SectionService;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\DB;
use App\Models\Configurations\Settings;

class Schedulers extends Component
{
    public $dayNames = [
        'M' => 'monday',
        'T' => 'tuesday',
        'W' => 'wednesday',
        'TH' => 'thursday',
        'F' => 'friday',
        'SAT' => 'saturday',
        'SUN' => 'sunday'
    ];

    public $config;

    public $selectedCourse = '';
    public $selectedSection = '';
    public $sectionModel;

    public $selectedSubject = '';
    public $selectedFaculty = '';
    public $allFaculties = false;
    public $allRooms = false;

    public $selectedBuilding = '';
    public $selectedRoom = '';
    public $override = false;

    public $startingTime = "7:00";
    public $endingTime = "19:00";

    public $start = '';
    public $end = '';
    public $pickedDays = [];
    public $hours = 0;

    public $scheds = [];
    public $gridReport = 'faculty';

    protected $rules = [
        'selectedSection' => 'required',
        'selectedSubject' => 'required',
        'start' => 'required',
        'end' => 'required',
    ];

    public function mount()
    {
        $this->config = Settings::first();
        $this->resetDay();
        $this->pickedDays = collect($this->dayNames)
            ->mapWithKeys(fn ($day) => [$day => 0]);
    }

    public function updatedAllFaculties()
    {
        $this->reset('selectedFaculty');
    }

    public function updatedSelectedBuilding()
    {
        $this->selectedRoom = '';
    }

    public function resetDay()
    {
        $this->pickedDays = collect($this->dayNames)
            ->mapWithKeys(fn ($day) => [$day => 0]);
    }

    public function updated()
    {
        $this->resetErrorBag();
    }

    public function deleteSchedule($index)
    {
        Schedule::find($index)->delete();
    }

    public function checkErrors()
    {
        $errors = false;

        if( (strtotime($this->startingTime) > strtotime($this->start) || strtotime($this->endingTime) < strtotime($this->start)) ||
        (strtotime($this->startingTime) > strtotime($this->end) || strtotime($this->endingTime) < strtotime($this->end)) )
        {
            $this->addError('time', 'Invalid time');
            $errors = true;
        }

        if($this->selectedRoom == null)
        {
            $this->addError('room', "Please select a room");
            $errors = true;
        }

        $checkTimeConflict = resolve(SectionService::class)->checkSectionTime($this->selectedSection, $this->start, $this->end, $this->pickedDays);

        if($checkTimeConflict)
        {
            $this->addError('conflict', 'Time is conflict to another subject');
            $errors = true;
        }

        $occupiedRoom = resolve(RoomService::class)->checkOccupiedRoom($this->selectedRoom, $this->start, $this->end, $this->pickedDays);

        if($occupiedRoom){
            $this->addError('room_occupied', "Room is already occupied");
            $errors = true;
        }

        if($this->selectedFaculty)
        {
            $faculty = Faculty::find($this->selectedFaculty);
            $checkFacultyConflict = resolve(FacultyService::class)->checkFacultyConflict($faculty, $this->start, $this->end, $this->pickedDays);

            if($faculty->hasNoUnits())
            {
                $this->addError('error', 'The faculty has no remaining units');
                $errors = true;
            }

            if($checkFacultyConflict){
                $this->addError('faculty_conflict', "Faculty is conflict to another time");
                $errors = true;
            }
        }

        return $errors;
    }

    public function addSchedule()
    {
        $this->validate();

        $selectedDay = 0;
        foreach($this->pickedDays as $day)
        {
            if($day){
                $selectedDay++;
            }
        }

        if($selectedDay < 1) {
            $this->addError('day', 'You must have selected at least 1 day');
            return;
        }

        if(!$this->override)
        {
            $errors = $this->checkErrors();
            if($errors)
                return;
        }

        $isLab = false;
        if(!is_numeric($this->selectedSubject)){
            $isLab = true;
        }

        $this->selectedSubject = intval($this->selectedSubject);
        $section = Section::find($this->selectedSection);
        $faculty = Faculty::find($this->selectedFaculty);
        $subjectCode = Subject::find($this->selectedSubject)->code;
        $subject = Subject::where('code', $subjectCode)->where('course_id', $section->course_id)->first();

        if(!$subject){
            $this->addError('custom_error', 'Subject not suitable for this section!');
            return;
        }

        $data = [
            'school_year' => $this->config->getRawOriginal('school_year'),
            'term' => $this->config->term,
            'section_id' => $section->id,
            'subject_id' => $subject->id,
            'faculty_id' => $faculty->id ?? null,
        ];

        $schedule = Schedule::where('section_id', $this->selectedSection)
            ->where('subject_id', $subject->id)
            ->where('term', $this->config->term)
            ->where('school_year', $this->config->getRawOriginal('school_year'))
            ->first();

        $hours = 0;
        foreach($this->pickedDays as $day)
        {
            if($day)
                $hours += abs((strtotime($this->end) - strtotime($this->start))) / 3600;
        }

        $hours += resolve(SectionService::class)->checkSubjectHours($schedule, $isLab);

        if(isset($isLab) && $isLab)
        {
            if($subject->hasLab())
            {
                if($hours > $subject->lab_hours)
                {
                    $this->addError('subject', 'Hours exceeded to subject recommended lab hours');
                    return;
                }
            }
            else
            {
                $this->addError('subject', 'This subject has no lab. Contact administrator.');
                return;
            }
        }
        else
        {
            if($hours > $subject->lec_hours)
            {
                $this->addError('subject', 'Hours exceeded to subject recommended lecture hours');
                return;
            }
        }

        if(!$schedule)
        {
            if($faculty)
            {
                if($faculty->countRemainingUnits() - $subject->totalUnits() < 0)
                {
                    $this->addError('error', 'The faculty has no remaining units');
                    return;
                }
            }
        }


        try{
            DB::beginTransaction();

            $timeScheds = collect([
                'start' => $this->start,
                'end' => $this->end,
                'room_id' => $this->selectedRoom == '' ? null : $this->selectedRoom,
                'lab' => $isLab ?? false,
            ])->merge($this->pickedDays)->toArray();

            if($schedule){
                $schedule->update($data);
            }else{
                $schedule = Schedule::create($data);
            }
            $schedule->timeSchedules()->create($timeScheds);

            DB::commit();
        }catch (Exception $e){
            DB::rollback();
            dd($e);
        }

        $this->reset('selectedBuilding' ,'start', 'end', 'pickedDays', 'hours');
        $this->resetDay();

        session()->flash('success', 'Schedule successfully added');
    }

}

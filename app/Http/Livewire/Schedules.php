<?php

namespace App\Http\Livewire;

use App\Models\Room;
use App\Models\Faculty;
use App\Models\Section;
use App\Models\Subject;
use App\Models\TimeSchedule;
use App\Services\RoomService;
use App\Services\FacultyService;
use App\Services\SectionService;
use App\Services\ScheduleService;
use App\Models\Configurations\Course;
use App\Models\Configurations\Building;

class Schedules extends Schedulers
{
    // private $dayNames = [
    //     'M' => 'monday',
    //     'T' => 'tuesday',
    //     'W' => 'wednesday',
    //     'TH' => 'thursday',
    //     'F' => 'friday',
    //     'SAT' => 'saturday',
    //     'SUN' => 'sunday'
    // ];
    // public $config;

    // public $selectedCourse = '';
    // public $selectedSection = '';
    // public $sectionModel;

    // public $selectedSubject = '';
    // public $selectedFaculty = '';
    // public $allFaculties = false;

    // public $selectedBuilding = '';
    // public $selectedRoom = '';
    // public $override = false;

    // public $startingTime = "7:00";
    // public $endingTime = "19:00";

    // public $start = '';
    // public $end = '';
    // public $pickedDays = [];
    // public $hours = 0;

    // public $scheds = [];
    // public $gridReport = 'faculty';

    // protected $rules = [
    //     'selectedCourse' => 'required',
    //     'selectedSection' => 'required',
    //     'selectedSubject' => 'required',
    //     'start' => 'required',
    //     'end' => 'required',
    // ];

    // public function mount()
    // {
    //     $this->config = Settings::first();
    //     $this->resetDay();
    //     $this->pickedDays = collect($this->dayNames)
    //         ->mapWithKeys(fn ($day) => [$day => 0]);
    // }

    public function updatedSelectedCourse()
    {
        $this->reset('selectedSubject', 'selectedRoom', 'selectedBuilding', 'selectedSection');
    }

    public function updatedSelectedSection()
    {
        $this->sectionModel = Section::find($this->selectedSection);
        $this->reset('selectedSubject', 'selectedRoom', 'selectedBuilding');
    }

    // public function updatedSelectedBuilding()
    // {
    //     $this->selectedRoom = '';
    // }

    // public function resetDay()
    // {
    //     $this->pickedDays = collect($this->dayNames)
    //         ->mapWithKeys(fn ($day) => [$day => 0]);
    // }

    // public function updated()
    // {
    //     $this->resetErrorBag();
    // }

    // public function deleteSchedule($index)
    // {
    //     Schedule::find($index)->delete();
    // }

    // public function addSchedule()
    // {
    //     $this->validate();

    //     $selectedDay = 0;
    //     foreach($this->pickedDays as $day)
    //     {
    //         if($day){
    //             $selectedDay++;
    //         }
    //     }

    //     if($selectedDay < 1) {
    //         $this->addError('day', 'You must have selected at least 1 day');
    //         return;
    //     }

    //     if(!$this->override)
    //     {
    //         if( (strtotime($this->startingTime) > strtotime($this->start) || strtotime($this->endingTime) < strtotime($this->start)) ||
    //                 (strtotime($this->startingTime) > strtotime($this->end) || strtotime($this->endingTime) < strtotime($this->end)) )
    //         {
    //             $this->addError('time', 'Invalid time');
    //             return;
    //         }

    //         if($this->selectedRoom == null)
    //         {
    //             $this->addError('room', "Please select a room");
    //             return;
    //         }

    //         $checkTimeConflict = resolve(SectionService::class)->checkSectionTime($this->selectedSection, $this->start, $this->end, $this->pickedDays);

    //         if($checkTimeConflict)
    //         {
    //             $this->addError('conflict', 'Time is conflict to another subject');
    //             return;
    //         }

    //         $occupiedRoom = resolve(RoomService::class)->checkOccupiedRoom($this->selectedRoom, $this->start, $this->end, $this->pickedDays);

    //         if($occupiedRoom){
    //             $this->addError('room_occupied', "Room is already occupied");
    //             return;
    //         }

    //         $faculty = Faculty::find($this->selectedFaculty);
    //         $checkFacultyConflict = resolve(FacultyService::class)->checkFacultyConflict($faculty, $this->start, $this->end, $this->pickedDays);

    //         if($checkFacultyConflict){
    //             $this->addError('faculty_conflict', "Faculty is conflict to another time");
    //             return;
    //         }
    //     }


    //     $isLab = false;
    //     if(!is_numeric($this->selectedSubject)){
    //         $isLab = true;
    //     }

    //     $this->selectedSubject = intval($this->selectedSubject);
    //     $subject = Subject::find($this->selectedSubject);

    //     $data = [
    //         'school_year' => $this->config->getRawOriginal('school_year'),
    //         'term' => $this->config->term,
    //         'section_id' => $this->selectedSection,
    //         'subject_id' => $subject->id,
    //     ];

    //     $schedule = Schedule::where('section_id', $this->selectedSection)
    //         ->where('subject_id', $subject->id)
    //         ->where('term', $this->config->term)
    //         ->where('school_year', $this->config->getRawOriginal('school_year'))
    //         ->first();

    //     $hours = 0;
    //     foreach($this->pickedDays as $day)
    //     {
    //         if($day)
    //             $hours += abs((strtotime($this->end) - strtotime($this->start))) / 3600;
    //     }

    //     $hours += resolve(SectionService::class)->checkSubjectHours($schedule, $isLab);


    //     if(isset($isLab) && $isLab)
    //     {
    //         if($subject->hasLab())
    //         {
    //             if($hours > $subject->lab_hours)
    //             {
    //                 $this->addError('subject', 'Hours exceeded to subject recommended lab hours');
    //                 return;
    //             }
    //         }
    //         else
    //         {
    //             $this->addError('subject', 'This subject has no lab. Contact administrator.');
    //             return;
    //         }
    //     }
    //     else
    //     {
    //         if($hours > $subject->lec_hours)
    //         {
    //             $this->addError('subject', 'Hours exceeded to subject recommended lecture hours');
    //             return;
    //         }
    //     }

    //     try{
    //         DB::beginTransaction();

    //         $timeScheds = collect([
    //             'start' => $this->start,
    //             'end' => $this->end,
    //             'room_id' => $this->selectedRoom,
    //             'lab' => $isLab ?? false,
    //         ])->merge($this->pickedDays)->toArray();

    //         if($schedule){

    //             $schedule->update($data);
    //         }else{
    //             $schedule = Schedule::create($data);
    //         }
    //         $schedule->timeSchedules()->create($timeScheds);

    //         DB::commit();
    //     }catch (Exception $e){
    //         DB::rollback();
    //         dd($e);
    //     }

    //     $this->reset( 'selectedSubject', 'selectedRoom', 'selectedBuilding','selectedFaculty' ,'start', 'end', 'pickedDays');
    //     $this->resetDay();

    //     session()->flash('success', 'Schedule successfully added');
    // }

    public function render()
    {
        $sections = [];
        $subjects = [];
        $rooms = [];
        $faculties = [];
        $blockSubjects = [];
        $roomsAvailable = [];

        $section = Section::find($this->selectedSection);

        $sections = Section::when($this->selectedCourse, function ($query){
            $query->where('course_id', $this->selectedCourse);
        })->orderBy('year')->orderBy('block')->get();

        $subjects = Subject::when($this->selectedSection, function ($query) use ($section){
            $query->where('year', $section->year)
                ->where('term', $section->term)
                ->where('course_id', $section->course_id);
        })->get();

        if($section) {
            $blockSubjects = resolve(SectionService::class)->getSubjects($section);
        }

        if($this->start && $this->end)
        {
            $this->hours = resolve(ScheduleService::class)->checkInputHours($this->start, $this->end, $this->pickedDays);
        }

        $rooms = Room::query();

        if($this->selectedBuilding)
        {
            if(!$this->allRooms)
            {
                $rooms = resolve(RoomService::class)->getAllUnoccupiedRoom($this->start, $this->end, $this->pickedDays);
            }
            $rooms->whereHas('building', function($query) {
                $query->where('id', $this->selectedBuilding);
            });
        }

        if(!is_numeric($this->selectedSubject))
        {
            $rooms->laboratory();
        }

        if($this->allFaculties){
            $faculties = Faculty::all();
        }else{
            if($this->selectedSubject){
                $subject = Subject::find($this->selectedSubject);
                $faculties = count(resolve(FacultyService::class)->getPreferredFaculty($subject)) > 0 ? resolve(FacultyService::class)->getPreferredFaculty($subject)  : $faculties = Faculty::all();
            }
        }

        if($this->gridReport == 'faculty')
        {
            $r = TimeSchedule::whereHas('schedule', function($query) {
                $query->where('faculty_id', $this->selectedFaculty);
            });
            $get = $this->selectedFaculty;
        }

        if($this->gridReport == 'room')
        {
            $r = TimeSchedule::where('room_id', $this->selectedRoom);
            $get = $this->selectedRoom;
        }

        if($this->gridReport == 'section')
        {
            $r = TimeSchedule::whereHas('schedule', function($query) {
                $query->where('section_id', $this->selectedSection);
            });
            $get = $this->selectedSection;
        }

        $roomsAvailable = resolve(ScheduleService::class)->getTimeSchedules($r, $get);

        return view('livewire.schedules',[
            'courses' => Course::all(),
            'buildings' => Building::all(),
            'faculties' => $faculties,
            'sections' => $sections,
            'subjects' => $subjects,
            'rooms' => $rooms->get(),
            'faculties' => $faculties,
            'blockSubjects' => $blockSubjects->subjects ?? [],
            'timeRange' => $roomsAvailable,
            'days' => $this->dayNames,
        ]);
    }
}

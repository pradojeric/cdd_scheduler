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

class SchedulesByCourse extends Schedulers
{

    public function updatedSelectedCourse()
    {
        $this->reset('selectedSubject', 'selectedRoom', 'selectedBuilding', 'selectedSection');
    }

    public function updatedSelectedSection()
    {
        $this->sectionModel = Section::find($this->selectedSection);
        $this->reset('selectedSubject', 'selectedRoom', 'selectedBuilding');
    }

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

        $subjects = Subject::where('active', 1)->when($this->selectedSection, function ($query) use ($section){
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
            $faculties = Faculty::active()->get();
        }else{
            if($this->selectedSubject){
                $subject = Subject::find($this->selectedSubject);
                $faculties = count(resolve(FacultyService::class)->getPreferredFaculty($subject)) > 0 ? resolve(FacultyService::class)->getPreferredFaculty($subject)  : $faculties = Faculty::active()->get();
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

        return view('livewire.schedules-by-course',[
            'courses' => Course::orderBy('name')->get(),
            'buildings' => Building::orderBy('name')->get(),
            'faculties' => $faculties,
            'sections' => $sections,
            'subjects' => $subjects,
            'rooms' => $rooms->orderBy('name')->get(),
            'faculties' => $faculties,
            'blockSubjects' => $blockSubjects->subjects ?? [],
            'timeRange' => $roomsAvailable,
            'days' => $this->dayNames,
        ]);
    }
}

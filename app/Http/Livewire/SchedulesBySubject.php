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
use App\Models\Configurations\Building;

class SchedulesBySubject extends Schedulers
{

    public function updatedSelectedSubject()
    {
        $this->reset('selectedFaculty', 'selectedSection', 'selectedBuilding');
    }

    public function updatedSelectedSection()
    {
        $this->sectionModel = Section::find($this->selectedSection);
        $this->reset('selectedRoom', 'selectedBuilding');
    }

    public function render()
    {
        $sections = [];
        $rooms = [];
        $faculties = [];
        $roomsAvailable = [];

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

        if($this->selectedSubject) {
            $subject = Subject::find($this->selectedSubject);
            $sections = resolve(SectionService::class)->getSections($subject);

            if(!is_numeric($this->selectedSubject))
            {
                $rooms->laboratory();
            }
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

        return view('livewire.schedules-by-subject',[
            'subjects' => Subject::termSubjects($this->config->term)->orderBy('code')->get()->unique('code'),
            'faculties' => $faculties,
            'sections' => $sections,
            'buildings' => Building::all(),
            'rooms' => $rooms->get(),
            'timeRange' => $roomsAvailable,
            'days' => $this->dayNames,
        ]);
    }
}

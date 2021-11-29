<?php

namespace App\Http\Livewire;

use App\Models\Room;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\TimeSchedule;
use App\Services\RoomService;
use App\Services\FacultyService;
use App\Services\SectionService;
use App\Services\ScheduleService;
use App\Models\Configurations\Building;
use App\Models\Section;

class SchedulesByCustom extends Schedulers
{
    public function customOverride()
    {
        $this->override = true;
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

            $rooms->whereHas('building', function($query) {
                $query->where('id', $this->selectedBuilding);
            });
        }

        $sections = Section::orderBy('course_id')->orderBy('year')->orderBy('term')->orderBy('block')->get();
        $faculties = Faculty::active()->get();


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

        return view('livewire.schedules-by-custom', [
            'subjects' => Subject::orderBy('code')->get()->unique('code'),
            'faculties' => $faculties,
            'sections' => $sections,
            'buildings' => Building::all(),
            'rooms' => $rooms->orderBy('name')->get(),
            'timeRange' => $roomsAvailable,
            'days' => $this->dayNames,
        ]);
    }
}

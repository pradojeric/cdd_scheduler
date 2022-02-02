<?php

namespace App\Http\Livewire\Others;

use App\Models\Room;
use Livewire\Component;
use App\Models\TimeSchedule;
use App\Services\RoomService;
use App\Services\SectionService;
use App\Services\ScheduleService;
use App\Models\Configurations\Building;

class UpdateTimeSchedule extends Component
{
    private $dayNames = [
        'M' => 'monday',
        'T' => 'tuesday',
        'W' => 'wednesday',
        'TH' => 'thursday',
        'F' => 'friday',
        'SAT' => 'saturday',
        'SUN' => 'sunday'
    ];

    public $isModalOpen;

    public $timeSchedule;
    public $selectedBuilding = '';
    public $selectedRoom = '';
    public $override = false;

    public $allRooms = false;

    public $startingTime = "7:00";
    public $endingTime = "19:00";

    public $start = '';
    public $end = '';
    public $pickedDays = [];
    public $hours = 0;

    public $gridReport = 'room';

    protected $listeners = [
        'openUpdateSchedule'
    ];

    public function openUpdateSchedule(TimeSchedule $schedule)
    {
        $this->isModalOpen = true;
        $this->timeSchedule = $schedule;

        $this->start = $schedule->start;
        $this->end = $schedule->end;
        $this->selectedBuilding = $schedule->room->building->id;
        $this->selectedRoom = $schedule->room_id;

        foreach($this->dayNames as $day)
        {
            $this->pickedDays[$day] = $schedule->$day;
        }

    }

    public function checkNewSchedule()
    {
        $schedule = $this->timeSchedule->schedule;
        $isLab = $schedule->lab;
        $subject = $schedule->subject;
        $errors = false;

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

            $checkTimeConflict = resolve(SectionService::class)->checkSectionTime($schedule->section_id, $this->start, $this->end, $this->pickedDays, $this->timeSchedule->id);

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
        }

        $hours = 0;
        foreach($this->pickedDays as $day)
        {
            if($day)
                $hours += abs((strtotime($this->end) - strtotime($this->start))) / 3600;
        }

        $hours += resolve(SectionService::class)->checkSubjectHours($schedule, $isLab, $this->timeSchedule->id);

        if(isset($isLab) && $isLab)
        {
            if($subject->hasLab())
            {
                if($hours > $subject->lab_hours)
                {
                    $this->addError('subject', 'Hours exceeded to subject recommended lab hours');
                    $errors = true;
                }
            }
            else
            {
                $this->addError('subject', 'This subject has no lab. Contact administrator.');
                $errors = true;
            }
        }
        else
        {
            if($hours > $subject->lec_hours)
            {
                $this->addError('subject', 'Hours exceeded to subject recommended lecture hours');
                $errors = true;
            }
        }

        if($errors)
            return;

        $timeScheds = collect([
            'start' => $this->start,
            'end' => $this->end,
            'room_id' => $this->selectedRoom,
        ])->merge($this->pickedDays)->toArray();

        $this->timeSchedule->update($timeScheds);

        $this->emit('updateSchedule');
        $this->close();
    }

    public function close()
    {
        $this->reset();
    }

    public function render()
    {
        $roomsAvailable = [];

        if($this->start && $this->end)
        {
            $this->hours = resolve(ScheduleService::class)->checkInputHours($this->start, $this->end, $this->pickedDays);
        }

        if($this->timeSchedule){
            if($this->gridReport == 'room')
            {
                $get = $this->selectedRoom;
                $r = TimeSchedule::where('room_id', $get);

            }

            if($this->gridReport == 'section')
            {
                $get = $this->timeSchedule->schedule->section_id;

                $r = TimeSchedule::whereHas('schedule', function($query) use ($get) {
                    $query->where('section_id', $get);
                });


            }

            $roomsAvailable = resolve(ScheduleService::class)->getTimeSchedules($r, $get);


        }

        $rooms = Room::query();

        if($this->selectedBuilding)
        {
            if(!$this->allRooms)
            {
                $rooms = resolve(RoomService::class)->getAllUnoccupiedRoom($this->start, $this->end, $this->pickedDays, $this->timeSchedule->id);
            }
            $rooms->whereHas('building', function($query) {
                $query->where('id', $this->selectedBuilding);
            });
        }


        return view('livewire.others.update-time-schedule', [
            'timeRange' => $roomsAvailable,
            'days' => $this->dayNames,
            'buildings' => Building::all(),
            'rooms' => $rooms->get(),
        ]);
    }
}

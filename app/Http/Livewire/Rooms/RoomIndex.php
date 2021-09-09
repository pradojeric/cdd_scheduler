<?php

namespace App\Http\Livewire\Rooms;

use App\Models\Room;
use Livewire\Component;
use App\Services\RoomService;
use App\Services\ScheduleService;

class RoomIndex extends Component
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

    public $start;
    public $end;
    public $hours;
    public $pickedDays;

    public $rooms;

    public function mount()
    {
        $this->rooms = Room::orderBy('name')->get();

        $this->pickedDays = collect($this->dayNames)
            ->mapWithKeys(fn ($day) => [$day => 0]);
    }

    public function search()
    {
        $rooms = resolve(RoomService::class)->getAllUnoccupiedRoom($this->start, $this->end, $this->pickedDays);
        $this->rooms = $rooms->orderBy('name')->get();
    }

    public function clear()
    {
        $this->rooms = Room::orderBy('name')->get();
    }

    public function render()
    {

        if($this->start && $this->end)
        {
            $this->hours = resolve(ScheduleService::class)->checkInputHours($this->start, $this->end, $this->pickedDays);
        }

        return view('livewire.rooms.room-index', [
            'days' => $this->dayNames,
        ]);
    }
}

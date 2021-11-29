<?php

namespace App\Http\Livewire\Rooms;

use App\Models\Configurations\Building;
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

    public $filter;

    protected $queryString = ['filter'];

    public $rooms;

    public function mount()
    {
        $this->rooms = Room::with(['building', 'roomType'])->orderBy('name')->get();

        $this->pickedDays = collect($this->dayNames)
            ->mapWithKeys(fn ($day) => [$day => 0]);
    }

    public function updatedFilter($value)
    {
        $this->rooms = Room::when($value, function($query) use ($value){
            $query->whereHas('building', function($query) use ($value){
                $query->where('id', $value);
            });
        })->with(['building', 'roomType'])->orderBy('name')->get();
    }

    public function search()
    {
        $rooms = resolve(RoomService::class)->getAllUnoccupiedRoom($this->start, $this->end, $this->pickedDays);
        $this->rooms = $rooms->orderBy('name')->get();
    }

    public function clear()
    {
        $this->rooms = Room::with(['building', 'roomType'])->orderBy('name')->get();
    }

    public function render()
    {

        if($this->start && $this->end)
        {
            $this->hours = resolve(ScheduleService::class)->checkInputHours($this->start, $this->end, $this->pickedDays);
        }

        return view('livewire.rooms.room-index', [
            'buildings' => Building::all(),
            'days' => $this->dayNames,
        ]);
    }
}

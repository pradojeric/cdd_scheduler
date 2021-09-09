<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Carbon\CarbonInterval;
use App\Models\Room as RoomModel;
use App\Models\Configurations\Settings;

class Room extends Component
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

    public $room;

    public $start = "08:00";
    public $end = "17:30";
    public $pickedDays = [];

    public $selectedRoom = '';

    public function mount()
    {
        $this->config = Settings::first();
        $this->pickedDays = collect($this->dayNames)
            ->mapWithKeys(fn ($day) => [$day => 0]);
    }

    public function render()
    {
        $timeRange = CarbonInterval::minutes(60)->toPeriod($this->start, $this->end);

        $r = RoomModel::where('is_room', 1);

        $r->when($this->selectedRoom != '', function($query){
            $query->where('id', $this->selectedRoom);
        });

        $data = 0;
        $total = 0;
        foreach($timeRange as $time)
        {
            $t = $time->format('h:i A');

            foreach($this->dayNames as $day)
            {
                $exists = (clone $r)->whereHas('timeSchedules', function($query) use ($time, $day) {
                    $query->where(function($query) use ($time){
                        $query->where('start', '<=', $time)
                            ->where('end', '>', $time);
                    })
                    ->has('schedule')
                    ->where($day, 1);
                })->count();

                $data += $exists;
                $total += (clone $r)->get()->count();
            }

        }

        $occupied = ($data/$total) * 100;
        $unoccupied = ($total - $data)/$total * 100;

        $datasets = [ $occupied, $unoccupied ];
        $labels = ['Occupied', 'Unoccupied'];


        $this->dispatchBrowserEvent('updateChart', ['d' => $datasets]);
            // dd(json_encode($datasets));


        return view('livewire.dashboard.room', [
            'datasets' => json_encode($datasets),
            'labels' => json_encode($labels),
            'allRooms' => RoomModel::where('is_room', 1)->orderBy('name')->get(),
        ]);
    }
}

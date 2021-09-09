<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\TimeSchedule;
use Illuminate\Http\Request;
use App\Services\ScheduleService;
use App\Http\Controllers\Controller;
use App\Models\Configurations\Building;
use App\Models\Configurations\RoomType;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.rooms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $buildings = Building::all();
        $roomTypes = RoomType::all();
        return view('pages.rooms.create', compact('buildings', 'roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'name' => 'required',
            'capacity' => 'required|numeric|min:0',
            'building' => 'required|exists:buildings,id',
            'room_type' => 'nullable|exists:room_types,id',
        ]);

        Room::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'building_id' => $request->building,
            'room_type_id' => $request->room_type,
            'status' => $request->status ?? false,
            'is_room' => $request->is_room ?? false,
        ]);

        if($request->has('more')){
            return redirect()->route('rooms.create')->with('success', 'Room successfully added!');
        }

        return redirect()->route('rooms.index')->with('success', 'Room successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
        $r = TimeSchedule::whereHas('schedule', function($query) use ($room){
            $query->where('room_id', $room->id);
        });

        $schedules = resolve(ScheduleService::class)->getTimeSchedules($r, true);
        $days = [
            'M' => 'monday',
            'T' => 'tuesday',
            'W' => 'wednesday',
            'TH' => 'thursday',
            'F' => 'friday',
            'SAT' => 'saturday',
            'SUN' => 'sunday'
        ];

        return view('pages.rooms.show', compact('room', 'schedules', 'days'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
        $buildings = Building::all();
        $roomTypes = RoomType::all();
        return view('pages.rooms.edit', compact('room', 'roomTypes', 'buildings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|numeric|min:0',
            'building' => 'required|exists:buildings,id',
            'room_type' => 'nullable|exists:room_types,id',
        ]);

        $room->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'building_id' => $request->building,
            'room_type_id' => $request->room_type,
            'status' => $request->status ?? false,
            'is_room' => $request->is_room ?? false,
        ]);


        return redirect()->route('rooms.index')->with('success', 'Room successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}

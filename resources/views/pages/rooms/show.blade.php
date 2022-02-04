<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-auth-session-status :status="session('success')" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-right w-full pt-5 pr-5">
                    <a href="{{ route('rooms.edit', $room) }}"
                        class="bg-indigo-600 hover:bg-indigo-300 text-white px-2 py-1 rounded text-sm">
                        EDIT
                    </a>
                </div>
                <div class="p-6">

                    <div>
                        Room: {{ $room->name }}
                    </div>
                    <div>
                        Building: {{ $room->building->name }}
                    </div>

                    <div class="w-full overflow-x-auto mt-5">
                        Grid Report:
                        {{-- <table class="border min-w-full">
                            <thead>
                                <tr class="uppercase tracking-tighter border">
                                    <th class="w-24">Time</th>
                                    @foreach ($days as $i => $day)
                                        <th>{{ $day }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($schedules as $i => $time)
                                    <tr class="border">
                                        <td class=" h-12 flex items-start justify-center">
                                            {{ $i }}
                                        </td>
                                        @foreach ($days as $day)
                                    @if(array_key_exists($day, $time) && $time[$day])

                                        @if (strtotime($i) == strtotime($time[$day]->start))
                                            <td class="bg-blue-500 border-white border text-xs text-white w-36 text-center" rowspan={{ $time[$day]->getBlockPer(30) }}>
                                                <div>
                                                    {{ $time[$day]->schedule->subject->getCodeTitle($time[$day]->lab) }}
                                                </div>
                                                <div class="truncate w-36 mx-1 italic">
                                                    {{ $time[$day]->schedule->subject->title }}
                                                </div>
                                                <div>
                                                    {{ $time[$day]->schedule->section->section_name }}
                                                </div>
                                                <div>
                                                    {{ $time[$day]->schedule->faculty->name ?? "-" }}
                                                </div>
                                            </td>
                                        @endif

                                    @else
                                        <td>&nbsp</td>
                                    @endif
                                @endforeach
                                    </tr>
                                @endforeach

                            </tbody>
                        </table> --}}

                        <div class="w-full">
                            <div class="flex justify-around uppercase tracking-tighter border w-full">
                                <div>
                                    Time
                                </div>
                                @foreach ($days as $i => $day)
                                    <div>
                                        {{ $day }}
                                    </div>
                                @endforeach
                            </div>


                            @foreach ($schedules as $i => $time)
                                <div class="flex justify-between max-h-40 h-auto w-full">
                                    <div class="flex justify-center w-32 border px-1">
                                        {{ $i }}
                                    </div>
                                    @foreach ($days as $day)
                                        @if(array_key_exists($day, $time))
                                            <div class="flex {{ $time[$day]->count() > 1 ? 'flex-col' : '' }} w-40">

                                                @forelse ($time[$day] as $s)

                                                    <div class="{{ $time[$day]->count() > 1 ? 'bg-red-500' : 'bg-blue-500' }} text-xs text-white w-full text-center" >


                                                        @if ( strtotime($i) == strtotime($time[$day]->first()->start) )

                                                            <div class="py-2 w-full z-40">
                                                                @if(!$loop->first)
                                                                    <div class="pb-2">
                                                                        Conflict to
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    {{ $s->schedule->subject->getCodeTitle($s->lab) }}
                                                                </div>
                                                                <div class="truncate mx-1 w-32 italic">
                                                                    {{ $s->schedule->subject->title }}
                                                                </div>
                                                                <div>
                                                                    {{ $s->schedule->section->section_name }}
                                                                </div>
                                                                <div>
                                                                    {{ $s->time }}
                                                                </div>
                                                                <div>
                                                                    {{ optional($s->room)->name ?? "No Room" }}
                                                                </div>
                                                                <div>
                                                                    {{ optional($s->schedule->faculty)->name ?? "No Faculty" }}
                                                                </div>
                                                            </div>

                                                        @else

                                                            &nbsp;

                                                        @endif
                                                    </div>


                                                @empty
                                                    <div class="w-full bg-gray-300 border">&nbsp</div>
                                                @endforelse
                                            </div>
                                        @else
                                            <div class="h-full w-40 bg-gray-300 border">&nbsp</div>

                                        @endif


                                    @endforeach
                                </div>
                            @endforeach



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

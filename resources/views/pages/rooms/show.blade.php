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
                        <table class="border min-w-full">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

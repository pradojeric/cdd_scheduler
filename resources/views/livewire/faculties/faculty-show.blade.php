<div>
    <x-auth-session-status :status="session('success')" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        @hasrole('admin')
            <div class="text-right w-full pt-5 pr-5">
                <a href="{{ route('faculties.edit', $faculty) }}"
                    class="bg-indigo-600 hover:bg-indigo-300 text-white px-2 py-1 rounded text-sm">
                    EDIT
                </a>
            </div>
        @endrole
        <div class="p-6">
            <div>
                Department: {{ $faculty->department->name }}
            </div>
            <div>
                Name: {{ $faculty->name }}
            </div>
            <div>
                Units: <span class="{{ $faculty->hasNoUnits() ? 'text-red-500' : 'text-green-500' }}">{{ $faculty->countRemainingUnits() }}</span> ({{ $faculty->rate }})
            </div>
            <div class="flex justify-between">
                <div class="flex">
                    <span class="mr-2">
                        Preferred Subjects:
                    </span>
                    <div class="ml-10">
                        <ul class=" list-disc text-xs">
                            @foreach ($faculty->preferredSubjects->sortBy('subject_code') as $subject)
                            <li>
                                {{ $subject->subject_code }} - {{ $subject->subject_title }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @livewire('others.preferred-subjects', ['faculty' => $faculty])
            </div>

            <div>
                Schedules:
                <table class="table w-full border">
                    <thead>
                        <tr class="uppercase">
                            <th>Subject Code</th>
                            <th>Subject Title</th>
                            <th>Units</th>
                            <th>Section</th>
                            <th class=" w-1/3">Time and Room</th>
                        </tr>
                    </thead>
                    <tbody class="border">

                        @foreach ($faculty->schedules as $schedule)
                        <tr class="align-top">
                            <td class="px-3 text-center">{{ $schedule->subject->code }}</td>
                            <td class="px-3 text-center">{{ $schedule->subject->title }}</td>
                            <td class="px-3 text-center">{{ $schedule->subject->total_units }}</td>
                            <td class="px-3 text-center">{{ $schedule->section->section_name }}</td>
                            <td class="px-3">
                                @foreach ($schedule->timeSchedules as $list)
                                    <div class="flex justify-between">
                                        <span>
                                            {{ $list->time }} {{ $list->lab ? '(LAB)' : '' }}
                                        </span>
                                        <span>
                                            {{ $list->room->name }}
                                        </span>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border">
                        <tr class="divide-x">
                            <td colspan="2"></td>
                            <td class="text-center font-bold">{{ $faculty->countUnits()}}</td>
                            <td colspan="2" class="text-right">
                                Total Number of Hours Per Week: {{ $faculty->numberOfHoursPerWeek()}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
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
                                            {{ $time[$day]->room->name ?? "-" }}
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
    @foreach ($r as $i)
        {{ $i->id }}
    @endforeach
</div>

<div>
    <x-auth-session-status :status="session('success')" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">

            <div>
                Course: <span class="font-bold"> {{ $section->course->name }} </span>
            </div>
            <div>
                Section: <span class="font-bold"> {{ $section->section_name }} </span>
            </div>
            <div>
                Schedules
            </div>
            <div>
                <table class="min-w-full border">
                    <thead class="border">
                        <tr>
                            <th>
                                <span class="sr-only">Action</span>
                            </th>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Units</th>
                            <th class="w-1/4">Time</th>
                            <th>Room</th>
                            <th>Faculty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y ">
                        @foreach ($blockSubjects as $item)
                            <tr >
                                <td class="p-2">
                                    @if ($item->schedules->first())
                                        <button class="text-red-500 text-xs" wire:click="deleteSchedule({{ $item->schedules->first()->id }})">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    @endif
                                </td>
                                <td class="px-3">{{ $item->code }}</td>
                                <td class="px-3">{{ $item->title }}</td>
                                <td class="text-center px-3">{{ $item->totalUnits() }}</td>
                                <td class="pl-6">
                                    @if ($item->schedules->first())
                                        <ul>
                                            @foreach (optional($item->schedules->first())->timeSchedules as $s)
                                                <li>
                                                    <button class="text-xs mr-1" wire:click="$emitTo('others.update-time-schedule', 'openUpdateSchedule', {{ $s }})" >
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="text-red-500 text-xs mr-2" wire:click="deleteTimeSchedule({{ $s }})">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    {{ $s->time }} {{ $s->lab ? '(LAB)' : '' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                <td class="text-center px-3">
                                    @if ($item->schedules->first())
                                        <ul>
                                            @foreach (optional($item->schedules->first())->timeSchedules as $s)
                                                <li>{{ optional($s->room)->name ?? 'No room' }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->schedules->first())

                                        @if(!$item->schedules->first()->faculty )
                                            <button type="button" class="text-xs bg-green-500 border border-green-500 hover:bg-green-300 text-white px-2 py-1 rounded-md"
                                                wire:click.prevent="$emitTo('others.add-faculty', 'addFaculty', {{ $item->schedules->first() }})">
                                                Assign
                                            </button>
                                        @else
                                            <a href="#" class="text-indigo-500 hover:text-indigo-300" wire:click.prevent="$emitTo('others.add-faculty', 'addFaculty', {{ $item->schedules->first() }})">
                                                {{ $item->schedules->first()->faculty->name }}
                                            </a>
                                        @endif
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div>
                    <h1>Custom: </h1>
                </div>
                <table class="min-w-full border">
                    <thead class="border">
                        <tr>
                            <th>
                                <span class="sr-only">Action</span>
                            </th>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Units</th>
                            <th class="w-1/4">Time</th>
                            <th>Room</th>
                            <th>Faculty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y ">

                        @foreach ($customSubjects as $customSubject)
                            <tr >
                                <td class="p-2">
                                    @if ($customSubject->schedules->first())
                                        <button class="text-red-500 text-xs" wire:click="deleteSchedule({{ $customSubject->schedules->first()->id }})">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    @endif
                                </td>
                                <td class="px-3">{{ $customSubject->code }}</td>
                                <td class="px-3">{{ $customSubject->title }}</td>
                                <td class="text-center px-3">{{ $customSubject->totalUnits() }}</td>
                                <td class="pl-6">
                                    @if ($customSubject->schedules->first())
                                        <ul>
                                            @foreach (optional($customSubject->schedules->first())->timeSchedules as $s)
                                                <li>
                                                    <button class="text-xs mr-1" wire:click="$emitTo('others.update-time-schedule', 'openUpdateSchedule', {{ $s }})" >
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="text-red-500 text-xs mr-2" wire:click="deleteTimeSchedule({{ $s }})">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    {{ $s->time }} {{ $s->lab ? '(LAB)' : '' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                <td class="text-center px-3">
                                    @if ($customSubject->schedules->first())
                                        <ul>
                                            @foreach (optional($customSubject->schedules->first())->timeSchedules as $s)
                                                <li>{{ optional($s->room)->name }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($customSubject->schedules->first())

                                        @if(!$customSubject->schedules->first()->faculty )
                                            <button type="button" class="text-xs bg-green-500 border border-green-500 hover:bg-green-300 text-white px-2 py-1 rounded-md"
                                                wire:click.prevent="$emitTo('others.add-faculty', 'addFaculty', {{ $customSubject->schedules->first() }})">
                                                Assign
                                            </button>
                                        @else
                                            <a href="#" class="text-indigo-500 hover:text-indigo-300" wire:click.prevent="$emitTo('others.add-faculty', 'addFaculty', {{ $customSubject->schedules->first() }})">
                                                {{ $customSubject->schedules->first()->faculty->name }}
                                            </a>
                                        @endif
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
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
                                                    {{ optional($time[$day]->room)->name ?? "-" }}
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
    @livewire('others.add-faculty')
    @livewire('others.update-time-schedule')
</div>

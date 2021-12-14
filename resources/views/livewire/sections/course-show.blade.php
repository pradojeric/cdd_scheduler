<div>
    <x-auth-session-status :status="session('success')" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">

            <div>
                Course: <span class="font-bold"> {{ $course->name }} </span>
            </div>
            @foreach ($course->sections as $section)
                <div class="mt-5">
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

                            @foreach ($blockSubjects[$section->section_name]->subjects as $item)
                                <tr>
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
                    <div class="mt-2">
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

                            @foreach ($customSubjects[$section->section_name] as $customSubject)
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
            @endforeach

        </div>
    @livewire('others.add-faculty')
    @livewire('others.update-time-schedule')
</div>

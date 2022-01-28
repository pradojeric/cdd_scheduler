<div>
    <x-slot name="header">
        Reports
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 w-full">
                    <div class="flex space-x-2">
                        <div class="flex space-x-2">
                            <input type="radio" id="section" wire:model="reportType" value="section">
                            <x-label for="section" value="By Section" />
                        </div>
                        <div class="flex space-x-2">
                            <input type="radio" id="faculty" wire:model="reportType" value="faculty">
                            <x-label for="faculty" value="By Faculty" />
                        </div>
                    </div>
                    <div wire:loading class="flex justify-center">
                        Loading...
                    </div>
                    <div wire:init="loadInit" wire:loading.remove>

                        <span class="text-xs">Filter: </span>
                        <div>
                            <x-label for="selectedDept" value="Department" />
                            <x-select wire:model="selectedDept" id="selectedDept" class="w-full">
                                <option value="" selected>...</option>
                                @foreach ($allDept as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        @if($reportType == 'section')

                            <div>
                                <x-label for="selectedCourse" value="Course" />
                                <x-select wire:model="selectedCourse" id="selectedCourse" class="w-full">
                                    <option value="" selected>...</option>
                                    @foreach ($allCourses as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </x-select>
                            </div>

                            @foreach ($courses as $course)
                                <div class="mt-2">
                                    <h1 class="text-lg">{{ $course->name }}</h1>
                                    <h1 class="text-sm italic">{{ optional($course->department)->name }}</h1>

                                    @foreach ($course->sections as $section)
                                        <div class="mt-2">
                                            <a href="{{ route('sections.show', $section) }}" class="text-indigo-500 hover:text-indigo-700">
                                                {{ $section->section_name }}
                                            </a>
                                            <div class="text-sm">
                                                Schedules
                                            </div>
                                            <table class="min-w-full border">
                                                <thead class="border">
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Title</th>
                                                        <th>Units</th>
                                                        <th class="w-1/4">Time</th>
                                                        <th>Room</th>
                                                        <th>Faculty</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y ">

                                                    @foreach ($section->getBlockSubjects() as $item)
                                                        <tr>
                                                            <td class="px-2 text-center w-1/12 text-sm">{{ $item->code }}</td>
                                                            <td class="px-2 text-center w-1/3 text-sm tracking-tight">{{ $item->title }}</td>
                                                            <td class="px-2 text-center w-1/12 text-sm">{{ $item->totalUnits() }}</td>
                                                            <td class="text-center w-1/12 text-sm">
                                                                @if ($item->schedules->first())
                                                                    <ul>
                                                                        @foreach (optional($item->schedules->first())->timeSchedules as $s)
                                                                            <li>
                                                                                {{ $s->time }} {{ $s->lab ? '(LAB)' : '' }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </td>
                                                            <td class="px-2 text-center w-1/12 text-sm">
                                                                @if ($item->schedules->first())
                                                                    <ul>
                                                                        @foreach (optional($item->schedules->first())->timeSchedules as $s)
                                                                            <li>{{ optional($s->room)->name ?? 'No room' }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </td>
                                                            <td class="px-2 text-center w-max text-sm">
                                                                @if ($item->schedules->first())
                                                                    {{ optional($item->schedules->first())->faculty->name ?? 'No Faculty' }}
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                            <div class="mt-2">
                                                <div class="text-sm">Custom: </div>
                                            </div>
                                            <table class="min-w-full border">
                                                <thead class="border">
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Title</th>
                                                        <th>Units</th>
                                                        <th class="w-1/4">Time</th>
                                                        <th>Room</th>
                                                        <th>Faculty</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y ">

                                                    @foreach ($section->getCustomSubjects() as $customSubject)
                                                        <tr >
                                                            <td class="px-2 w-1/2">{{ $customSubject->code }}</td>
                                                            <td class="px-2 w-1/4 tracking-tight">{{ $customSubject->title }}</td>
                                                            <td class="text-center px-2 w-1/2">{{ $customSubject->totalUnits() }}</td>
                                                            <td class="pl-2 ">
                                                                @if ($customSubject->schedules->first())
                                                                    <ul>
                                                                        @foreach (optional($customSubject->schedules->first())->timeSchedules as $s)
                                                                            <li>
                                                                                {{ $s->time }} {{ $s->lab ? '(LAB)' : '' }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </td>
                                                            <td class="text-center px-2">
                                                                @if ($customSubject->schedules->first())
                                                                    <ul>
                                                                        @foreach (optional($customSubject->schedules->first())->timeSchedules as $s)
                                                                            <li>{{ optional($s->room)->name ?? 'No Room' }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </td>
                                                            <td class="text-center px-2 w-1/6">

                                                                    {{ optional($customSubject->schedules)->first()->faculty->name ?? 'No Faculty' }}

                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>


                                    @endforeach
                                </div>

                            @endforeach

                            <div wire:loading.remove class="mt-2">
                                @if($courses)
                                    {{ $courses->links() }}
                                @endif
                            </div>

                        @endif

                        @if($reportType == 'faculty')
                            @foreach ($departments as $dept)
                                <div class="mt-2 text-lg font-semibold tracking-wide">
                                    {{ $dept->name }}
                                </div>
                                @foreach ($dept->faculties as $faculty)
                                    @if(!$faculty->status)
                                        @continue
                                    @endif
                                    <div class="mt-2">
                                        {{ $faculty->name }}
                                    </div>
                                    <div>
                                        Units: <span class="{{ $faculty->hasNoUnits() ? 'text-red-500' : 'text-green-500' }}">{{ $faculty->countRemainingUnits() }}</span> ({{ $faculty->rate }})
                                    </div>

                                    <div class="mt-2">
                                        Schedules:
                                        <table class="table w-full border">
                                            <thead>
                                                <tr class="uppercase">
                                                    <th>Subject Code</th>
                                                    <th>Subject Title</th>
                                                    <th>Units</th>
                                                    <th>Section</th>
                                                    <th class="w-1/3">Time and Room</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y">

                                                @foreach ($faculty->schedules as $schedule)
                                                <tr class="align-top">
                                                    <td class="px-2 text-center text-sm w-1/12">{{ $schedule->subject->code }}</td>
                                                    <td class="px-2 text-center text-sm w-1/3">{{ $schedule->subject->title }}</td>
                                                    <td class="px-2 text-center text-sm">{{ $schedule->subject->total_units }}</td>
                                                    <td class="px-2 text-center text-sm">{{ $schedule->section->section_name }}</td>
                                                    <td class="px-2 text-sm">
                                                        @foreach ($schedule->timeSchedules as $list)
                                                            <div class="flex justify-between">
                                                                <span>
                                                                    {{ $list->time }} {{ $list->lab ? '(LAB)' : '' }}
                                                                </span>
                                                                <span>
                                                                    {{ optional($list->room)->name ?? 'No Room' }}
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

                                @endforeach
                                <hr>
                            @endforeach

                            <div wire:loading.remove class="mt-2">
                                @if($departments)
                                    {{ $departments->links() }}
                                @endif
                            </div>
                        @endif



                    </div>


                </div>

            </div>
        </div>
    </div>

    <div x-data class="relative" wire:loading.remove>

        <div class="absolute bottom-5 right-5">
            <x-button type="button" @click="scrollTo({top: 0, behavior: 'smooth'})" class="h-16 w-16">Top</x-button>
        </div>
    </div>

</div>




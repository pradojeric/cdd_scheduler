<div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200 flex space-x-2 min-w-full">

            <div class="flex flex-col w-1/4 space-y-2">

                <x-select class="text-sm" wire:model="selectedSubject">
                    <option value="" selected>Select Subjects</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->getSubjectTitle() }}</option>
                        @if ($subject->hasLab())
                            <option value="{{ $subject->id }}L">{{ $subject->getSubjectTitle($subject->hasLab()) }}</option>
                        @endif
                    @endforeach
                </x-select>

                @if($selectedSubject)

                    <div class="flex items-center space-x-2">
                        <div class="w-3/4">
                            <x-select class="text-sm w-full" wire:model="selectedFaculty">
                                <option value="" selected>Select Faculty</option>
                                @foreach ($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" class="{{ $faculty->hasNoUnits() ? 'text-red-500' : '' }}">{{ $faculty->name }} (RU: {{ $faculty->countRemainingUnits() }})</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="flex space-x-2">
                            <x-input type="checkbox" wire:model="allFaculties" value="1" id="allFaculties" />
                            <x-label for="allFaculties" value="All Faculties" />
                        </div>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 -mt-10">Note: RU => Remaining Units</span>
                    </div>

                    <x-select class="text-sm" wire:model="selectedSection">
                        <option value="" selected>Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </x-select>

                    <div class="flex items-center">
                        <label for="start" class="text-sm w-12" >Start</label>
                        <x-input type="time" class="h-8" id="start" wire:model="start" />
                    </div>

                    <div class="flex items-center">
                        <label for="end" class="text-sm w-12" >End</label>
                        <x-input type="time" class="h-8" id="end" wire:model="end" />
                    </div>

                    <div class="flex items-center">
                        <label for="hours" class="text-sm w-12" >Hours</label>
                        <x-input type="text" class="h-8 w-12 mr-1" id="hours" wire:model="hours" readonly /> per week
                    </div>

                    <div>
                        @foreach ($days as $day)
                            <div>
                                <x-input type="checkbox" wire:model="pickedDays.{{ $day }}" value=1 id="{{ $day }}" />
                                <label for="{{ $day }}" class="text-sm" >{{ ucfirst($day) }}</label>
                            </div>
                        @endforeach
                    </div>

                    <x-select class="text-sm" wire:model="selectedBuilding">
                        <option value="" selected>Select Building</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}">{{ $building->code }} - {{ $building->name }}</option>
                        @endforeach
                    </x-select>

                    @if($selectedBuilding != '')
                        <div class="flex items-center space-x-2">
                            <div class="w-3/4">
                                <x-select class="text-sm w-full" wire:model="selectedRoom">
                                    <option value="" selected>Select Room</option>
                                    @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }} ({{ strtolower($room->roomType->name) }} ({{ $room->capacity }}))</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="flex space-x-2">
                                <x-input type="checkbox" wire:model="allRooms" value="1" id="allRooms" />
                                <x-label for="allRooms" value="All Rooms" />
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-end mx-2">

                        <div class="flex items-center space-x-2 mr-5">
                            <x-input type="checkbox" id="override" wire:model="override" value="1" />
                            <x-label for="override" :value="__('Override')" />

                        </div>
                        <x-button wire:click="addSchedule">Add</x-button>
                    </div>

                @endif

                @if(count($sections) > 0)
                    <div class="w-full">
                        <table class="w-full">
                            <thead>
                                <th>Section</th>
                                <th>Time</th>
                                <th>Room</th>
                                <th>Faculty</th>
                            </thead>
                            <tbody class="text-xs divide-y">
                                @foreach ($sections as $item)
                                    <tr>
                                        <td class="align-top">{{ $item->section_name }}</td>
                                        <td class="pl-6">
                                            @if ($item->schedules->first())
                                                <ul>
                                                    @foreach (optional($item->schedules->first())->timeSchedules as $s)
                                                        <li>{{ $s->time }} {{ $s->lab ? '(Lab)' : '' }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->schedules->first())
                                                <ul>
                                                    @foreach (optional($item->schedules->first())->timeSchedules as $s)
                                                        <li>{{ optional($s->room)->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td class="align-top text-center">
                                            @if ($item->schedules->first())
                                                {{  optional($item->schedules->first()->faculty)->name }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-end mx-2">

                    </div>
                @endif

                <x-auth-session-status :status="session('success')" />
                @if($errors->any())
                    <div class="bg-red-600 p-2 mb-1 rounded-lg shadow-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-white text-sm">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @enderror

            </div>

            <div class="w-full overflow-x-auto">

                <div class="flex items-center space-x-2 mb-2">
                    <div class="text-xs">
                        Show Grid by:
                    </div>
                    <div>
                        <x-input type="radio" wire:model.lazy="gridReport" name="gridReport" value="faculty" id="faculty" />
                        <label for="faculty" class="text-sm" >{{ __('Faculty') }}</label>
                    </div>
                    <div>
                        <x-input type="radio" wire:model.lazy="gridReport" name="gridReport" value="room" id="room" />
                        <label for="room" class="text-sm" >{{ __('Room') }}</label>
                    </div>
                    <div>
                        <x-input type="radio" wire:model.lazy="gridReport" name="gridReport" value="section" id="section" />
                        <label for="section" class="text-sm" >{{ __('Section') }}</label>
                    </div>
                </div>

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

                        @foreach ($timeRange as $i => $time)
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
                                                <div>
                                                    {{ optional($time[$day]->room)->name ?? "-" }}
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


                    @foreach ($timeRange as $i => $time)
                        <div class="flex justify-between max-h-40 h-auto w-full">
                            <div class="flex justify-center w-32 border px-1">
                                {{ $i }}
                            </div>
                            @foreach ($days as $day)
                                @if(array_key_exists($day, $time))
                                    <div class="flex {{ $time[$day]->count() > 1 ? 'flex-col' : '' }} w-40">

                                        @forelse ($time[$day] as $s)

                                            <div class="{{ $time[$day]->count() > 1 ? 'bg-red-500 h-full' : 'bg-blue-500' }} text-xs text-white w-full text-center" >


                                                @if ( strtotime($i) == strtotime($time[$day]->first()->start) )

                                                    <div class="py-2 w-full z-40 {{ $loop->first ? 'border-t' : '' }}">
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

<div>
    @if($isModalOpen)
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!--
                Background overlay, show/hide based on modal state.

                Entering: "ease-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                Leaving: "ease-in duration-200"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!--
                Modal panel, show/hide based on modal state.

                Entering: "ease-out duration-300"
                    From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    To: "opacity-100 translate-y-0 sm:scale-100"
                Leaving: "ease-in duration-200"
                    From: "opacity-100 translate-y-0 sm:scale-100"
                    To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-7xl">
                    <div class="bg-gray-200">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <span class="uppercase font-bold">{{ __('Update Schedule') }} </span>
                        </div>

                    </div>
                    <div class="bg-white max-w-7xl w-screen px-3 py-1">
                        <div class="flex">
                            <div class="flex flex-col">
                                @if($errors->any())
                                    @foreach ($errors->all() as $error)

                                        <div class="bg-red-600 p-2 mb-1 rounded-lg shadow-sm">
                                            <span class="text-white">
                                                {{ $error }}
                                            </span>
                                        </div>
                                    @endforeach
                                @enderror
                                <span>
                                    SECTION: {{ $timeSchedule->schedule->section->section_name }}
                                </span>
                                <span>
                                    SUBJECT: {{ $timeSchedule->schedule->subject->title }}
                                </span>
                                <div class="flex flex-col space-y-2 mb-2">
                                    <div class="flex space-x-2">
                                        <x-select class="text-sm" wire:model="selectedBuilding">
                                            <option value="" selected>Select Building</option>
                                            @foreach ($buildings as $building)
                                                <option value="{{ $building->id }}">{{ $building->code }} - {{ $building->name }}</option>
                                            @endforeach
                                        </x-select>

                                        @if($selectedBuilding != '')
                                            <x-select class="text-sm" wire:model="selectedRoom">
                                                <option value="" selected>Select Room</option>
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}">{{ $room->name }} ({{ strtolower($room->roomType->name) }})</option>
                                                @endforeach
                                            </x-select>

                                            <div class="flex items-center space-x-2">
                                                <x-input type="checkbox" wire:model="allRooms" value="1" id="allRooms" />
                                                <x-label for="allRooms" value="All Rooms" />
                                            </div>
                                        @endif
                                    </div>


                                    @if($selectedBuilding != '')

                                        <div class="flex space-x-2">

                                            <div class="flex items-center">
                                                <label for="start" class="text-sm w-10" >Start</label>
                                                <x-input type="time" id="start" wire:model="start" />
                                            </div>

                                            <div class="flex items-center">
                                                <label for="end" class="text-sm w-10" >End</label>
                                                <x-input type="time"  id="end" wire:model="end" />
                                            </div>

                                            <div class="flex items-center">
                                                <label for="hours" class="text-sm w-12" >Hours</label>
                                                <x-input type="text" class="h-8 w-12 mr-1" id="hours" wire:model="hours" readonly />
                                            </div>

                                            <div class="flex items-center space-x-2">
                                                @foreach ($days as $i => $day)
                                                    <div class="flex">
                                                        <x-input type="checkbox" wire:model="pickedDays.{{ $day }}" value=1 id="{{ $day }}" />
                                                        <label for="{{ $day }}" class="text-sm ml-1" >{{ ucfirst($i) }}</label>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>

                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="w-full overflow-x-auto">

                            <div class="flex items-center space-x-2 mb-2">
                                <div class="text-xs">
                                    Show Grid by:
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

                                    @foreach ($timeRange as $i => $time)
                                        <tr class="border">
                                            <td class=" h-10 flex items-start justify-center">
                                                {{ $i }}
                                            </td>
                                            @foreach ($days as $day)
                                                @if(array_key_exists($day, $time) && $time[$day])

                                                    @if (strtotime($i) == strtotime($time[$day]->start))
                                                        <td class="bg-blue-500 border-white border text-xs text-white w-36 text-center" rowspan={{ $time[$day]->getBlockPer(30) }}>
                                                            <div>
                                                                {{ $time[$day]->schedule->subject->code }}
                                                            </div>
                                                            <div class="truncate w-36 mx-1 italic">
                                                                {{ $time[$day]->schedule->subject->title }}
                                                            </div>
                                                            <div>
                                                                {{ $time[$day]->schedule->section->section_name }}
                                                            </div>
                                                            <div>
                                                                {{ $time[$day]->room->name }}
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
                    <div class="bg-gray-200 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="checkNewSchedule"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-green-500 shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Update
                        </button>
                        <button type="button" wire:click="close"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                        <div class="flex justify-end">
                            <div class="flex items-center space-x-2 ml-5">
                                <x-input type="checkbox" id="override" wire:model="override" value="1" />
                                <x-label for="override" :value="__('Override')" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

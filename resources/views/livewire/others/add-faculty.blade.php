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
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl">
                    <div class="bg-gray-200">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <span class="uppercase font-bold">{{ _('Add Faculty for') }} {{ $schedule->subject->title }} {{ "({$schedule->section->section_name})" }}</span>
                        </div>

                    </div>
                    <div class="bg-white max-w-5xl w-screen ">
                        <div class="flex">
                            <div class="w-1/3 px-2 py-1">
                                <x-input type="text" class="w-full" wire:model="search" placeholder="Search..." />

                                <div class="flex flex-col max-h-full h-96">
                                    <div class="h-1/2 overflow-y-auto">
                                        <ul class="text-sm">
                                            @foreach ($faculties as $faculty)
                                                <a href="#" class="w-full" wire:click.prevent="selectFaculty({{ $faculty }})">
                                                    <li class="w-full my-1 px-3 py-2  rounded-lg shadow-md text-white
                                                    {{ $faculty->hasNoUnits() ? 'bg-red-500 hover:bg-red-300' : 'bg-green-500 hover:bg-green-300' }}">
                                                    {{ $faculty->name }} (RU: {{ $faculty->countRemainingUnits() }})

                                                </li>
                                            </a>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="uppercase text-sm">
                                        Suggested Faculties:

                                    </div>
                                    <div class="h-1/2 overflow-y-auto">
                                        <ul class="text-sm">
                                            @foreach ($suggestedFaculties as $suggested)
                                                <a href="#" class="w-full" wire:click.prevent="selectFaculty({{ $suggested }})">
                                                    <li class="w-full my-1 px-3 py-2  rounded-lg shadow-md text-white
                                                        {{ $suggested->hasNoUnits() ? 'bg-red-500 hover:bg-red-300' : 'bg-green-500 hover:bg-green-300' }}">
                                                        {{ $suggested->name }} (RU: {{ $faculty->countRemainingUnits() }})
                                                    </li>
                                                </a>
                                            @endforeach
                                        </ul>
                                    </div>

                                </div>
                            </div>

                            <div class="w-2/3 px-2 py-1 text-sm bg-gray-50 overflow-auto">
                                @foreach ($errors->all() as $error)
                                    <div class="bg-red-500 px-3 py-2 rounded-lg shadow-sm">
                                        <span class="text-white">{{ $error }}</span>
                                    </div>
                                @endforeach
                                <div>
                                    @if ($selectedFaculty)
                                        <div>
                                            Department: {{ $selectedFaculty->department->name }}
                                        </div>
                                        <div>
                                            Name: {{ $selectedFaculty->name }}
                                        </div>
                                        <div class="flex">
                                            <span class="mr-2">
                                                Preferred Subjects:
                                            </span>
                                            <div class="ml-10">
                                                <ul class=" list-disc text-xs">
                                                    @foreach ($selectedFaculty->preferredSubjects->sortBy('subject_code') as $subject)
                                                    <li>
                                                        {{ $subject->subject_code }} - {{ $subject->subject_title }}
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div>
                                            Units: <span class="{{ $selectedFaculty->hasNoUnits() ? 'text-red-500' : 'text-green-500' }}">{{ $selectedFaculty->countRemainingUnits() }}</span> ({{ $selectedFaculty->rate }})
                                        </div>
                                        <div>
                                            Schedules:
                                            <table class="table w-full">
                                                <tbody>

                                                    @foreach ($selectedFaculty->schedules as $schedule)
                                                    <tr class="align-top">
                                                        <td class="px-3">{{ $schedule->subject->code }}</td>
                                                        <td class="px-3">{{ $schedule->section->section_name }}</td>
                                                        <td>
                                                            @foreach ($schedule->timeSchedules as $list)
                                                                <div class="flex justify-between px-6">
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
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-200 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse items-center">

                        <button type="button" wire:click="updateFaculty"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-green-500 shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Add
                        </button>
                        <button type="button" wire:click="close"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                        <x-label for="override" :value="_('Override')" />
                        <x-input type="checkbox" id="override" wire:model="override" value="1" />
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

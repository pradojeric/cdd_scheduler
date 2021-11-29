<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <a href="{{ route('rooms.create') }}"
                class="bg-green-500 hover:bg-green-700 rounded p-2 text-white text-sm">Add
                Room</a>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="text-xs">
                        Search available rooms:
                    </span>

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
                <div>
                    <x-button type="button" wire:click="search">
                        Search
                    </x-button>
                    <x-button type="button" class="bg-red-500" wire:click="clear">
                        Clear
                    </x-button>
                </div>
            </div>
        </div>
        <hr>
        <div class="px-6 py-2 text-right">
            <x-select class="text-xs" wire:model="filter">
                <option value="">Filter Building</option>
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}">{{ $building->name }} ({{ $building->code }})</option>
                @endforeach
            </x-select>
        </div>
        <table class="min-w-full divide-y-2 divide-double">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Room</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Capacity</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Building</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Room Type</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status</th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($rooms as $room)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $room->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $room->capacity }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $room->building->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $room->roomType->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $room->status }}</td>
                    <td class="px-6 py-4 whitespace-nowrap flex justify-end space-x-2">
                        <a href="{{ route('rooms.show', $room) }}"
                            class="text-gray-600 hover:text-gray-900">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('rooms.edit', $room) }}"
                            class="text-indigo-600 hover:text-indigo-900">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

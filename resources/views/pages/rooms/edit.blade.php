<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Department') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-validation-errors></x-auth-validation-errors>
                    <form action="{{ route('rooms.update', $room) }}" method="post" class="space-y-2"
                        autocomplete="off">
                        @csrf
                        @method('put')
                        <div>
                            <x-label for="building" :value="__('Building')"></x-label>
                            <select name="building" id="building"
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mt-1 w-96">
                                <option selected disabled>Select building</option>
                                @foreach ($buildings as $building)
                                <option value="{{ $building->id }}"
                                    {{ $building->id == $room->building_id ? 'selected' : '' }}>{{ $building->name }}
                                    ({{ $building->code }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-label for="room_type" :value="__('Room Type')"></x-label>
                            <select name="room_type" id="room_type"
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mt-1 w-96">
                                <option selected disabled>Select Room Type</option>
                                @foreach ($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}"
                                    {{ $roomType->id == $room->room_type_id ? 'selected' : '' }}>{{ $roomType->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-label for="name" :value="__('Room')"></x-label>
                            <x-input id="name" type="text" name="name" :value="$room->name" class="mt-1 w-96" />
                        </div>
                        <div>
                            <x-label for="capacity" :value="__('Capacity')"></x-label>
                            <x-input id="capacity" type="text" name="capacity" :value="$room->capacity"
                                class="mt-1 w-96" />
                        </div>
                        <div class="flex">
                            <x-input type="checkbox" class="mr-2" name="status" id="status" value="1"
                                :checked="$room->status" />
                            <x-label for="status" :value="__('Active Room')"></x-label>
                        </div>
                        <div class="flex">
                            <x-input type="checkbox" class="mr-2" name="is_room" id="is_room" value="1"
                                :checked="$room->is_room " />
                            <x-label for="is_room" :value="__('Is Room')"></x-label>
                        </div>
                        <div>
                            <x-button type="submit">Update</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

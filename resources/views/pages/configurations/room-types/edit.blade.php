<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Room Type') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('room-type.update', $roomType) }}" method="post" class="space-y-2"
                        autocomplete="off">
                        @csrf
                        @method('put')
                        <div>
                            <x-label for="name" :value="__('ROOM TYPE')"></x-label>
                            <x-input id="name" type="text" name="name" :value="$roomType->name" class="mt-1 w-96" />
                        </div>
                        <div class="flex">
                            <input type="checkbox" value="1" name="lab" id="lab" class="mr-2 rounded shadow-sm" {{ $roomType->lab ? 'checked' : '' }}>
                            <x-label for="lab" :value="__('Laboratory')"></x-label>
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

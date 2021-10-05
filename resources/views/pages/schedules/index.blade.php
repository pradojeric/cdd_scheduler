<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen mx-auto sm:px-6 lg:px-8">
            {{-- <div class="flex space-x-2 mb-3">
                <a href="{{ route('schedule.course') }}" class="p-2 text-white  rounded
                    {{ request()->routeIs('schedule.course') ? 'bg-green-500 hover:bg-green-300' : 'bg-blue-500 hover:bg-blue-300' }} ">By Course</a>
                <a href="{{ route('schedule.subject') }}" class="p-2 text-white bg-blue-500 hover:bg-blue-700 rounded
                    {{ request()->routeIs('schedule.subject') ? 'bg-green-500 hover:bg-green-300' : 'bg-blue-500 hover:bg-blue-300' }}">By Subject</a>
            </div> --}}

            @livewire('schedules')

        </div>
    </div>
</x-app-layout>

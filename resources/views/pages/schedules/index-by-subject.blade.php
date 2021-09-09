<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-screen mx-auto sm:px-6 lg:px-8">
            @livewire('schedules-by-subject')

        </div>
    </div>
</x-app-layout>

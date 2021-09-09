<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-auth-session-status :status="session('success')" />
            <span class="text-xl">
                {{ $curriculum->course->name }}
            </span>
            <div class="bg-white mt-2 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    @livewire('configurations.curriculum-show', ['curriculum' => $curriculum], key($curriculum->id))
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

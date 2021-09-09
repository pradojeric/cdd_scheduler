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
                {{ $course->name }}
            </span>
            <div class="bg-white mt-2 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('courses.curricula.create', $course) }}"
                        class="bg-gray-500 hover:bg-gray-700 rounded p-2 text-white text-sm">Add
                        Curriculum</a>
                    <div class="mt-3">
                        @livewire('configurations.curriculum-index', ['course' => $course])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

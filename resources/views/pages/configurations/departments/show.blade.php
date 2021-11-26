<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Department') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-auth-session-status :status="session('success')" />
            <span class="text-xl">
                {{ $department->name }}
            </span>
            <div class="bg-white mt-2 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <div class="border p-6 shadow rounded mb-6">
                        <span class="text-lg ">
                            {{ __('COURSES') }}
                        </span>
                        <ul class="mt-2">

                            @foreach ($department->courses as $course)
                                <li>{{ $course->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="border p-6 shadow rounded">
                        <span class="text-lg ">
                            {{ __('FACULTIES') }}
                        </span>
                        <ul class="mt-2">

                            @foreach ($department->faculties as $faculty)
                                <li>{{ $faculty->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('courses.update', $course) }}" method="post" class="space-y-2"
                        autocomplete="off">
                        @csrf
                        @method('put')
                        <div>
                            <x-label for="department" :value="_('DEPARTMENT')"></x-label>

                            <x-select id="department" name="department_id" class="w-96 mt-1">
                                <option selected hidden disabled>Select Department</option>
                                @foreach ($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ $dept->id == $course->department_id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div>
                            <x-label for="code" :value="_('COURSE CODE')"></x-label>
                            <x-input id="code" type="text" name="code" :value="$course->code" class="mt-1 w-96" />
                        </div>
                        <div>
                            <x-label for="name" :value="_('COURSE NAME')"></x-label>
                            <x-input id="name" type="text" name="name" :value="$course->name" class="mt-1 w-96" />
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

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
                    <form action="{{ route('sections.update', $section) }}" method="post" class="space-y-2"
                        autocomplete="off">
                        @csrf
                        @method('put')
                        <div>
                            <x-label for="department" :value="_('Department')"></x-label>
                            <x-select id="department" name="department" class="mt-1 w-96">
                                <option selected disabled>Select Department</option>
                                @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ $dept->id == $section->department_id ? 'selected' : '' }}>{{ $dept->name }}
                                </option>
                                @endforeach
                            </x-select>
                        </div>
                        <div>
                            <x-label for="name" :value="_('Section Name')"></x-label>
                            <x-input id="name" type="text" name="name" :value="$section->name" class="mt-1 w-96" />
                        </div>
                        <div class="flex">
                            <x-input type="checkbox" class="mr-2" name="graduating" id="graduating" value="1"
                                :checked="$section->graduating " />
                            <x-label for="graduating" :value="_('Graduating')"></x-label>
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

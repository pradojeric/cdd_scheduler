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
                    <form action="{{ route('subjects.update', $subject) }}" method="post" class="space-y-2"
                        autocomplete="off">
                        @csrf
                        @method('put')
                        <div>
                            <x-label for="code" :value="_('Code')"></x-label>
                            <x-input id="code" type="text" name="code" :value="$subject->code" class="mt-1 w-96" />
                        </div>
                        <div>
                            <x-label for="name" :value="_('Name')"></x-label>
                            <x-input id="name" type="text" name="name" :value="$subject->name" class="mt-1 w-96" />
                        </div>
                        <div>
                            <x-label for="units" :value="_('Units')"></x-label>
                            <x-input id="units" type="number" name="units" :value="$subject->units" class="mt-1 w-96"
                                min=0 />
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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Faculty') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('faculties.store') }}" method="post" class="space-y-2" autocomplete="off">
                        @csrf
                        <div>
                            <x-label for="department" :value="_('Department')"></x-label>
                            <x-select id="department" name="department" class="mt-1 w-96">
                                <option selected disabled>Select Department</option>
                                @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div>
                            <x-label for="code" :value="_('Faculty Code')"></x-label>
                            <x-input id="code" type="text" name="code" :value="old('code')" class="mt-1 w-96" />
                        </div>
                        <div>
                            <x-label for="name" :value="_('First Name')"></x-label>
                            <x-input id="name" type="text" name="first_name" :value="old('first_name')" class="mt-1 w-96" />
                        </div>
                        <div>
                            <x-label for="name" :value="_('Last Name')"></x-label>
                            <x-input id="name" type="text" name="last_name" :value="old('last_name')" class="mt-1 w-96" />
                        </div>
                        <div>
                            <x-label for="rate" :value="_('Units given')"></x-label>
                            <x-input id="rate" type="number" name="rate" :value="old('rate') ?? 0" class="mt-1 w-96"
                                min=0 />
                        </div>
                        <div>
                            <x-button type="submit">Save</x-button>
                            <x-button type="submit" name="more">Save and Add More</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

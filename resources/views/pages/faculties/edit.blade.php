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
                    <form action="{{ route('faculties.update', $faculty) }}" method="post" class="space-y-2"
                        autocomplete="off">
                        @csrf
                        @method('put')
                        <div class="flex">
                            <div class="mr-10">
                                <div>
                                    <x-label for="department" :value="_('Department')"></x-label>
                                    <x-select id="department" name="department" class="mt-1 w-96">
                                        <option selected disabled>Select Department</option>
                                        @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}"
                                            {{ $dept->id == $faculty->department_id ? 'selected' : '' }}>{{ $dept->name }}
                                        </option>
                                        @endforeach
                                    </x-select>
                                </div>
                                <div>
                                    <x-label for="code" :value="_('Faculty Code')"></x-label>
                                    <x-input id="code" type="text" name="code" :value="$faculty->code" class="mt-1 w-96" />
                                </div>
                                <div>
                                    <x-label for="first_name" :value="_('First Name')"></x-label>
                                    <x-input id="first_name" type="text" name="first_name" :value="$faculty->first_name" class="mt-1 w-96" />
                                </div>
                                <div>
                                    <x-label for="middle_name" :value="_('Middle Name')"></x-label>
                                    <x-input id="middle_name" type="text" name="middle_name" :value="$faculty->middle_name" class="mt-1 w-96" />
                                </div>
                                <div>
                                    <x-label for="last_name" :value="_('Last Name')"></x-label>
                                    <x-input id="last_name" type="text" name="last_name" :value="$faculty->last_name" class="mt-1 w-96" />
                                </div>
                                <div>
                                    <x-label for="rate" :value="_('Units given')"></x-label>
                                    <x-input id="rate" type="number" name="rate" :value="$faculty->rate ?? 0" class="mt-1 w-96"
                                        min=0 />
                                </div>
                                <div class="flex">
                                    <x-input type="checkbox" class="mr-2" name="status" id="status" value="1"
                                        :checked="$faculty->status" />
                                    <x-label for="status" :value="_('Faculty status')"></x-label>
                                </div>

                            </div>
                            <div>
                                <div>
                                    <x-label for="name" :value="_('Username')"></x-label>
                                    <x-input id="name" type="text" name="name" :value="$faculty->user->name" class="mt-1 w-96" />
                                </div>
                                <div>
                                    <x-label for="email" :value="_('Email')"></x-label>
                                    <x-input id="email" type="email" name="email" :value="$faculty->user->email" class="mt-1 w-96" />
                                </div>
                                <div class="text-xs italic">
                                    Note: Default password is colegio2021
                                </div>
                            </div>
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

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
                    <x-auth-validation-errors />
                    <form action="{{ route('faculties.store') }}" method="post" class="space-y-2" autocomplete="off">
                        @csrf
                        <div class="flex">
                            <div class="mr-10">
                                <div>
                                    <x-label for="department" :value="__('Department')"></x-label>
                                    <x-select id="department" name="department" class="mt-1 w-96 text-sm">
                                        <option selected disabled>Select Department</option>
                                        @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                                <div>
                                    <x-label for="code" :value="__('Faculty ID')"></x-label>
                                    <x-input id="code" type="text" name="code" :value="old('code')" class="mt-1 w-96" />
                                </div>
                                <div>
                                    <x-label for="first_name" :value="__('First Name')"></x-label>
                                    <x-input id="first_name" type="text" name="first_name" :value="old('first_name')" class="mt-1 w-96" />
                                </div>
                                <div>
                                    <x-label for="middle_name" :value="__('Middle Name')"></x-label>
                                    <x-input id="middle_name" type="text" name="middle_name" :value="old('middle_name')" class="mt-1 w-96" />
                                </div>
                                <div>
                                    <x-label for="last_name" :value="__('Last Name')"></x-label>
                                    <x-input id="last_name" type="text" name="last_name" :value="old('last_name')" class="mt-1 w-96" />
                                </div>
                                <div>
                                    <x-label for="rate" :value="__('Units given')"></x-label>
                                    <x-input id="rate" type="number" name="rate" :value="old('rate') ?? 0" class="mt-1 w-96"
                                        min=0 />
                                </div>
                            </div>
                            <div>
                                <div>
                                    <x-label for="name" :value="__('Username')"></x-label>
                                    <x-input id="name" type="text" name="name" :value="old('name')" class="mt-1 w-96" />
                                </div>
                                <div>
                                    <x-label for="email" :value="__('Email')"></x-label>
                                    <x-input id="email" type="email" name="email" :value="old('email')" class="mt-1 w-96" />
                                </div>
                                <div class="text-xs italic">
                                    Note: Default password is colegio2021
                                </div>
                            </div>
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

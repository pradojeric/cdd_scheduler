<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Building') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('buildings.update', $building) }}" method="post" class="space-y-2"
                        autocomplete="off">
                        @csrf
                        @method('put')
                        <div>
                            <x-label for="code" :value="_('BUILDING CODE')"></x-label>
                            <x-input id="code" type="text" name="code" :value="$building->code" class="mt-1 w-96" />
                        </div>
                        <div>
                            <x-label for="name" :value="_('BUILDING NAME')"></x-label>
                            <x-input id="name" type="text" name="name" :value="$building->name" class="mt-1 w-96" />
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

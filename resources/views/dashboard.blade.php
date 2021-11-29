<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex">
                    <div class="p-6 bg-white border-b border-gray-200 w-1/2">
                        @livewire('dashboard.faculty', key('faculty'))
                        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
                            Available Faculties
                        </h2>
                        <table class="table min-w-full divide-y mt-2">
                            <thead>
                                <tr>
                                    <th class="uppercase">Faculty</th>
                                    <th class="uppercase">Remaining Units</th>
                                    <th class="uppercase">Total Units</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($faculties as $faculty)
                                    <tr>
                                        <td class="p-2">{{ $faculty->name }}</td>
                                        <td class="p-2 text-center @if($faculty->hasNoUnits()) text-red-500 @endif">{{ $faculty->countRemainingUnits() }}</td>
                                        <td class="p-2 text-center">{{ $faculty->rate }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200 w-1/2">
                        @livewire('dashboard.room', key('room'))
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Departments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-auth-session-status :status="session('success')" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('buildings.create') }}"
                        class="bg-gray-500 hover:bg-gray-700 rounded p-2 text-white text-sm">Add
                        Building</a>
                </div>
                <table class="min-w-full divide-y-2 divide-double">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Building Code</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Building Name</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($buildings as $building)

                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $building->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $building->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap"><a href="{{ route('buildings.edit', $building) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Edit</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

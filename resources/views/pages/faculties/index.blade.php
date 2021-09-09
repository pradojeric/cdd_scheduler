<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Faculties') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-auth-session-status :status="session('success')" />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('faculties.create') }}"
                        class="bg-gray-500 hover:bg-gray-700 rounded p-2 text-white text-sm">Add New Faculty</a>
                </div>
                <table class="min-w-full divide-y-2 divide-double">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Code</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Department</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rate</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($faculties as $faculty)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $faculty->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $faculty->department->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $faculty->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $faculty->rate }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $faculty->active_status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex space-x-2 justify-end">
                                <a href="{{ route('faculties.show', $faculty) }}"
                                    class="text-gray-500 hover:text-gray-300">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('faculties.edit', $faculty) }}"
                                    class="text-indigo-600 hover:text-indigo-300">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-2">
                    {{ $faculties->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

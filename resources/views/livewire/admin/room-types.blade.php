<div>
    <x-auth-session-status :status="session('success')" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <a href="{{ route('room-type.create') }}"
                class="bg-gray-500 hover:bg-gray-700 rounded p-2 text-white text-sm">Add Room Type</a>
        </div>
        <table class="min-w-full divide-y-2 divide-double">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Room Type</th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($roomTypes as $roomType)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $roomType->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap"><a href="{{ route('room-type.edit', $roomType) }}"
                            class="text-indigo-600 hover:text-indigo-900">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

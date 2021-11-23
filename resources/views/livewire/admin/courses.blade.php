<div>
    <x-auth-session-status :status="session('success')" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center space-x-3 overflow-auto">

                <div class="flex items-center">
                    <x-select wire:model="department" id="department" class="mt-1 w-auto text-sm">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </x-select>
                </div>

                <div class="flex flex-col items-start">
                    <x-input id="name" type="text" wire:model="name" class="mt-1 w-96 text-sm" placeholder="Course Name" />
                    @error('name')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col items-start">
                    <x-input id="code" type="text" wire:model="code" class="mt-1 w-auto text-sm" placeholder="Course Code" />
                    @error('code')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex">
                    @if($isEditing)
                        <x-button type="button" wire:click.prevent="updateCourse({{ $course }})" >Update</x-button>
                    @else
                        <x-button type="button" wire:click.prevent="addCourse" >Add</x-button>
                    @endif
                </div>
            </div>
        </div>
        <table class="min-w-full divide-y-2 divide-double">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Course Name</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Course Code</th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($courses as $course)

                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $course->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $course->code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                        <a href="{{ route('courses.show', $course) }}"
                            class="text-indigo-600 hover:text-indigo-900">View</a>
                        <a href="#" wire:click.prevent="editCourse({{ $course }})"
                            class="text-green-600 hover:text-green-900 ml-2">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

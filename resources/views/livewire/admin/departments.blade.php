<div>
    <x-auth-session-status :status="session('success')" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center space-x-3 w-full">
                <div class="flex flex-col items-start w-1/2">
                    <x-input id="code" type="text" wire:model="code" class="mt-1 w-full text-sm" placeholder="Department Code" />
                    @error('code')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col items-start w-1/2">
                    <x-input id="name" type="text" wire:model="name" class="mt-1 w-full text-sm" placeholder="Department Name" />
                    @error('name')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex">
                    @if($isEditing)
                        <x-button type="button" wire:click.prevent="updateDepartment({{ $department }})" >Update</x-button>
                    @else
                        <x-button type="button" wire:click.prevent="addDepartment" >Add</x-button>
                    @endif
                </div>
            </div>

        </div>
        <table class="min-w-full divide-y-2 divide-double">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Department Name</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Department Code</th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($departments as $dept)

                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $dept->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $dept->code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('departments.show', $dept) }}"
                            class="hover:text-gray-300">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="#" wire:click="editDepartment({{ $dept }})"
                            class="text-indigo-600 hover:text-indigo-300">
                            <i class="fa fa-edit"></i>
                        </a>
                        @role('superadmin')
                            <a href="#" wire:click="deleteDepartment({{ $dept }})"
                                class="text-red-600 hover:text-red-300">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endrole
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

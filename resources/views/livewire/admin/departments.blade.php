<div>
    <x-auth-session-status :status="session('success')" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center space-x-3 w-screen">
                <div class="flex flex-col items-start">
                    <x-input id="code" type="text" wire:model="code" class="mt-1 w-auto" placeholder="Department Code" />
                    @error('code')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col items-start">
                    <x-input id="name" type="text" wire:model="name" class="mt-1 w-96" placeholder="Department Name" />
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
                    <td class="px-6 py-4 whitespace-nowrap">{{ $dept->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $dept->code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap"><a href="#" wire:click="editDepartment({{ $dept }})"
                            class="text-indigo-600 hover:text-indigo-900">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

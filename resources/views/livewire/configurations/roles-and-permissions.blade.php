<div>
    <div class="flex justify-center">
        <div class="p-6 bg-white border-b border-gray-200 w-full">

            <table class="min-w-full border divide-y">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <button type="button" class="px-2 py-1 bg-green-500 hover:bg-green-700 text-white rounded" wire:click="$emit('rolesSettings')">
                                <i class="fa fa-plus"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $role->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex justify-end space-x-2">
                                <a href="#" wire:click="$emit('rolesSettings', {{ $role }})"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" wire:click="deleteRole({{ $role }})"
                                    class="text-red-600 hover:text-red-900">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>

    </div>
    @livewire('configurations.roles-settings')
</div>

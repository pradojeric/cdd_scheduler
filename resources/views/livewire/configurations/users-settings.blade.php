<div>
    <div class="flex justify-center">
        <div class="p-6 bg-white border-b border-gray-200 w-full">

            <table class="min-w-full border divide-y">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <button type="button" class="px-2 py-1 bg-green-500 hover:bg-green-700 text-white rounded" wire:click="openUserModal">
                                <i class="fa fa-plus"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach ($user->roles as $role)
                                    {{ $role->name }}
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap flex justify-end space-x-2">
                                <a href="#" wire:click="openUserModal({{ $user }})"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
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

    @if($isModalOpen)
         <!-- This example requires Tailwind CSS v2.0+ -->
         <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!--
                Background overlay, show/hide based on modal state.

                Entering: "ease-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                Leaving: "ease-in duration-200"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!--
                Modal panel, show/hide based on modal state.

                Entering: "ease-out duration-300"
                    From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    To: "opacity-100 translate-y-0 sm:scale-100"
                Leaving: "ease-in duration-200"
                    From: "opacity-100 translate-y-0 sm:scale-100"
                    To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                    <div class="bg-gray-200">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <span class="uppercase font-bold">{{ _('User') }}</span>
                        </div>

                    </div>

                    <div class="bg-white min-w-full p-2 ">
                        @if ($errors->any())
                            <div class="bg-red-500 text-sm p-3 rounded shadow-sm">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="py-2">
                            <x-input type="text" class="w-full" wire:model="name" placeholder="Name" />
                        </div>
                        <div class="py-2">
                            <x-input type="email" class="w-full" wire:model="email" placeholder="Email" />
                        </div>
                        <div class="py-2">
                            <x-select class="w-full text-sm" wire:model="role">
                                <option value="">Select Role...</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="py-2">
                            <x-input type="password" class="w-full" wire:model="password" placeholder="Password" />
                        </div>
                        <div class="py-2">
                            <x-input type="password" class="w-full" wire:model="passwordConfirmation" placeholder="Confirm Password" />
                        </div>
                    </div>
                    <div class="bg-gray-200 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="addUser" wire:loading.class="disabled"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-green-500 shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $isEditing ? 'Update' : 'Add' }}
                        </button>
                        <button type="button" wire:click="close"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

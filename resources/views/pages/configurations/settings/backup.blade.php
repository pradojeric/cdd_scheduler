<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Database Backup') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-auth-session-status :status="session()->get('success')" />
                <x-auth-validation-errors />
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('backup.create') }}" class="px-2 py-1 bg-green-500 hover:bg-green-300 text-white rounded shadow-sm">Create BackUp</a>
                    <table class="table w-full border mt-5">
                        <thead>
                            <tr>
                                <th class="tracking-tight uppercase text-gray-500 px-2 py-1 text-sm">File Name</th>
                                <th class="tracking-tight uppercase text-gray-500 px-2 py-1 text-sm w-1/3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($backups as $backup)
                                <tr class="border divide-y">
                                    <td class="px-6 py-2 text-gray-500">
                                        {{ $backup['file_name'] }}
                                    </td>
                                    <td class="text-right px-6 py-2">
                                        <a href="{{ route('backup.download', $backup['file_name']) }}" class="px-2 py-1 bg-gray-500 hover:bg-gray-300 text-white rounded shadow-sm text-sm">
                                            <i class="fa fa-download"></i>
                                            Download
                                        </a>
                                        <a href="{{ route('backup.delete', $backup['file_name']) }}" class="px-2 py-1 bg-red-500 hover:bg-red-300 text-white rounded shadow-sm text-sm ml-2">
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan=2 class="px-6 py-1 text-center tracking-tighter font-medium uppercase text-red-500">No backup</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

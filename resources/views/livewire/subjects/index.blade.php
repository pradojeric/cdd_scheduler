<div>
    <x-auth-session-status :status="session('success')" />
    @error('error')
        <div class="rounded-lg shadow-sm p-2 bg-red-700 text-center mx-2 mb-2">
            <span class="text-sm uppercase text-white">{{ $message }}</span>
        </div>
    @enderror
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex justify-end items-center p-2">
            @if($subjects->count() > 0)
                <span class=" text-yellow-700 text-xs pr-3">Warning! Some schedule may be removed after updating.</span>
                <button type="button" class="bg-green-500 px-3 py-2 text-white text-sm rounded-md shadow-sm hover:bg-green-700" wire:click="updateSubjects">
                    <div wire:loading wire:target="updateSubjects"><i class="fa fa-spinner fa-spin"></i></div>
                    Update Subject
                </button>
            @else
                <div>
                    <div wire:loading wire:target="importSubjects"><i class="fa fa-spinner fa-spin"></i></div>
                    <x-button wire:click="importSubjects" wire:loading.remove>{{ _('Import Subjects') }}</x-button>
                </div>
            @endif
        </div>
        <table class="min-w-full divide-y-2 divide-double">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Course</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Code</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Title</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Units</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($subjects as $subject)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $subject->course->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $subject->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $subject->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $subject->total_units }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan=4 class="text-center px-6 py-4">
                            Press the import button
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>
    </div>
</div>

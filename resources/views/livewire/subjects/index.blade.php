<div>
    <x-auth-session-status :status="session('success')" />
    @error('error')
    <div class="rounded-lg shadow-sm p-2 bg-red-700 text-center mx-2 mb-2">
        <span class="text-sm uppercase text-white">{{ $message }}</span>
    </div>
    @enderror
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex justify-between p-2">
            <div class="flex items-center">
                <x-label for="perPage" value="Per page:" />
                <x-select id="perPage" wire:model="perPage" class="ml-2 text-sm">
                    @foreach ($pages as $p)
                    <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="flex items-center">
                @if($subjects->count() > 0)

                <button type="button"
                    class="bg-green-500 px-3 py-2 text-white text-sm rounded-md shadow-sm hover:bg-green-700" {{--
                    wire:click="updateSubjects"> --}}
                    wire:click="$emit('openModal')">
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

        </div>
        <div class="overflow-auto mx-2 border">
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
                        <th>
                            <span class="sr-only">Action</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($subjects as $subject)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $subject->course->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $subject->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $subject->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $subject->total_units }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button type="button" class="text-red-500 hover:text-red-300" x-data
                                    x-on:click="
                                        event.preventDefault();
                                        if(confirm('Do you want to delete this subject?')){
                                            alert('Sorry! Not yet implemented');

                                        }
                                    ">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
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
        <div class="px-6 py-2 text-sm">
            {{ $subjects->links() }}
        </div>
    </div>
    @livewire('subjects.subject-modal')
</div>

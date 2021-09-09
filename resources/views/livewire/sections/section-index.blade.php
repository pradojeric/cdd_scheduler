<div>

    <x-auth-session-status :status="session('success')" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">

            <div class="flex items-center space-x-2">
                <div class="flex flex-col">
                    <x-select id="course" wire:model="course" class="mt-1 text-sm w-auto">
                        <option value="" selected hidden disabled>Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </x-select>
                    @error('course')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <x-select wire:model="year" class="mt-1 text-sm w-auto">
                        <option value="" selected hidden disabled>Select Year</option>
                        @foreach ($years as $i => $year)
                            <option value="{{ $i }}">{{ $year }}</option>
                        @endforeach
                    </x-select>
                    @error('year')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center">
                        <x-input type="checkbox" class="mr-2"  wire:model="graduating" id="graduating" value="1"
                        :checked="$graduating ?? false " />
                        <x-label for="graduating" :value="_('Graduating')"></x-label>
                    </div>
                    @if($isEditing)
                        <x-button type="button" wire:click.prevent="updateSection({{ $section }})" >Update</x-button>
                    @else
                        <x-button type="button" wire:click.prevent="addSection" >Add</x-button>
                    @endif
                </div>
            </div>


        </div>
        <div>
            <table class="min-w-full divide-y-2 divide-double">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Course</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Section Name</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Graduating</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($sections as $section)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $section->course->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $section->section_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $section->graduating }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex space-x-2 justify-end">
                            <a href="{{ route('sections.show', $section) }}" class="hover:text-gray-500">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#" wire:click.prevent="editSection({{ $section->id }})"
                                class="text-indigo-600 hover:text-indigo-900"><i class="fa fa-edit"></i></a>
                            <a href="#" x-data x-on:click.prevent="deleteSection({{ $section->id }})"
                                class="text-red-600 hover:text-red-900"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-2">
                {{ $sections->links() }}
            </div>
        </div>

    </div>

</div>

<script>
    function deleteSection(id)
    {
        if(confirm("Are you sure about that?")){
            Livewire.emit('deleteSection', id)
        }
    }
</script>

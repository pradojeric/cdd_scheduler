<div>

    <div>
        <div class="flex space-x-3 mb-3 items-center">
            <span>Option: </span>
            <button type="button" wire:click="$set('selected', 'course')" class="p-2 rounded text-white uppercase tracking-tight transition ease-in-out duration-500
                {{ $selected == 'course' ? 'bg-gray-500 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-300 transform hover:scale-105' }}">Course</button>
            <button type="button" wire:click="$set('selected', 'subject')" class="p-2 rounded text-white uppercase tracking-tight transition ease-in-out duration-500
                {{ $selected == 'subject' ? 'bg-gray-500 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-300 transform hover:scale-105' }}">Subject</button>
        </div>
        @if($selected == "course")
            @livewire('schedules-by-course', [], key('schedule-1'))
        @endif

        @if($selected == "subject")
            @livewire('schedules-by-subject', [], key('schedule-2'))
        @endif
    </div>
</div>

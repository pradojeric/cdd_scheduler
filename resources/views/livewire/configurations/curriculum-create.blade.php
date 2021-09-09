<div>
    <div class="w-full">

        @if($errors->any())
            <span class="w-full bg-red-500 text-white px-2 py-1 rounded-lg shadow-sm">
                Please fill all fields!
            </span>
        @endif

        <div class="flex justify-between">
            <a href="{{ route('courses.show', $course) }}" class="bg-red-500 hover:bg-red-400 border px-2 py-1 text-sm text-white rounded-lg" >{{ _('Back') }}</a>
            <button class="bg-green-500 hover:bg-green-400 border px-2 py-1 text-sm text-white rounded-lg" wire:click="saveCurriculum">{{ _('Save') }}</button>
        </div>
        <div>
            <x-label for="effective_sy" :value="_('Effective SY')" />
            <x-input id="effective_sy" class="border p-2" wire:model.lazy="effective_sy" />
        </div>
        <div>
            <x-label for="description" :value="_('Description')" />
            <textarea id="description" rows="1" class="w-full border border-gray-300 rounded-lg shadow-sm resize-none" wire:model.lazy="description"></textarea>
        </div>
        <div class="py-2 w-full">

                @foreach ($subjects as $i => $year)
                    <div class="py-2">
                        @foreach ($year['term'] as $j => $term)
                            <div class="py-2">
                                <span>
                                    {{ $years[$i] . " Year ". $terms[$j] }}
                                </span>
                                @if($loop->last)
                                    <button class="text-xs px-2 py-1 bg-red-500 text-white rounded-lg" wire:click="subTerm({{ $i }}, {{ $j }})"><i class="fa fa-minus"></i></button>
                                @endif
                                <table class="border-2 mt-1 w-full divide-y">

                                    <tr class="divide-x">
                                        <th class="p-2 w-32" rowspan=2>
                                            <button class="text-xs p-2 bg-green-500 text-white rounded-lg" wire:click="addSubject({{ $i }}, {{ $j }})">{{ _('Add Subject') }}</button>
                                        </th>
                                        <th class="w-28" rowspan=2>Course Code</th>
                                        <th rowspan=2>Course Title</th>
                                        <th colspan=2>Hours/Week</th>
                                        <th colspan=3>UNITS</th>
                                        <th class="w-28" rowspan=2>Pre-Requisite</th>
                                    </tr>
                                    <tr>
                                        <th class="w-12">Lec</th>
                                        <th class="w-12">Lab</th>
                                        <th class="w-12">Lec</th>
                                        <th class="w-12">Lab</th>
                                        <th class="w-12">Total</th>
                                    </tr>
                                    <tbody class="divide-y">
                                        @foreach ($term as $k => $subject)

                                            <tr class="divide-x">
                                                <td class="p-2 text-center">
                                                    <button class="bg-red-500 px-2 py-1 text-xs text-white rounded-lg" wire:click="subSubject({{ $i }}, {{ $j }}, {{ $k }})"><i class="fa fa-minus"></i></button>
                                                </td>
                                                <td class="p-2">
                                                    <x-input class="w-full" wire:model.lazy="subjects.{{ $i }}.term.{{ $j }}.{{ $k }}.code" />
                                                </td>
                                                <td class="p-2">
                                                    <x-input class="w-full" wire:model.lazy="subjects.{{ $i }}.term.{{ $j }}.{{ $k }}.title" />
                                                </td>
                                                <td class="p-2">
                                                    <x-input class="w-full" wire:model.lazy="subjects.{{ $i }}.term.{{ $j }}.{{ $k }}.lech" />
                                                </td>
                                                <td class="p-2">
                                                    <x-input class="w-full" wire:model.lazy="subjects.{{ $i }}.term.{{ $j }}.{{ $k }}.labh" />
                                                </td>
                                                <td class="p-2">
                                                    <x-input class="w-full" wire:model="subjects.{{ $i }}.term.{{ $j }}.{{ $k }}.lecu" wire:keyup="computeTotal({{ $i }}, {{ $j }}, {{ $k }})" />
                                                </td>
                                                <td class="p-2">
                                                    <x-input class="w-full" wire:model="subjects.{{ $i }}.term.{{ $j }}.{{ $k }}.labu" wire:keyup="computeTotal({{ $i }}, {{ $j }}, {{ $k }})" />
                                                </td>
                                                <td class="p-2">
                                                    <x-input class="w-full" wire:model.lazy="subjects.{{ $i }}.term.{{ $j }}.{{ $k }}.total" />
                                                </td>
                                                <td class="p-2">
                                                    <x-input class="w-full" wire:model.lazy="subjects.{{ $i }}.term.{{ $j }}.{{ $k }}.prereq" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @endforeach
                        @if(count($year['term']) < count($terms))
                            <div>
                                <button class="text-xs p-2 bg-green-500 text-white rounded-lg" wire:click="addTerm({{ $i }})">{{ _('Add Term') }}</button>
                            </div>
                        @endif
                    </div>
                @endforeach
            @if(count($subjects) < count($years))
                <x-button wire:click="addYear">{{ _('Add Year') }}</x-button>
            @endif
        </div>
    </div>
</div>

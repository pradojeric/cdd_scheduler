<div>
    List of Curriculum
    <table class="min-w-full">
        <thead>
            <tr>
                <th class="text-sm uppercase tracking-tighter w-32">Effective SY</th>
                <th class="text-sm uppercase tracking-tighter">Description</th>
                <th class="text-sm uppercase tracking-tighter w-32">Status</th>
                <th class="w-32">
                    <span class="sr-only">Action</span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($curricula as $curriculum)
            <tr>
                <td class="p-2 text-center">{{ $curriculum->effective_sy }}</td>
                <td class="p-2 text-center">{{ $curriculum->description }}</td>
                <td class="p-2 text-center">{{ $curriculum->active ? 'Active' : 'Inactive' }}</td>
                <td class="p-2 text-right">
                    @if(!$curriculum->active)
                        <button  class="mr-2 text-green-500" wire:click="activateCurriculum({{ $curriculum->id }})">
                            <i class="fa fa-check"></i>
                        </button>
                    @endif
                    <a href="{{ route('curricula.show', $curriculum) }}">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

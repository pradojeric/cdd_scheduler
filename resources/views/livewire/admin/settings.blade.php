<div>
    <div>
        <form class="space-y-2" autocomplete="off" wire:submit="saveSettings" x-data="updateYear()">
            @if (session()->has('message'))
                <div class="bg-green-500 text-white px-3 py-2 mb-2 rounded-lg shadow-lg">
                    {{ session('message') }}
                </div>
            @endif
            <div class="flex flex-col justify-center space-y-2">
                <div class="flex items-center">
                    <x-label for="school_year" :value="__('School Year')" class="w-1/12" />
                    <div>
                        <x-input id="school_year" type="number" name="school_year" class="mt-1 w-32" x-on:keyup="getNextYear()" x-on:change="getNextYear()" x-model="year1" />
                        {{ __('-') }}
                        <x-input id="school_year" type="number" name="school_year" class="mt-1 w-32" x-model="year2" readonly />
                    </div>
                </div>

                <div class="flex items-center">
                    <x-label for="term" :value="__('Term')" class="w-1/12" />
                    <x-select wire:model="term" id="term" class="mt-1 w-auto">
                        @foreach ($terms as $i => $value)
                            <option value="{{ $i }}">{{ $value }}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div>
                <x-button wire:click.prevent="saveSettings" class=" w-auto">
                    <span wire:loading wire:target="saveSettings">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                    <span wire:loading.remove wire:target="saveSettings">
                        Update
                    </span>
                </x-button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateYear()
    {
        return {
            year1 : @entangle('year1').defer,
            year2 : @entangle('year2').defer,
            getNextYear() {
                this.year2 = parseInt(this.year1) + 1;
            },
        }
    }
</script>

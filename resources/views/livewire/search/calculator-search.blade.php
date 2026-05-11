<div>
    <div x-data="{
        open: @entangle('showSuggestions'),
        close() {
            open = false;
            $wire.clearSearch();
        }
    }" x-on:click.away="close()" class="w-full mx-auto">
        <div
            class="flex items-center bg-white border border-gray-300 shadow-sm rounded-full pr-5 pl-3 py-2 focus-within:ring-2 focus-within:ring-blue-500 transition-all duration-200 relative">
            <input wire:model.live="search" wire:keydown.arrow-up.prevent="moveHighlight('up')"
                wire:keydown.arrow-down.prevent="moveHighlight('down')" wire:keydown.enter.prevent="selectCalculator"
                wire:focus="$set('showSuggestions', true)" type="text"
                class="flex-1 bg-transparent text-gray-800 placeholder-gray-400 focus:outline-none text-sm border-none"
                placeholder="Search Calculators..." x-on:focus="open = true">

            <img src="{{ asset('assets/images/svgs/search.svg') }}"
                class="w-5 h-5 text-gray-500 hover:text-blue-500 transition-colors" alt="search" title="search" />
        </div>
        <div x-show="open" class="relative mt-1" x-cloak>
            <ul
                class="suggestion absolute w-full max-h-64 overflow-y-auto shadow-lg rounded-lg bg-white z-50 divide-y divide-gray-100">
                @forelse($suggestions as $index => $calculator)
                    <li wire:key="calc-{{ $index }}"
                        class="{{ $highlightIndex === $index ? 'bg-blue-50' : 'hover:bg-gray-50' }} flex justify-between items-center"
                        wire:mouseover="$set('highlightIndex', {{ $index }})">
                        <a href="/{{ $calculator[1] }}" class="block py-2 px-4 cursor-pointer flex-grow"
                            wire:click.prevent="selectCalculator({{ $index }})">
                            {!! $this->highlight($calculator[0]) !!}
                        </a>
                        <span class="text-xs text-gray-500 pr-4">{{ $calculator[2] ?? '' }}</span>
                    </li>
                @empty
                    <li class="py-2 px-4 text-gray-500 italic">
                        No results found for "{{ $search }}"
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>

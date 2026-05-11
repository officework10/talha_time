<div>
    <!-- Search Bar -->
    <div class="bg-white p-4 relative flex items-center border-b border-gray-100">
        <div class="mr-3 text-gray-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        
        <input id="searchInput" 
               wire:model.live.debounce.300ms="search" 
               wire:keydown.arrow-up.prevent="moveHighlight('up')"
               wire:keydown.arrow-down.prevent="moveHighlight('down')" 
               wire:keydown.enter.prevent="selectCalculator"
               wire:focus="$set('showSuggestions', true)" 
               type="text"
               class="w-full text-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-0 border-0"
               placeholder="Search Calculators..." 
               autocomplete="off"
               aria-label="Search calculators">

        <div class="w-px h-6 bg-gray-200 mx-4"></div>

        <button onclick="closeSearchModal()" class="text-gray-400 hover:text-gray-600 transition-colors" aria-label="Close search">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Suggestions Section -->
    @if ($search && $showSuggestions && count($suggestions) > 0)
        <!-- Search Results -->
        <div class="max-h-96 overflow-y-auto">
            @foreach($suggestions as $index => $calculator)
                <div wire:key="calc-{{ $index }}"
                     class="{{ $highlightIndex === $index ? 'bg-blue-50' : 'hover:bg-gray-50' }} px-6 py-4 cursor-pointer transition-all duration-150 border-b border-gray-100"
                     wire:mouseover="$set('highlightIndex', {{ $index }})"
                     wire:click="selectCalculator({{ $index }})">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900 text-base">
                                {!! $this->highlight($calculator[0]) !!}
                            </div>
                            @if (!empty($calculator[2]))
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium text-blue-700 bg-blue-100 rounded">
                                    {{ $calculator[2] }}
                                </span>
                            @endif
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif ($search && $showSuggestions && count($suggestions) === 0)
        <!-- No Results -->
        <div class="px-6 py-8 text-center bg-gray-50">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-gray-500 font-medium">No results found for "{{ $search }}"</p>
            <p class="text-gray-400 text-sm mt-1">Try searching with different keywords</p>
        </div>
    @else
        <!-- Try Searching For Section -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
            <div class="text-xs text-gray-500 mb-3 font-medium">Try searching for</div>
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('search', 'Time Calculator')" class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 hover:border-gray-300 hover:shadow-sm transition-all">
                    Time Calculator
                </button>
                <button wire:click="$set('search', 'Date Calculator')" class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 hover:border-gray-300 hover:shadow-sm transition-all">
                    Date Calculator
                </button>
                <button wire:click="$set('search', 'Hours Calculator')" class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 hover:border-gray-300 hover:shadow-sm transition-all">
                    Hours Calculator
                </button>
            </div>
        </div>
    @endif
</div>

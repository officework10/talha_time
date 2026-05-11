<div x-data="{ showClear: false }" x-init="$watch('showClear', value => {})">
    <div class="relative mb-4 mx-3">
        <button x-show="!showClear" aria-label="Search The Calculator"
            class="absolute right-2 top-1/2 transform -translate-y-1/2 rounded-full bg-[#55be30] p-3 flex items-center justify-center transition duration-300 hover:bg-[#55be30] z-10">
            <svg width="12" height="12" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="transition duration-200 searchsvg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M14.9 7.70001C14.9 4.60721 12.3928 2.1 9.29999 2.1C6.20719 2.1 3.69998 4.60721 3.69998 7.70001C3.69998 10.7928 6.20719 13.3 9.29999 13.3C12.3928 13.3 14.9 10.7928 14.9 7.70001ZM9.29999 0.5C13.2764 0.5 16.5 3.72356 16.5 7.70001C16.5 11.6765 13.2764 14.9 9.29999 14.9C7.59999 14.9 6.03759 14.3108 4.80583 13.3255L1.86566 16.2657C1.55326 16.5781 1.0467 16.5781 0.734301 16.2657C0.4219 15.9533 0.4219 15.4467 0.734301 15.1343L3.67446 12.1942C2.68918 10.9624 2.09998 9.40001 2.09998 7.70001C2.09998 3.72356 5.32351 0.5 9.29999 0.5Z"
                    class="fill-[#E8FFF1] group-hover:fill-black transition duration-200 "></path>
            </svg>
        </button>

        <button x-show="showClear" x-cloak x-on:click="$wire.set('query', ''); showClear = false"
            class="absolute right-2 top-1/2 transform -translate-y-1/2 rounded-full bg-red-600 p-3 flex items-center justify-center transition duration-300 hover:bg-red-700 z-10 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <input type="text" wire:model.live="query"
            x-on:input.debounce.300ms="showClear = $event.target.value.length > 0" placeholder="e.g. cm to inches"
            class="w-full p-2 rounded-lg border border-black focus:outline-none s h-[40px] md:h-[45px] lg:h-[45px]">
    </div>

    @if (!empty($query))
        <div class="row px-3 related custom-scroll overflow-auto mt-2" style="max-height: 300px;" id="search_unit">
            @if (!empty($results))
                @foreach ($results as $item)
                    <p class="py-2 border-sidebar text-[16px]">
                        <a href="{{ url($item->cal_link) }}/" class="text-back text-decoration-none"
                            title="{{ $item->cal_title }}">
                            {!! $highlightMatch($item->cal_title, $query) !!}
                        </a>
                    </p>
                @endforeach
            @else
                <p class="py-2 text-[16px] text-muted">
                    <a class="text-back text-decoration-none font-bold">Not Found</a>
                </p>
            @endif
        </div>
    @endif

</div>

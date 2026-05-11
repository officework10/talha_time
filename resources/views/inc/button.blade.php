<div class="flex justify-center gap-3  my-[30px]">
    <button type="submit" id="calculate" wire:loading.attr="disabled"
        class="relative bg-[#55be30] shadow-2xl text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3 flex items-center justify-center gap-2">
        <span wire:loading wire:target="calculate" id="addbtnflex" class="flex items-center gap-2 ">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </span>
        <span>{{ $lang['calc'] ?? ($lang['calculate'] ?? 'Calculate') }}</span> 
    </button>


    @if ($detail)
        <button wire:click="resetForm" type="button"
            class="calculate bg-[#000000] shadow-2xl text-[#fff] hover:bg-[#55be30] duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3">
            @if (app()->getLocale() == 'en')
                RESET
            @else
                {{ $lang['reset'] ?? 'RESET' }}
            @endif
        </button>
    @endif

</div>

{{-- Show ad after result is displayed --}}
@if ($detail)
    @include('components.ads.TimeResultButtonAds')
@endif

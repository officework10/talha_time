<div>

    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[40%] md:w-[60%] w-full mx-auto ">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="start_date" class="label">{{ $lang['1'] }}:</label>
                        <input type="date" wire:model="start_date" name="" id="start_date" class="input"
                            aria-label="input" />
                    </div>
                    <div class="space-y-2">
                        <label for="end_date" class="label">{{ $lang['2'] }}:</label>
                        <input type="date" wire:model="end_date" name="" id="end_date" class="input"
                            aria-label="input" />
                    </div>
                </div>
            </div>
            @if ($type == 'calculator')
                @include('inc.button')
            @endif
            @if ($type == 'widget')
                @include('inc.widget-button')
            @endif
        </div>
        @isset($detail)
            {{-- result --}}
            <div id="result-section" wire:loading.remove wire:target="calculate"
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg  flex items-center justify-center">
                        <div class="w-full bg-light-blue p-1 rounded-lg mt-6">
                            <div class="flex justify-center ">
                                <div class="text-center border bg-[#55be30] text-white rounded-lg ">
                                    <p class="text-2xl  px-6 py-1 inline-block my-2">
                                        <strong class="text-blue">{{ $detail['months'] }}</strong>
                                        <span class="text-xl">{{ $lang['4'] }}</span>
                                        <strong class="text-blue">{{ $detail['days'] }}</strong>
                                        <span class="text-xl">{{ $lang['5'] }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </form>
</div>

<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="lg:w-[40%] md:w-[60%] w-full mx-auto">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
               
                    <div class="col-span-12 md:col-span-6 lg:col-span-6">
                        <div class="mb-1">
                            <label for="want" class="form-label box-shadow-0">{{ $lang['1'] }}</label>
                            <select class="input remove_shadow" wire:model="want" id="want" aria-label="Default select example">
                                <option value="1">{{ $lang['2'] }}</option>
                                <option value="2">{{ $lang['3'] }} (%)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 lg:col-span-6">
                        <div class="mb-1">
                            <label for="x" class="form-label" id="changeText">
                                {{ $want == '2' ? 'Doubling Time:' : ($lang[3] ?? 'Growth Rate') . ' (%):' }}
                            </label>
                            <input type="number" step="any" wire:model="x" id="x" class="input remove_shadow" aria-describedby="emailHelp">
                        </div>
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
            <div id="result-section" wire:loading.remove wire:target="calculate" class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="w-full mx-auto rounded-3xl">
                        <div class="w-full mx-auto">
                            <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                                <div class="col-span-12 text-[20px]">
                                    <div class="w-full text-center my-5">
                                        <p class="">
                                            {{ $want == '1' ? ($lang['2'] ?? 'Doubling Time') : ($lang['3'] ?? 'Growth Rate') }}
                                        </p>
                                        <p class="my-3">
                                            <strong class="px-3 py-2 text-[30px] bg-gray-100 text-[#49987d]">
                                                {{ round($detail['ans'], 5) }}
                                                @if ($want == '2') (%) @endif
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </form>
</div>

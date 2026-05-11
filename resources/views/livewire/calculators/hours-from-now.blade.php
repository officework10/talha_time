<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="lg:w-[50%] md:w-[70%] w-full mx-auto">
                <div class="grid grid-cols-1 gap-4">
                    <div class="space-y-2 relative flex items-center gap-4">
                        <input type="radio" id="stat" wire:model.live="timeType" value="stat"
                            class="cursor-pointer" />
                        <label for="stat"
                            class="font-s-14 cursor-pointer text-blue pe-lg-3 pe-2">{{ $lang['1'] }}</label>

                        <input type="radio" id="dyna" wire:model.live="timeType" value="dyna"
                            class="cursor-pointer" />
                        <label for="dyna" class="font-s-14 cursor-pointer text-blue">{{ $lang['2'] }}</label>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 mt-3">
                    <!-- Time Input Fields -->
                    <div class="flex gap-5 items-center">
                        <div class="w-full">
                            <input type="number" id="hours" wire:model="hours" min="0" max="23"
                                class=" focus:ring-[#38A169] input {{ $timeType === 'stat' ? 'bg-gray-200 cursor-not-allowed opacity-50' : '' }}"
                                @if ($timeType === 'stat') readonly @endif>
                        </div>
                        <p class="mb-1">:</p>
                        <div class="w-full">
                            <input type="number" id="minutes" wire:model="minutes" min="0" max="59"
                                class=" focus:ring-[#38A169] input  {{ $timeType === 'stat' ? 'bg-gray-200 cursor-not-allowed opacity-50' : '' }}"
                                @if ($timeType === 'stat') readonly @endif>
                        </div>
                        <p class="mb-1">:</p>
                        <div class="w-full">
                            <input type="number" id="seconds" wire:model="seconds" min="0" max="59"
                                class=" focus:ring-[#38A169] input  {{ $timeType === 'stat' ? 'bg-gray-200 cursor-not-allowed opacity-50' : '' }}"
                                @if ($timeType === 'stat') readonly @endif>
                        </div>
                    </div>
                </div>

                <!-- Hours and Minutes to Add -->
                <div class="grid grid-cols-1 gap-4 mt-4">
                    <div class="flex gap-5 items-center">
                        <!-- Hours to Add -->
                        <div class="w-full">
                            <label class="text-sm text-[#38A169]">{{ $lang['3'] }}</label>
                            <input type="number" id="hrs" wire:model="hrs" min="0"
                                class=" focus:ring-[#38A169] input"
                                aria-label="hours to add" />
                        </div>

                        <p class="mt-6">:</p>

                        <!-- Minutes to Add -->
                        <div class="w-full">
                            <label class="text-sm text-[#38A169]">{{ $lang['4'] }}</label>
                            <input type="number" id="min" wire:model="min" min="0" max="59"
                                class=" focus:ring-[#38A169] input"
                                aria-label="minutes to add" />
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
            <div id="result-section" wire:loading.remove wire:target="calculate"
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg flex items-center justify-center">
                        <div class="w-full bg-light-blue result p-3 rounded-lg mt-3 overflow-auto">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full text-center">
                                    <span class="pr-4 text-sm block md:inline-block">Output Time Format:</span>
                                    <input type="radio" name="time_st" id="twhr" class="cursor-pointer ml-3"
                                        value="twhr" wire:model.live="outputFormat">
                                    <label for="twhr" class="text-sm cursor-pointer text-[#38A169] pr-4 md:pr-6">12
                                        Hours am/pm</label>

                                    <input type="radio" class="cursor-pointer" name="time_st" id="tfhr"
                                        value="tfhr" wire:model.live="outputFormat">
                                    <label for="tfhr" class="text-sm cursor-pointer text-[#38A169]">24 Hours</label>

                                    <div>
                                        <p class="text-xl bg-[#55be30] text-white px-4 py-2 rounded-lg inline-block my-3">
                                            <strong id="currentTime">
                                                @if ($outputFormat === 'twhr')
                                                    {{ $detail['hoursadding']->format('h:i:s A') }}
                                                @else
                                                    {{ $detail['hoursadding']->format('H:i:s') }}
                                                @endif
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
        @push('calculatorJS')
            <script>
                document.addEventListener('livewire:init', () => {
                    setInterval(() => {
                        if (@this.isLive) {
                            Livewire.dispatch('refreshTime');
                        }
                    }, 1000);
                });
            </script>
        @endpush
    </form>
</div>

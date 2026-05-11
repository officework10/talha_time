<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            {{-- hours  minutes seconds  hrs  min --}}
            <div class="lg:w-[40%] md:w-[70%] w-full mx-auto">
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
                                class="input focus:ring-[#38A169] {{ $timeType === 'stat' ? 'bg-gray-200 cursor-not-allowed opacity-50' : '' }}"
                                @if ($timeType === 'stat') readonly @endif>
                        </div>
                        <p class="mb-1">:</p>
                        <div class="w-full">
                            <input type="number" id="minutes" wire:model="minutes" min="0" max="59"
                                class="input focus:ring-[#38A169]  {{ $timeType === 'stat' ? 'bg-gray-200 cursor-not-allowed opacity-50' : '' }}"
                                @if ($timeType === 'stat') readonly @endif>
                        </div>
                        <p class="mb-1">:</p>
                        <div class="w-full">
                            <input type="number" id="seconds" wire:model="seconds" min="0" max="59"
                                class="input focus:ring-[#38A169] {{ $timeType === 'stat' ? 'bg-gray-200 cursor-not-allowed opacity-50' : '' }}"
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
                                class="input focus:ring-[#38A169]"
                                aria-label="hours to add" />
                        </div>

                        <p class="mt-6">:</p>

                        <!-- Minutes to Add -->
                        <div class="w-full">
                            <label class="text-sm text-[#38A169]">{{ $lang['4'] }}</label>
                            <input type="number" id="min" wire:model="min" min="0" max="59"
                                class="input focus:ring-[#38A169]"
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
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg  flex items-center justify-center">
                        <div class="w-full p-3 rounded-lg mt-3 overflow-auto">
                            <div class="lg:w-5/12 mx-auto p-1">
                                <div class=" border-2 rounded-lg bg-[#F6FAFC] p-2 text-center">
                                    <p>🕑 Time</p>
                                    <p class="text-2xl"><strong class="text-blue">{{ $detail['time'] }}</strong></p>
                                </div>
                            </div>
                            <div class="flex flex-wrap justify-center text-center">
                                <div class="lg:w-1/2 w-full p-1">
                                    <div class="border-2 rounded-lg bg-[#F6FAFC] p-2">
                                        <p class="pb-2">📅 Date</p>
                                        <p class="text-lg"><strong>{{ $detail['t_date'] }}</strong></p>
                                    </div>
                                </div>
                                <div class="lg:w-1/2 w-full p-1">
                                    <div class="border-2 rounded-lg bg-[#F6FAFC] p-2">
                                        <p class="pb-2">🌞 Day</p>
                                        <p class="text-lg"><strong>{{ $detail['days'] }}</strong></p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center p-2">  
                                
                                
                                What is <strong>{{ $detail['hours'] ? $detail['hours'] : 0 }}</strong> hours,
                                <strong>{{ $detail['minutes'] ? $detail['minutes'] : 0 }}</strong> minute,
                                <strong>{{ $detail['seconds'] ? $detail['seconds'] : 0 }}</strong> second ago?
                                The answer is <strong>{{ $detail['time'] }}</strong> on
                                <strong>{{ $detail['t_date'] }}</strong>
                                which is <strong>{{ $detail['days'] }}</strong> days from the time of calculation
                                using this Time Ago Calculator.
                            </p>
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

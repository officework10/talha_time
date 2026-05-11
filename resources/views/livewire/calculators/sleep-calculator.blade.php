<div x-data="{ time_type: @entangle('time_type') }">
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <!-- Tabs -->
            <div class="mx-auto mt-2 lg:w-[40%] w-full">
                <div class="flex flex-wrap items-center bg-green-100 border border-green-500 text-center rounded-lg px-1 velocitytab">
                    <div class="lg:w-1/2 w-full px-2 py-1">
                        <div class="px-3 py-2 cursor-pointer rounded-md transition-colors veloTabs"
                             :class="time_type === 'sleep' ? 'tagsUnit bg-white shadow-sm' : 'bg-transparent text-green-700'"
                             @click="time_type = 'sleep'">
                            {{ $lang['59'] }}
                        </div>
                    </div>
                    <div class="lg:w-1/2 w-full px-2 py-1">
                        <div class="px-3 py-2 cursor-pointer rounded-md transition-colors veloTabs"
                             :class="time_type === 'sleep_length' ? 'tagsUnit bg-white shadow-sm' : 'bg-transparent text-green-700'"
                             @click="time_type = 'sleep_length'">
                            {{ $lang['60'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="lg:w-[66%] md:w-[65%] w-full mx-auto mt-5">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    
                    <!-- Sleep Calculator Tab Content -->
                    <div class="col-span-12" x-show="time_type === 'sleep'">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                            <div class="col-span-12">
                                <p class="text-[14px] text-blue pe-lg-3 pe-2">{{ $lang['44'] }}</p>
                                <div class="flex space-x-4">
                                    <label class="flex items-center gap-1 cursor-pointer">
                                        <input type="radio" wire:model.live="stype" value="wkup" class="cursor-pointer">
                                        <span class="text-[14px] text-blue">{{ $lang['45'] }}:</span>
                                    </label>
                                    <label class="flex items-center gap-1 cursor-pointer">
                                        <input type="radio" wire:model.live="stype" value="bedtime" class="cursor-pointer">
                                        <span class="text-[14px] text-blue">{{ $lang['46'] }}:</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6">
                                <div class="w-full py-2">
                                    <div class="flex justify-end items-center">
                                        <button type="button" wire:click="setTime('h', 'now')" class="text-[14px] text-blue underline cursor-pointer bg-transparent border-0 p-0">
                                            {{ $lang['47'] }}
                                        </button>
                                    </div>

                                    <div class="mb-1 ">
                                        <input type="time" wire:model="h" class="input remove_shadow" placeholder="00">
                                    </div>
                                    
                                    <div class="flex justify-between items-center" x-show="$wire.stype === 'bedtime'">
                                        <button type="button" wire:click="setTime('h', '30m')" class="text-[14px] text-blue underline cursor-pointer bg-transparent border-0 p-0">
                                            30 {{ $lang['48'] }}
                                        </button>
                                        <button type="button" wire:click="setTime('h', '1h')" class="text-[14px] text-blue underline cursor-pointer bg-transparent border-0 p-0">
                                            1 {{ $lang['49'] }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sleep Length Tab Content -->
                    <div class="col-span-12" x-show="time_type === 'sleep_length'">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                            <div class="col-span-12">
                                <p class="text-[14px] text-blue pe-lg-3 pe-2">{{ $lang['44'] }}</p>
                                <div class="flex space-x-4">
                                    <label class="flex items-center gap-1 cursor-pointer">
                                        <input type="radio" wire:model.live="sleep_type" value="sleep_wkup" class="cursor-pointer">
                                        <span class="text-[14px] text-blue">{{ $lang['45'] }}:</span>
                                    </label>
                                    <label class="flex items-center gap-1 cursor-pointer">
                                        <input type="radio" wire:model.live="sleep_type" value="sleep_bedtime" class="cursor-pointer">
                                        <span class="text-[14px] text-blue">{{ $lang['46'] }}:</span>
                                    </label>
                                </div>
                            </div>

                           <div class="col-span-12 md:col-span-6">
                                <div class="w-full pb-4">
                                    <div class="flex justify-end items-center" x-show="$wire.sleep_type === 'sleep_bedtime'">
                                        <button type="button" wire:click="setTime('h1', 'now')" class="text-[14px] text-blue underline cursor-pointer bg-transparent border-0 p-0">
                                            {{ $lang['47'] }}
                                        </button>
                                    </div>

                                    <div class="mb-1 ">
                                        <input type="time" wire:model="h1" class="input remove_shadow" placeholder="00">
                                    </div>

                                    <div class="flex justify-between items-center" x-show="$wire.sleep_type === 'sleep_bedtime'">
                                        <button type="button" wire:click="setTime('h1', '30m')" class="text-[14px] text-blue underline cursor-pointer bg-transparent border-0 p-0">
                                            30 {{ $lang['48'] }}
                                        </button>
                                        <button type="button" wire:click="setTime('h1', '1h')" class="text-[14px] text-blue underline cursor-pointer bg-transparent border-0 p-0">
                                            1 {{ $lang['49'] }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-6 md:col-span-6 lg:col-span-6">
                                <div class="w-full">
                                    <div class="mb-1 sleeping-hours relative">
                                        <label for="sleephour" class="form-label">{{ $lang['50'] }}</label>
                                        <input type="number" wire:model="sleephour" max="23" min="1" class="input remove_shadow t_hour" placeholder="00">
                                        <span class="input_unit">hours</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-6 lg:col-span-6">
                                <div class="w-full">
                                    <div class="mb-1 sleeping-min relative">
                                        <label class="form-label">&nbsp;</label>
                                        <input type="number" wire:model="sleep_minutes" max="60" min="0" class="input remove_shadow t_hour" placeholder="00">
                                        <span class="input_unit">minutes</span>
                                    </div>
                                </div>
                            </div>
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

        <!-- Result Section -->
        @isset($detail)
            <div id="result-section" wire:loading.remove wire:target="calculate"
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg space-y-6 result mt-5">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    
                    <div class="w-full mx-auto">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                            <div class="col-span-12 my-4">
                                @if ($detail['ResultFor'] == 'SimpleSleep')
                                    <div class="w-full">
                                        @if ($detail['stype'] == 'wkup')
                                            <p class="text-center text-[15px] mb-0 my-1">{{ $lang['51'] ?? 'To wake up at' }} {{ $detail['target_time'] ?? $h }}, {{ $lang['52'] ?? 'you should go to bed at' }}:</p>
                                            <p class="text-center mb-0 my-1 main_ans"><strong class="text-[#49987d]">{{ $detail[5] }}</strong> ({{ $lang['53'] ?? 'Cycles' }} 5)</p>
                                            <p class="text-center mb-0 my-1 main_ans"><strong class="text-[#49987d]">{{ $detail[6] }}</strong> ({{ $lang['53'] ?? 'Cycles' }} 6)</p>
                                            <p class="text-center text-[15px] mb-0 my-1">{{ $lang['54'] ?? 'It is very important for you to complete recommended sleep cycles.' }}</p>
                                            @foreach([7, 4, 3, 2, 1] as $cycle)
                                                <p class="text-center text-[16px] mb-0 my-1">{{ $detail[$cycle] }} ({{ $lang['53'] ?? 'Cycles' }} {{ $cycle }})</p>
                                            @endforeach
                                        @else
                                            <p class="text-center text-[15px] mb-0 my-1">{{ $lang['55'] ?? 'If you go to bed at' }} {{ $detail['target_time'] ?? $h }}, {{ $lang['56'] ?? 'you should wake up at' }}:</p>
                                            <p class="text-center mb-0 my-1 main_ans"><strong class="text-[#49987d]">{{ $detail[5] }}</strong> ({{ $lang['53'] ?? 'Cycles' }} 5)</p>
                                            <p class="text-center mb-0 my-1 main_ans"><strong class="text-[#49987d]">{{ $detail[6] }}</strong> ({{ $lang['53'] ?? 'Cycles' }} 6)</p>
                                            <p class="text-center text-[15px] mb-0 my-1">{{ $lang['54'] ?? 'It is very important for you to complete recommended sleep cycles.' }}</p>
                                            @foreach([7, 4, 3, 2, 1] as $cycle)
                                                <p class="text-center text-[16px] mb-0 my-1">{{ $detail[$cycle] }} ({{ $lang['53'] ?? 'Cycles' }} {{ $cycle }})</p>
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    <div class="w-full my-5">
                                        @if ($detail['stype'] == 'sleep_wkup')
                                            <p class="text-center text-[15px] md:text-[25px] lg:text-[25px] mb-0 my-1">
                                                {{ $lang['57'] ?? 'Your ideal bedtime is' }}: <strong class="text-[#49987d]">{{ $detail['BedTime'] }}</strong>
                                            </p>
                                        @else
                                            <p class="text-center text-[15px] md:text-[25px] lg:text-[25px] mb-0 my-1">
                                                {{ $lang['58'] ?? 'Your ideal wake-up time is' }}: <strong class="text-[#49987d]">{{ $detail['WakupTime'] }}</strong>
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </form>
</div>

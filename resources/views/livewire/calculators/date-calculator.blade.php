<div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="lg:w-[60%] md:w-[70%] w-full mx-auto ">
                <div class="grid grid-cols-2  lg:grid-cols-2 md:grid-cols-2 text-center  gap-4">
                    <a href="{{ url('date-duration-calculator') }}/" class=" cursor-pointer py-2  " id="date_cal">
                        <strong>{{ $lang['41'] ?? 'Date Duration'}}</strong>
                    </a>
                    <a href="{{ url('date-calculator') }}/"
                        class=" cursor-pointer py-2 text-[#55be30] border-b-2 border-[#55be30]" id="time_cal">
                        <strong>{{ $lang['42'] ?? 'Date Calculator'}}</strong>
                    </a>
                </div>


                <div class="flex flex-wrap">
                    <div class="w-full lg:w-1/2 px-2 mt-3 lg:pr-4">
                        <label for="add_date" class="label">{{ $lang['2'] ?? 'Start Date' }}:</label>
                        <div class="w-full py-2">
                            <input type="date" wire:model="add_date" id="add_date"
                                class="input" aria-label="input" />
                        </div>
                    </div>
                    <div class="w-full lg:w-1/2 px-2 mt-3 lg:pl-4">
                        <label for="method" class="label">{{ $lang[45] ?? 'Add' }} /
                            {{ $lang['46'] ?? 'Subtract' }}:</label>
                        <div class="w-full py-2">
                            <select wire:model="method" wire:change="changeMethod" id="method"
                                class="input">
                                <option value="add">Add (+)</option>
                                <option value="sub">Subtract (-)</option>
                            </select>
                        </div>
                    </div>




                    <div class="w-full lg:w-1/2 lg:pr-4">
                        <div class="flex flex-wrap">
                            <div class="w-1/2 px-2 lg:pr-1">
                                <label for="years" class="label">{{ $lang['47'] ?? 'Years' }}:</label>
                                <div class="w-full py-2">
                                    <input type="number" step="any" wire:model="years" id="years"
                                        class="input" aria-label="input" />
                                </div>
                            </div>
                            <div class="w-1/2 px-2 lg:pl-1">
                                <label for="months" class="label">{{ $lang['48'] ?? 'Months' }}:</label>
                                <div class="w-full py-2">
                                    <input type="number" step="any" wire:model="months" id="months"
                                        class="input" aria-label="input" />
                                </div>
                            </div>
                        </div>

                        {{-- Time fields toggle --}}
                        <div class="flex flex-wrap" x-data="{ showTime: @entangle('showTime') }" x-show="showTime">
                            <div class="w-full flex px-2">
                                <div class="w-1/3 py-2 mx-1">
                                    <input type="number" step="any" wire:model="add_hrs_f"
                                        class="input" placeholder="HH" />
                                </div>
                                <div class="w-1/3 py-2 mx-1">
                                    <input type="number" step="any" wire:model="add_min_f"
                                        class="input" placeholder="MM" />
                                </div>
                                <div class="w-1/3 py-2 mx-1">
                                    <input type="number" step="any" wire:model="add_sec_f"
                                        class="input" placeholder="SS" />
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="w-full lg:w-1/2 lg:pl-4">
                        <div class="flex flex-wrap">
                            <div class="w-1/2 px-2 lg:pl-0">
                                <label for="weeks" class="label">{{ $lang['49'] ?? 'Weeks' }}:</label>
                                <div class="w-full py-2">
                                    <input type="number" step="any" wire:model="weeks" id="weeks"
                                        class="input" aria-label="input" />
                                </div>
                            </div>
                            <div class="w-1/2 px-2">
                                <label for="days" class="label">{{ $lang['50'] ?? 'Days' }}:</label>
                                <div class="w-full py-2">
                                    <input type="number" step="any" wire:model="days" id="days"
                                        class="input" aria-label="input" />
                                </div>
                            </div>
                        </div>

                    </div>



                </div>




                
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 px-2">
                    {{-- div two --}}
                    {{-- Toggle Button --}}
                    <div x-data="{ inctime: @entangle('inctime') }" x-cloak class="w-full">
                        {{-- Conditionally Shown Time Fields --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2">
                            <div x-show="inctime === 'time_out'" x-cloak class="mt-2">
                                <div class="w-full flex px-2">
                                    <div class="w-1/3 py-2 mx-1">
                                        <input type="number" step="any" wire:model="add_hrs_f"
                                            class="input" placeholder="HH" />
                                    </div>
                                    <div class="w-1/3 py-2 mx-1">
                                        <input type="number" step="any" wire:model="add_min_f"
                                            class="input" placeholder="MM" />
                                    </div>
                                    <div class="w-1/3 py-2 mx-1">
                                        <input type="number" step="any" wire:model="add_sec_f"
                                            class="input" placeholder="SS" />
                                    </div>
                                </div>
                            </div>
                            <div x-show="inctime === 'time_out'" x-cloak class="mt-2">
                                <div class="w-full flex px-2">
                                    <div class="w-1/3 py-2 mx-1">
                                        <input type="number" step="any" wire:model="add_hrs_s"
                                            class="input" placeholder="HH" />
                                    </div>
                                    <div class="w-1/3 py-2 mx-1">
                                        <input type="number" step="any" wire:model="add_min_s"
                                            class="input" placeholder="MM" />
                                    </div>
                                    <div class="w-1/3 py-2 mx-1">
                                        <input type="number" step="any" wire:model="add_sec_s"
                                            class="input" placeholder="SS" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Toggle Button --}}
                        <p class="label cursor-pointer underline text-end"
                            wire:click="changeOperation">
                            <span x-show="inctime === 'time_in'" x-cloak>{{ $lang[62] ?? 'Include the time' }}</span>
                            <span x-show="inctime === 'time_out'" x-cloak>{{ $lang[63] ?? 'Remove the time' }}</span>
                        </p>
                    </div>


                    {{-- div one --}}
                    <div x-data="{ showRepeat: @entangle('checkbox') }" class="md:w-[50%]">
                        {{-- Conditionally Shown Repeat Input --}}
                        <div x-show="showRepeat" x-cloak>
                            <label for="repeat" class="label">{{ $lang[52] ?? 'Repeat' }}:</label>
                            <div class="w-full mt-3">
                                <input type="number" wire:model="repeat" id="repeat"
                                    class="input" placeholder="Repeat..." />
                            </div>
                        </div>
                        {{-- Checkbox --}}
                        <div class="mt-2 ">
                            <input type="checkbox" id="checkbox" wire:model="checkbox" />
                            <label for="checkbox" class="label">{{ $lang[51] ?? 'Repeat' }}:</label>
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
            {{-- result --}}
            <div id="result-section" wire:loading.remove wire:target="calculate"
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    
                    <div class="w-full mx-auto rounded-3xl">
                        <div class="w-full mx-auto">
                            <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                                <div class="col-span-12">
                                    <div class="w-full">
                                        <div class="col-lg-12 text-[16px] mt-4 mx-3">
                                            <p>
                                                <strong>{{ $lang[15] ?? 'Start Date' }}</strong>:
                                                {{ $detail['formatted_date'] }} at {{ $detail['formatted_time'] }}
                                            </p>
                                            <p>
                                                <strong>{{ $lang[16] ?? 'Added duration' }}</strong>:
                                                {{ $lang[17] ?? 'Years' }} {{ $detail['years'] }},
                                                {{ $lang[18] ?? 'Months' }} {{ $detail['months'] }},
                                                {{ $lang[19] ?? 'Weeks' }} {{ $detail['weeks'] }},
                                                {{ $lang[20] ?? 'Days' }} {{ $detail['days'] }},
                                                {{ $lang[21] ?? 'Hours' }} {{ $detail['add_hrs_s'] }},
                                                {{ $lang[22] ?? 'Minutes' }} {{ $detail['add_min_s'] }},
                                                {{ $lang[23] ?? 'Seconds' }} {{ $detail['add_sec_s'] }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row flex justify-center mt-4 mx-4">
                                        <div class="col-lg-6 text-[18px] md:text-[25px] lg:text-[25px]">
                                            {{-- First Result --}}
                                            <p>
                                                <strong class="text-[#49987d]">
                                                    {{ $lang[14] ?? 'Result' }}
                                                    @if($detail['repeat'] > 1) 1 @endif
                                                </strong>
                                                : {{ $detail['ans'][0] }}
                                            </p>

                                            {{-- Remaining Results (if any) --}}
                                            @if (count($detail['ans']) > 1)
                                                @foreach (array_slice($detail['ans'], 1) as $index => $value)
                                                    <p>
                                                        <strong class="text-[#49987d]">
                                                            {{ $lang[14] ?? 'Result' }} {{ $index + 2 }}
                                                        </strong>
                                                        : {{ $value }}
                                                    </p>
                                                @endforeach
                                            @endif
                                        </div>
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

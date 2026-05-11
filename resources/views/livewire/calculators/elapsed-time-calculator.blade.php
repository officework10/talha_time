<div>
    <form wire:submit.prevent="calculate" class="row">

        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="mx-auto mt-2 lg:w-[40%] w-full">
                <!-- Hidden input bound to Livewire -->
                <input type="hidden" name="main_units" id="main_units" wire:model="main_units">
                <div class="grid grid-cols-12 gap-4 items-center bg-blue-100 border border-blue-500 text-center rounded-lg px-1">
                    <!-- Elapsed -->
                    <div class="col-span-6 w-full px-2 py-1">
                        <div class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white wed 
                {{ $main_units !== 'elapsed' ? '' : 'tagsUnit' }}"
                            wire:click="setMainUnits('elapsed')">
                            {{ $lang['1'] }}
                        </div>
                    </div>
                    <!-- Clock -->
                    <div class="col-span-6 w-full px-2 py-1">
                        <div class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white rel 
                {{ $main_units === 'clock' ? 'tagsUnit' : '' }}"
                            wire:click="setMainUnits('clock')">
                            {{ $lang['2'] }}
                        </div>
                    </div>

                </div>
            </div>



            <div class="lg:w-[60%] md:w-[60%] w-full mx-auto ">

                <div class="grid grid-cols-1 gap-4">
                    <div
                        class="d-flex align-items-center px-2 mt-3 clock-time {{ $main_units == 'clock' ? '' : 'hidden' }}">
                        <p class="label pe-2">{{ $lang['5'] }}:</p>

                        <input type="radio" id="first" value="12" wire:model="clock_format"
                            wire:click="setClockFormat('12')">
                        <label for="first" class="label ps-lg-1 pe-2">12 Hours</label>

                        <input type="radio" id="second" value="24" wire:model="clock_format"
                            wire:click="setClockFormat('24')">
                        <label for="second" class="font-s-14 ps-lg-1 text-blue">24 Hours</label>
                    </div>
                </div>

                <div class="grid grid-cols-1  gap-4 elapsed {{ $main_units !== 'elapsed' ? 'hidden' : '' }}">
                    <p class="mt-2 px-1 font-s-14">{{ $lang['3'] }}</p>
                </div>
                <div class="grid grid-cols-4  gap-4 elapsed {{ $main_units !== 'elapsed' ? 'hidden' : '' }}">
                    {{-- Single field --}}
                    @if ($showElapsedStart)
                        <div>
                            <label class="label">{{ $elapsed_start_unit }}:</label>
                            <input type="number" step="any" wire:model="elapsed_start" id="elapsed_start"
                                class="input" aria-label="input" />
                        </div>
                    @endif
                    {{-- Hrs --}}
                    @if ($showElapsedStartOne)
                        <div>
                            <label class="label">hrs:</label>
                            <input type="number" step="any" id="elapsed_start_one" class="input"
                                aria-label="input" wire:model="elapsed_start_one" />
                        </div>
                    @endif

                    {{-- Mins --}}
                    @if ($showElapsedStartSec)
                        <div>
                            <label class="label">mins:</label>
                            <input type="number" step="any" name="" id="elapsed_start_sec" class="input"
                                aria-label="input" wire:model="elapsed_start_sec" />

                        </div>
                    @endif

                    {{-- Sec --}}
                    @if ($showElapsedStartThree)
                        <div>
                            <label class="label">sec:</label>
                            <input type="number" step="any" name="elapsed_start_three" id="elapsed_start_three"
                                class="input" aria-label="input" wire:model="elapsed_start_three" />
                        </div>
                    @endif

                    {{-- Dropdown --}}
                    <div class="space-y-2 elapsed_start_unit mt-3">
                        <div class="w-100 pt-2">
                            <select wire:model="elapsed_start_unit" wire:change="changeelapsed_start_unit"
                                class="input">
                                <option value="sec">sec</option>
                                <option value="mins">mins</option>
                                <option value="hrs">hrs</option>
                                <option value="mins/sec">mins/sec</option>
                                <option value="hrs/mins">hrs/mins</option>
                                <option value="hrs/mins/sec">hrs/mins/sec</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="grid grid-cols-1  gap-4 elapsed {{ $main_units !== 'elapsed' ? 'hidden' : '' }}">
                    <p class="mt-2 px-1 font-s-14">{{ $lang['4'] }}</p>
                </div>
                <div class="grid grid-cols-4  gap-4 elapsed {{ $main_units !== 'elapsed' ? 'hidden' : '' }}">
                    {{-- Single field --}}
                    @if ($showElapsedEnd)
                        <div>
                            <label class="label">{{ $elapsed_end_unit }}:</label>
                            <input type="number" step="any" wire:model="elapsed_end" name=""
                                id="elapsed_end" class="input" aria-label="input" />
                        </div>
                    @endif
                    {{-- Hrs --}}
                    @if ($showElapsedEndOne)
                        <div>
                            <label class="label">hrs:</label>
                            <input type="number" step="any" name="" id="elapsed_end_one" class="input"
                                aria-label="input" wire:model="elapsed_end_one" />
                        </div>
                    @endif

                    {{-- Mins --}}
                    @if ($showElapsedEndSec)
                        <div>
                            <label class="label">mins:</label>
                            <input type="number" step="any" name="" id="elapsed_end_sec" class="input"
                                aria-label="input" wire:model="elapsed_end_sec" />
                        </div>
                    @endif

                    {{-- Sec --}}
                    @if ($showElapsedEndThree)
                        <div>
                            <label class="label">sec:</label>
                            <input type="number" step="any" name="elapsed_end_three" id="elapsed_end_three"
                                class="input" aria-label="input" wire:model="elapsed_end_three" />
                        </div>
                    @endif

                    {{-- Dropdown --}}
                    <div class="space-y-2 elapsed_end_unit mt-3">
                        <div class="w-100 pt-2">
                            <select wire:model="elapsed_end_unit" wire:change="changeelapsed_end_unit"
                                class="input">
                                <option value="sec">sec</option>
                                <option value="mins">mins</option>
                                <option value="hrs">hrs</option>
                                <option value="mins/sec">mins/sec</option>
                                <option value="hrs/mins">hrs/mins</option>
                                <option value="hrs/mins/sec">hrs/mins/sec</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{-- 22222222 --}}
                <div class="grid grid-cols-1  gap-4 clock {{ $main_units !== 'elapsed' ? '' : 'hidden' }}">
                    <p class="mt-2 px-1 font-s-14">{{ $lang['6'] }}</p>
                </div>
                <div class="grid grid-cols-4  gap-4  clock {{ $main_units !== 'elapsed' ? '' : 'hidden' }}">
                    <div class="space-y-2 clock_hour">
                        <div class="w-100 py-2 relative">
                            <input type="number" step="any" name="" id="clock_hour" class="input"
                                aria-label="input" wire:model="clock_hour" />
                            <span class="input_unit text-blue">hrs</span>
                        </div>
                    </div>
                    <div class="space-y-2 clock_minute">
                        <div class="w-100 py-2 relative">
                            <input type="number" step="any" name="" id="clock_minute" class="input"
                                aria-label="input" wire:model="clock_minute" />
                            <span class="input_unit text-blue">min</span>
                        </div>
                    </div>
                    <div class="space-y-2 clock_second">
                        <div class="w-100 py-2 relative">
                            <input type="number" step="any" name="" id="clock_second" class="input"
                                aria-label="input" wire:model="clock_second" />
                            <span class="input_unit text-blue">sec</span>
                        </div>
                    </div>



                    <div class="space-y-2 clock_start_unit {{ $clock_format != '12' ? 'hidden' : '' }}">
                        <div class="w-100 py-2">
                            <select name="" wire:model="clock_start_unit" id="clock_start_unit"
                                class="input">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1  gap-4 clock {{ $main_units !== 'elapsed' ? '' : 'hidden' }}">
                    <p class="mt-2 px-1 font-s-14">{{ $lang['7'] }}</p>
                </div>
                <div class="grid grid-cols-4  gap-4 clock {{ $main_units !== 'elapsed' ? '' : 'hidden' }}">
                    <div class="space-y-2 clock_hur">
                        <div class="w-100 py-2 relative">
                            <input type="number" step="any" name="" id="clock_hur" class="input"
                                aria-label="input" wire:model="clock_hur" />
                            <span class="input_unit text-blue">hrs</span>
                        </div>
                    </div>
                    <div class="space-y-2 clock_mints">
                        <div class="w-100 py-2 relative">
                            <input type="number" step="any" wire:model="clock_mints" id="clock_mints"
                                class="input" aria-label="input" />
                            <span class="input_unit text-blue">min</span>
                        </div>
                    </div>
                    <div class="space-y-2 clock_secs">
                        <div class="w-100 py-2 relative">
                            <input type="number" step="any" name="" id="clock_secs" class="input"
                                aria-label="input" wire:model="clock_secs" />
                            <span class="input_unit text-blue">sec</span>
                        </div>
                    </div>
                    <div class="space-y-2 clock_end_unit {{ $clock_format != '12' ? 'hidden' : '' }}">
                        <div class="w-100 py-2">
                            <select name="" wire:model="clock_end_unit" id="clock_end_unit" class="input">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>

                            </select>
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
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg mt-5  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg  flex items-center justify-center">
                        <div class="w-full mt-3">
                            <div class="w-full my-2 overflow-auto">
                                <div class="lg:w-[70%] md:w-[80%] w-full gap-4 md:text-[18px] text-[16px]">
                                    <p class="mb-4 font-bold">
                                        {{ $detail['hours'] . ' Hours ' . $detail['minutes'] . ' Minutes ' . $detail['seconds'] . ' Seconds' }}
                                    </p>
                                    <table class="w-full">
                                        <tr>
                                            <td class="w-3/5 border-b py-2 font-bold">{{ $lang[9] }} :</td>
                                            <td class="border-b py-2">{{ $detail['answer'] }} {{ $lang[11] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-3" colspan="2">{{ $lang[1] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-b py-2">MM:SS</td>
                                            <td class="border-b py-2">
                                                @php
                                                    $seconds = $detail['answer'];
                                                    $minutes = floor($seconds / 60);
                                                    $seconds = $seconds % 60;
                                                    $time_format = sprintf('%02d:%02d', $minutes, $seconds);
                                                @endphp
                                                {{ $time_format }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border-b py-2">HH:MM</td>
                                            <td class="border-b py-2">
                                                @php
                                                    $seconds = $detail['answer'];
                                                    $hours = floor($seconds / 3600);
                                                    $seconds = $seconds % 3600;
                                                    $minutes = floor($seconds / 60);
                                                    $seconds = $seconds % 60;
                                                    $time_format = sprintf('%02d:%02d', $hours, $minutes);
                                                @endphp
                                                {{ $time_format }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border-b py-2">HH:MM:SS</td>
                                            <td class="border-b py-2">
                                                @php
                                                    $seconds = $detail['answer'];
                                                    $hours = floor($seconds / 3600);
                                                    $seconds = $seconds % 3600;
                                                    $minutes = floor($seconds / 60);
                                                    $seconds = $seconds % 60;
                                                    $time_format = sprintf(
                                                        '%02d:%02d:%02d',
                                                        $hours,
                                                        $minutes,
                                                        $seconds,
                                                    );
                                                @endphp
                                                {{ $time_format }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-3" colspan="2">{{ $lang[10] }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-b py-2">{{ $lang[12] }} :</td>
                                            <td class="border-b py-2">{{ round($detail['answer'] / 60, 4) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-b py-2">{{ $lang[8] }} :</td>
                                            <td class="border-b py-2">{{ round($detail['answer'] / 3600, 4) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-b py-2">{{ $lang[13] }} :</td>
                                            <td class="border-b py-2">{{ round($detail['answer'] / 86400, 4) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </form>
</div>

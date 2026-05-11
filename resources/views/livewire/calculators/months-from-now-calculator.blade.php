<div>

    <form wire:submit.prevent="calculate">

        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[50%] md:w-[50%] w-full mx-auto">
                <div class="grid grid-cols-12 mt-5 gap-4">
                    <div class="col-span-6 lg:px-0">
                        <div class="w-full mx-auto">
                            <label class="text-sm">{{ $lang['1'] }}</label>
                            <div class="grid grid-cols-6 text-center border rounded-md mt-2 bg-white">
                                @foreach ($days as $day)
                                    <p wire:click="selectDay({{ $day }})"
                                        class="col cursor-pointer border-r py-2
                                {{ $number == $day ? 'bg-[#55be30] text-white font-semibold' : '' }}">
                                        {{ $day }} </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-span-6 lg:px-0">
                        <div class="space-y-2">
                            <label for="number" class="text-sm">&nbsp;</label>
                            <input type="number" name="number" id="number" class="input border p-2 rounded w-full"
                                wire:model="number" aria-label="input" autocomplete="off" min="1" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-[50%] md:w-[50%] w-full mx-auto">
                <div class="grid grid-cols-12 mt-5 gap-4">
                    <div class="date-now col-span-6 relative">
                        <div class="flex justify-between items-center">
                            <label for="current" class="text-sm">{{ $lang['2'] ?? 'Select Date' }}:</label>
                            <!-- Livewire action for click -->
                            <span wire:click="setNow" class="text-sm text-right text-[#55be30] underline cursor-pointer"
                                style="user-select:none;">
                                {{ $lang['now'] ?? 'Now' }}
                            </span>
                        </div>
                        <div class="w-full ">
                            <input type="date" name="current" id="current" wire:model="current"
                                class="input focus:ring-[#38A169] input"
                                aria-label="input" />
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
                        <div class="col-12 bg-light-blue result p-3 radius-10 mt-3 overflow-auto">
                            <div class="grid grid-cols-1  lg:grid-cols-2 md:grid-cols-2  gap-4">
                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-sky p-2">
                                        <p>📅 Date</p>
                                        <p class="font-s-18"><strong>{{ $detail['t_date'] }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-sky p-2">
                                        <p>🌞 Day</p>
                                        <p class="font-s-18"><strong>{{ $detail['date_name'] }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-sky p-2">
                                        <p>📅 Weeks</p>
                                        <p class="font-s-18"><strong>{{ $detail['currentWeekOfYear'] }} /
                                                {{ $detail['weeksInYear'] }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-sky p-2">
                                        <p>📅 Year</p>
                                        <p class="font-s-18"><strong>{{ $detail['currentDayOfYear'] }} /
                                                {{ $detail['daysInYear'] }}</strong></p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center p-2">
                                What is <strong>{{ $detail['number'] }}</strong> weeks from now? The answer is
                                <strong>{{ $detail['date_name'] }}</strong>, <strong>{{ $detail['t_date'] }}</strong>. It
                                is the week <strong>{{ $detail['currentWeekOfYear'] }}</strong> of the total
                                {{ $detail['weeksInYear'] }} weeks of the year. It also marks the day
                                <strong>{{ $detail['currentDayOfYear'] }}</strong> out of
                                <strong>{{ $detail['daysInYear'] }}</strong> days of the year.
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        @endisset
    </form>

</div>

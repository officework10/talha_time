<div>
    <style>
        .bg-orange {
            background: #55be30;
            color: white;
        }

        .cl-orange {
            color: orange;
        }

        .days_box .col:hover {
            background-color: #55be30;
            color: white;
        }

        .mb_3 {
            margin-bottom: -5px;
        }

        #current {
            padding-right: 8px;
        }

        #current::-webkit-calendar-picker-indicator {
            cursor: pointer;
            font-size: 20px;
        }
    </style>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[50%] md:w-[50%] w-full mx-auto">
                <div class="grid grid-cols-12 mt-5  gap-4">
                    <div class="col-span-6 lg:px-0">
                        <div class="w-full mx-auto">
                            <label class="text-sm">{{ $lang['1'] ?? 'Select Days' }}</label>
                            <div class="grid grid-cols-6 text-center border rounded-md mt-2 bg-white days_box">
                                @foreach ($days as $day)
                                    <p wire:click="selectDay({{ $day }})"
                                        class="col cursor-pointer border-r py-2
                            {{ $number == $day ? 'bg-[#55be30] text-white font-semibold' : '' }}">
                                        {{ $day }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-span-6 lg:px-0">
                        <input type="hidden" id="selected_value" value="{{ $number ?? '' }}" />
                        <div class="space-y-2 inputshow">
                            <label for="number" class="text-sm">&nbsp;</label>

                            <input type="number" id="number" wire:model="number" min="1"
                                class="input border p-2 rounded w-full" autocomplete="off" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-[50%] md:w-[50%] w-full mx-auto">
                <div class="grid grid-cols-12 mt-5  gap-4">
                    <div class="date-now space-y-2 col-span-6 relative">
                        <div class="flex justify-between items-center">
                            <label for="current" class="text-sm">{{ $lang['2'] ?? 'Select Date' }}:</label>
                            <span wire:click="setNow"
                                class="text-sm text-right text-[#55be30] underline cursor-pointer now">
                                {{ $lang['now'] ?? 'Now' }}</span>

                        </div>
                        <div class="w-full py-2">
                            <input type="date" name="current" id="current" wire:model="current"
                                class="input-lg focus:ring-2 focus:ring-[#38A169] input"
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
                        <div class="w-full bg-light-blue result p-3 rounded-lg mt-3 overflow-auto">
                            <div class="flex flex-wrap">
                                <div class="lg:w-1/2 w-full p-1">
                                    <div class="border rounded-md bg-white p-2">
                                        <p>📅 Date</p>
                                        <p class="text-lg font-bold">{{ $detail['t_date'] }}</p>
                                    </div>
                                </div>
                                <div class="lg:w-1/2 w-full p-1">
                                    <div class="border rounded-md bg-white p-2">
                                        <p>🌞 Day</p>
                                        <p class="text-lg font-bold">{{ $detail['date_name'] }}</p>
                                    </div>
                                </div>
                                <div class="lg:w-1/2 w-full p-1">
                                    <div class="border rounded-md bg-white p-2">
                                        <p>📅 Weeks</p>
                                        <p class="text-lg font-bold">{{ $detail['currentWeekOfYear'] }} /
                                            {{ $detail['weeksInYear'] }}</p>
                                    </div>
                                </div>
                                <div class="lg:w-1/2 w-full p-1">
                                    <div class="border rounded-md bg-white p-2">
                                        <p>📅 Year</p>
                                        <p class="text-lg font-bold">{{ $detail['currentDayOfYear'] }} /
                                            {{ $detail['daysInYear'] }}</p>
                                    </div>
                                </div>
                                <p class="w-full text-center p-2">
                                    What is <strong>{{ $detail['number'] }}</strong> weeks from now? The answer is
                                    <strong>{{ $detail['date_name'] }}</strong>, <strong>{{ $detail['t_date'] }}</strong>.
                                    It is week <strong>{{ $detail['currentWeekOfYear'] }}</strong> of the total
                                    {{ $detail['weeksInYear'] }} weeks of the year. It also marks day
                                    <strong>{{ $detail['currentDayOfYear'] }}</strong> out of
                                    <strong>{{ $detail['daysInYear'] }}</strong> days of the year.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endisset
    </form>

</div>

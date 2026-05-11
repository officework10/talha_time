<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[50%] md:w-[70%] w-full mx-auto">
                <div class="grid grid-cols-12 gap-4">
                    <!-- Number Input -->
                    <div class="col-span-12 md:col-span-6">
                        <label for="number" class="font-s-14 ">{{ $lang['1'] }}:</label>
                        <div class="w-100 pt-1 pb-2">
                            <input type="number" id="number" class="input" wire:model="number" autocomplete="off" />
                        </div>
                    </div>

                    <!-- Date Input -->
                    <div class="col-span-12 md:col-span-6 datetime">
                        <div class="flex justify-between">
                            <label for="current" class="font-s-14 ">{{ $lang['2'] }}:</label>
                            <span class="font-s-14 text-end text-blue text-decoration-underline cursor-pointer"
                                wire:click="setNow">
                                {{ isset($lang['now']) ? $lang['now'] : 'Now' }}
                            </span>
                        </div>
                        <div class="w-100 ">
                            <input type="date" id="current" class="input" wire:model="current" />
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
                            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2   gap-4">
                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-[#F6FAFC] p-2">
                                        <p>📅 Date</p>
                                        <p class="font-s-18"><strong>{{ $detail['t_date'] }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-[#F6FAFC] p-2">
                                        <p>🌞 Day</p>
                                        <p class="font-s-18"><strong>{{ $detail['date_name'] }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-[#F6FAFC] p-2">
                                        <p>📅 Weeks</p>
                                        <p class="font-s-18"><strong>{{ $detail['currentWeekOfYear'] }} /
                                                {{ $detail['weeksInYear'] }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-[#F6FAFC] p-2">
                                        <p>📅 Year</p>
                                        <p class="font-s-18"><strong>{{ $detail['currentDayOfYear'] }} /
                                                {{ $detail['daysInYear'] }}</strong></p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center p-2">
                                What is <strong>{{ $detail['number'] }}</strong> days ago? The answer is
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

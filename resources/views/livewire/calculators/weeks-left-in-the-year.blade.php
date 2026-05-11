<div>

    <form wire:submit.prevent="calculate">

        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[60%] md:w-[60%] w-full mx-auto ">
                <div class="grid grid-cols-3  gap-4">

                    <div class="space-y-2">
                        <label for="month" class="label">{{ $lang['1'] }}</label>
                        <div class="w-100 py-2">
                            <select wire:model="month" class="input">
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}">
                                        {{ Carbon\Carbon::create()->month($m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="day" class="label">{{ $lang['2'] }}</label>
                        <div class="w-100 py-2">
                            <select wire:model="day" class="input">
                                @foreach (range(1, 31) as $d)
                                    <option value="{{ $d }}">{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="year" class="label">{{ $lang['3'] }}</label>
                        <div class="w-100 py-2">
                            <select wire:model="year" class="input">
                                @foreach (range(1950, 2050) as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
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
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg  flex items-center justify-center">

                        <div class="col-12  result p-3 radius-10 mt-3 overflow-auto">
                            @php
                                $remainingDaysAfterMonths = $detail['remainingDaysAfterMonths'];
                                $remainingDaysAfterWeeks = $detail['remainingDaysAfterWeeks'];
                            @endphp
                            <div class="text-center mb-3">
                                <p class="mb-2">{{ $lang['4'] }} <span class="currentYear">{{ $currentYear }}</span></p>
                                <p class="border radius-5 d-inline p-2 px-4 bg-sky font-s-25"><strong class="text-blue">
                                        {{ $detail['weeksRemaining'] }}
                                        @if ($detail['weeksRemaining'] == 1)
                                            Week
                                        @else
                                            Weeks
                                        @endif
                                        @if ($remainingDaysAfterWeeks == 0)
                                            {{ '' }}
                                        @elseif($remainingDaysAfterWeeks == 1)
                                            {{ $remainingDaysAfterWeeks }} Day
                                        @else
                                            {{ $remainingDaysAfterWeeks }} Days
                                        @endif

                                    </strong></p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2   gap-4">

                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-[#F6FAFC] p-2">
                                        <p>📅 Months</p>
                                        <p class="font-s-18"><strong>{{ $detail['monthsRemaining'] }}
                                                @if ($detail['monthsRemaining'] == 1)
                                                    Month
                                                @else
                                                    Months
                                                @endif
                                                @if ($remainingDaysAfterMonths == 0)
                                                    {{ '' }}
                                                @elseif($remainingDaysAfterMonths == 1)
                                                    {{ $remainingDaysAfterMonths }} Day
                                                @else
                                                    {{ $remainingDaysAfterMonths }} Days
                                                @endif
                                            </strong></p>
                                    </div>
                                </div>

                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-[#F6FAFC] p-2">
                                        <p>📅 Weeks</p>
                                        {{-- @dd($remainingDaysAfterWeeks) --}}
                                        <p class="font-s-18"><strong>{{ $detail['weeksRemaining'] }}
                                                @if ($detail['weeksRemaining'] == 1)
                                                    Week
                                                @else
                                                    Weeks
                                                @endif
                                                @if ($remainingDaysAfterWeeks == 0)
                                                    {{ '' }}
                                                @elseif($remainingDaysAfterWeeks == 1)
                                                    {{ $remainingDaysAfterWeeks }} Day
                                                @else
                                                    {{ $remainingDaysAfterWeeks }} Days
                                                @endif
                                            </strong></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-[#F6FAFC] p-2">
                                        <p>🌞 Days</p>
                                        <p class="font-s-18"><strong>{{ $detail['daysRemaining'] }}
                                                @if ($detail['daysRemaining'] == 1)
                                                    Day
                                                @else
                                                    Days
                                                @endif
                                            </strong></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 p-1">
                                    <div class="border radius-5 bg-[#F6FAFC] p-2">
                                        <p>🕑 Hours</p>
                                        <p class="font-s-18"><strong>{{ $detail['hoursRemaining'] }} hours</strong></p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center p-2">
                                How many weeks form <strong>{{ $detail['now'] }}</strong> left in this year ? The answer is
                                <strong>{{ $detail['weeksRemaining'] }}</strong>
                                @if ($detail['weeksRemaining'] == 1)
                                    Week
                                @else
                                    Weeks are
                                @endif left in End of the year.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </form>

</div>

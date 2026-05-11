<div>
    <style>
        .date_today {
            font-size: 32px;
        }

        .date_today1 {
            font-size: 35px;
            font-weight: 700;
        }

        .font14 {
            font-size: 14px
        }

        #time {
            color: #38A169;
        }
        .containe {
            display: inline-block;
            background-color: white;
            border-radius: 15px;
        }

        header {
            margin: 5px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 10px;
        }

        .header-display {
            display: flex;
            align-items: center;
        }

        .header-display p {
            color: var(--accent);
            margin: 5px;
            font-size: 1.2rem;
            word-spacing: 0.5rem;
        }

        pre {
            padding: 10px;
            margin: 0;
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--accent);
        }

        .days,
        .week {
            display: grid;
            grid-template-columns: repeat(7, 36px);
            margin: auto;
            padding: 0 1px;
            justify-content: space-between;
        }

        .week div,
        .days div {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 1.8rem;
            width: 1.8em;
            border-radius: 100%;
        }

        .days div:hover {
            background: #1971a959;
            color: white;
            cursor: pointer;
        }

        .week div {
            opacity: 0.5;
        }

        .current-date {
            background-color: #1670a7c4;
            color: white;
        }

        .display-selected {
            /* margin-bottom: 10px; */
            padding: 10px 0px;
            text-align: center;
        }

        .font-s-40 {
            font-size: 2.5em;
        }

        .selected_date {
            background: #1971a959;
            color: white;
        }
    </style>
    <div class="w-full mx-auto p-4 lg:p-8 md:p-8  rounded-lg input_form space-y-6 my-3">
        <div class="lg:w-[80%] md:w-[80%] w-full mx-auto text-center">
            <div class="w-full flex justify-center">
                <div class="w-20">
                    <div class="article-thumbnail article-thumbnail-spaceless">
                        <img fetchpriority="high" src="{{ asset('images/r_days.png') }}"
                            alt="icon for a calendar with one day highlighted red" width="80" height="auto"
                            decoding="async" loading="eager">
                    </div>
                </div>
            </div>

            <h2 class="mt-3 text-[28px] text-gray-600">{{ $lang['1'] ?? 'Today\'s Date Is' }}</h2>
            <p class="text-xl mt-2 mb-1">
                <span class="text-[32px] font-bold my-5">{{ $currentDate->format('l, F j, Y') }}</span>
            </p>

            <h2 class="text-[26px] font-bold text-red-600" wire:poll.1000ms="updateTime">
                {{ $currentTime }}
            </h2>

            <div class="mt-2 text-gray-600">
                {{ $timezoneInfo['timezone'] }} (GMT{{ $timezoneInfo['offset'] }})
            </div>

            <div class="w-full mt-6">
                <div class="max-w-[400px] mx-auto ">
                    <div class="calendar bg-white md:p-4 rounded-lg overflow-auto">
                        <header class="flex justify-between items-center mb-4">
                            <button wire:click="previousMonth" class="p-2 rounded-full hover:bg-gray-100">◀</button>
                            <div class="header-display">
                                <p class="display font-semibold">
                                    {{ Carbon\Carbon::create($calendarYear, $calendarMonth, 1)->format('F Y') }}
                                </p>
                            </div>
                            <button wire:click="nextMonth" class="p-2 rounded-full hover:bg-gray-100">▶</button>
                        </header>

                        <div class="week grid grid-cols-7 gap-1 text-center font-medium text-gray-500">
                            <div>Su</div>
                            <div>Mo</div>
                            <div>Tu</div>
                            <div>We</div>
                            <div>Th</div>
                            <div>Fr</div>
                            <div>Sa</div>
                        </div>

                        <div class="days grid grid-cols-7 md:gap-1 gap-0 mt-2">
                            @foreach ($calendarDays as $day)
                                @if (is_null($day))
                                    <div class="p-2"></div>
                                @else
                                    <div wire:click="selectDate('{{ $day['date'] }}')"
                                        class="md:p-2 rounded-full cursor-pointer text-center
                                    {{ $day['isCurrent'] ? 'bg-blue-600 text-white' : 'hover:bg-gray-100' }}
                                    {{ $selectedDate === $day['date'] ? 'ring-2 ring-blue-400' : '' }}">
                                        {{ $day['day'] }}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    @if ($selectedDate)
                        <div class="mt-3 text-sm text-gray-600">
                            <p>Selected Date: {{ Carbon\Carbon::parse($selectedDate)->format('D M d Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:w-[80%] md:w-[80%] w-full mx-auto mt-6">
            <p class="text-base mt-3 text-left">
                {{ $lang['2'] ?? 'Today is' }}, {{ $currentDate->format('F jS') }}, {{ $lang['3'] ?? 'day number' }}
                <strong class="text-blue-600">{{ $currentDate->dayOfYear }}</strong>
                {{ $lang['4'] ?? 'out of' }}
                {{ $currentDate->isLeapYear() ? '366 is a leap year' : '365 is not a leap year' }}
                {{ $lang['5'] ?? 'in the year' }} {{ $currentDate->year }}.
            </p>

            <div class="text-base space-y-2 mt-4">
                <p class="mt-1">There are <strong
                        class="text-blue-600">{{ $this->dateInfo['remainingDays'] }}</strong>
                    days remaining in this year <strong class="text-blue-600">{{ $currentDate->year }}</strong>.</p>
                <p class="mt-1">The current week number: {{ $this->dateInfo['weekNumber'] }} (of 52)</p>
                <p class="mt-1">The current week: <strong class="text-blue-600">{{ $this->dateInfo['startOfWeek'] }}
                        –
                        {{ $this->dateInfo['endOfWeek'] }}</strong></p>
                <p class="mt-1">The year <strong class="text-blue-600">{{ $currentDate->year }}</strong> has 52
                    weeks.</p>
                <p class="mt-1">Today's month number is: <strong
                        class="text-blue-600">{{ $this->dateInfo['monthNumber'] }}</strong></p>
            </div>
        </div>
    </div>
</div>

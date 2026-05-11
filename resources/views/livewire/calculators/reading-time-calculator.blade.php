<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[60%] md:w-[80%] w-full mx-auto ">

                <p>{{ $lang['1'] }}</p>
                <div class="grid grid-cols-1  lg:grid-cols-2 md:grid-cols-2  gap-4">
                    <div class="space-y-2 relative">
                        <label for="reading_speed" class="label">{{ $lang['2'] }}:</label>
                        <select name="" wire:model="reading_speed" id="reading_speed" class="input">
                            <option value="0.25">{{ $lang['11'] }}</option>
                            <option value="0.50">{{ $lang['12'] }}</option>
                            <option value="1">{{ $lang['13'] }}</option>

                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="read_pages" class="text-blue text-sm">{{ $lang['3'] }}:</label>
                        <div class="flex flex-wrap">
                            <div class="lg:w-2/3 p relative pr-1">
                                <input type="number" step="any" wire:model="read_pages" name=""
                                    id="read_pages" class="input w-full" aria-label="input" />
                                <span
                                    class="absolute right-0 top-1/2 transform -translate-y-1/2 text-blue px-2">pgs</span>
                            </div>
                            <div class="lg:w-1/3 ">
                                <select name="" wire:model="book_unit" id="book_unit" class="input w-full">
                                    <option value="min">{{ $lang['14'] }}</option>
                                    <option value="hr">{{ $lang['15'] }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="book_leng" class="label">{!! $lang['4'] !!}:</label>
                        <input type="number" step="any" name="" id="book_leng" class="input"
                            aria-label="input" wire:model="book_leng" />
                    </div>
                    <div class="space-y-2">
                        <label for="total_unit" class="label">{{ $lang['5'] }}
                            ({{ $lang['6'] }}):</label>
                        <select name="" wire:model="total_unit" id="total_unit" class="input">
                            <option value="min">{{ $lang['14'] }}</option>
                            <option value="hr">{{ $lang['15'] }}</option>
                            <option value="min/hr">{{ $lang['23'] }}</option>
                        </select>
                    </div>
                </div>
                <p class="mt-4">{{ $lang['7'] }}</p>
                <div class="grid grid-cols-1 mt-4  lg:grid-cols-2 md:grid-cols-2  gap-4">
                    <div class="space-y-2">
                        <label for="daily_reading" class="text-blue text-sm">{{ $lang['8'] }}:</label>
                        <div class="flex flex-wrap">
                            <div class="lg:w-2/3 relative pr-1">
                                <input type="number" step="any" wire:model="daily_reading" name=""
                                    id="daily_reading" class="input w-full" aria-label="input" />
                                <span
                                    class="absolute right-0 top-1/2 transform -translate-y-1/2 text-blue px-2">pgs</span>
                            </div>
                            <div class="lg:w-1/3 ">
                                <select name="" wire:model="time_unit" id="time_unit" class="input w-full">
                                    <option value="min">{{ $lang['14'] }}</option>
                                    <option value="hr">{{ $lang['15'] }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="reading_unit" class="label">{{ $lang['9'] }}
                            ({{ $lang['6'] }}):</label>
                        <select name="" wire:model="reading_unit" id="reading_unit" class="input">
                            <option value="min">{{ $lang['14'] }}</option>
                            <option value="hr">{{ $lang['15'] }}</option>
                            <option value="day">{{ $lang['16'] }}</option>
                            <option value="week">{{ $lang['17'] }}</option>
                            <option value="month">{{ $lang['18'] }}</option>
                            <option value="year">{{ $lang['19'] }}</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="period_unit" class="label">{{ $lang['10'] }}
                            ({{ $lang['6'] }}):</label>
                        <select name="" wire:model="period_unit" id="period_unit" class="input">
                            <option value="min">{{ $lang['14'] }}</option>
                            <option value="hr">{{ $lang['15'] }}</option>
                            <option value="day">{{ $lang['16'] }}</option>
                            <option value="week">{{ $lang['17'] }}</option>
                            <option value="month">{{ $lang['18'] }}</option>
                            <option value="year">{{ $lang['19'] }}</option>
                            <option value="minutes/hour">{{ $lang['23'] }}</option>
                            <option value="year/month/day">{{ $lang['24'] }}</option>
                            <option value="week/day">{{ $lang['25'] }}</option>
                            <option value="day/hour/minutes">{{ $lang['26'] }}</option>
                        </select>
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
                      <div class="w-full mt-3">
                            <div class="w-full my-2 overflow-auto">
                                <div class="lg:w-[70%] md:w-[80%] w-full gap-4 md:text-[18px] text-[16px]">
                                    <table class="w-full table-auto">
                                        <tr>
                                            <td class="w-3/5 border-b py-2 font-semibold">{{ $lang['20'] }} :</td>
                                            <td class="border-b py-2">{{ $detail['answer'] }}</td>
                                        </tr>
                                        @if (isset($detail['total_daily_reading']))
                                            <tr>
                                                <td class="border-b py-2 font-semibold">{{ $lang['21'] }} :</td>
                                                <td class="border-b py-2">{{ $detail['total_daily_reading'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="border-b py-2 font-semibold">{{ $lang['22'] }} :</td>
                                                <td class="border-b py-2">{{ $detail['period_spent'] }}</td>
                                            </tr>
                                        @endif
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

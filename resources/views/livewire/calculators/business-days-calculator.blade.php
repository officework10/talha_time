<div>
    <form wire:submit.prevent="calculate">
        {{-- @if (!isset($detail)) --}}

        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="mx-auto mt-2 lg:w-[30%] w-full">
                <input type="hidden" wire:model="sim_adv" name="" value="{{ $mode }}" id="sim_adv">

                <div class="grid grid-cols-12 gap-4 items-center bg-blue-100 border border-blue-500 text-center rounded-lg px-1">
                    {{-- Simple --}}
                    <div class="col-span-6 w-full px-2 py-1">
                        <div class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white pacetab {{ $mode === 'simple' ? 'tagsUnit' : '' }}"
                            wire:click="changeOperation('simple')">
                            {{ $lang['50'] ?? 'Simple' }}
                        </div>
                    </div>

                    {{-- Advance --}}
                    <div class="col-span-6 w-full px-2 py-1">
                        <div class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white pacetab {{ $mode === 'advance' ? 'tagsUnit' : '' }}"
                            wire:click="changeOperation('advance')">
                            {{ $lang['51'] ?? 'Advance' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-[55%] md:w-[80%] w-full mx-auto ">

                <div class="grid grid-cols-1   gap-4 simple {{ $mode !== 'simple' ? 'hidden' : 'd-block' }}  ">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-6">
                            <label for="s_date" class="label">{{ $lang['2'] }}:</label>
                            <div class="w-100 py-2">
                                <input type="date" wire:model="s_date" step="any" id="s_date" class="input"
                                    aria-label="input" />
                            </div>
                        </div>
                        <div class="col-span-6">
                            <label for="e_date" class="label">{{ $lang['2'] }}:</label>
                            <div class="w-100 py-2">
                                <input type="date" wire:model="e_date" step="any" id="e_date" class="input"
                                    aria-label="input" />
                            </div>
                        </div>
                    </div>
                    {{-- two checkbox --}}
                    <div class="col-6">
                        <input type="checkbox" wire:model="end_inc" id="end_inc" />
                        <label for="end_inc" class="label">{{ $lang[4] }}:</label>
                    </div>

                    <div class="col-6 ps-lg-4">
                        <input type="checkbox" wire:model="sat_inc" id="sat_inc" />
                        <label for="sat_inc" class="label">{{ $lang[5] }}?</label>
                    </div>


                    <p class="mt-2 font-s-14">{{ $lang['6'] }}</p>
                    <div class="col-6 mt-2">
                        <input type="radio" name="holiday_c" id="bedtime" value="no"
                            wire:click="changeHolidayC('no')" {{ $holiday_c === 'no' ? 'checked' : '' }}>
                        <label for="bedtime" class="label pe-lg-3 pe-2">{!! $lang['7'] !!}:</label>
                    </div>

                    <div class="col-6 mt-2 ps-lg-4">
                        <input type="radio" name="holiday_c" id="wkup" value="yes"
                            wire:click="changeHolidayC('yes')" {{ $holiday_c === 'yes' ? 'checked' : '' }}>
                        <label for="wkup" class="label">{!! $lang['8'] !!}:</label>
                    </div>
                    <div class="holiday my-3 {{ $holiday_c === 'yes' ? 'd-block' : 'hidden' }}">

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div class="space-y-2">
                                    <label class="d-block">
                                        <input name="" wire:model="nyd" checked type="checkbox"
                                            class="filled-in" />
                                        <span class="black-text">New Year's Day</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="mlkd" checked type="checkbox"
                                            class="filled-in" />
                                        <span class="black-text">M. L. King Day (US)</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="psd" checked type="checkbox"
                                            class="filled-in" />
                                        <span class="black-text">President's Day (US)</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="memd" type="checkbox" class="filled-in" />
                                        <span class="black-text">Memorial Day (US)</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="ind" checked type="checkbox"
                                            class="filled-in" />
                                        <span class="black-text">Independence Day (US)</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="labd" type="checkbox" class="filled-in" />
                                        <span class="black-text">Labor Day (US)</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="cold" checked type="checkbox"
                                            class="filled-in" />
                                        <span class="black-text">Columbus Day (US)</span>
                                    </label>
                                </div>

                            </div>
                            <div class="space-y-2">
                                <div class="space-y-2">
                                    <label class="d-block">
                                        <input name="" wire:model="vetd" checked type="checkbox"
                                            class="filled-in" />
                                        <span class="black-text">Veteran's Day (US)</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="thankd" checked type="checkbox"
                                            class="filled-in" />
                                        <span class="black-text">Thanksgiving (US)</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="blkf" type="checkbox" class="filled-in" />
                                        <span class="black-text">Black Friday (US)</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="cheve" checked type="checkbox"
                                            class="filled-in" />
                                        <span class="black-text">Christmas Eve</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="chirs" type="checkbox"
                                            class="filled-in" />
                                        <span class="black-text">Christmas</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="nye" checked type="checkbox"
                                            class="filled-in" />
                                        <span class="black-text">New Year's Eve</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- more add input  --}}
                        <p class="fw-bold mb-3 mt-2">If not in the list, define the holidays below:</p>

                        @foreach ($holidays as $index => $holiday)
                            <div class="grid grid-cols-3 gap-4 holiday-row">
                                <div class="space-y-2">
                                    <label for="holiday_name_{{ $index }}">Holiday</label>
                                    <input type="text" class="input my-2" id="holiday_name_{{ $index }}"
                                        wire:model="holidays.{{ $index }}.name" name="n{{ $index }}">
                                </div>
                                <div class="space-y-2">
                                    <label for="holiday_month_{{ $index }}">Month</label>
                                    <select class="input my-2" id="holiday_month_{{ $index }}"
                                        wire:model="holidays.{{ $index }}.month" name="m{{ $index }}">
                                        <option selected value="">--</option>
                                        <option value="01">Jan</option>
                                        <option value="02">Feb</option>
                                        <option value="03">Mar</option>
                                        <option value="04">Apr</option>
                                        <option value="05">May</option>
                                        <option value="06">Jun</option>
                                        <option value="07">Jul</option>
                                        <option value="08">Aug</option>
                                        <option value="09">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label for="holiday_day_{{ $index }}">Day</label>
                                    <select class="input my-2" id="holiday_day_{{ $index }}"
                                        wire:model="holidays.{{ $index }}.day" name="d{{ $index }}">
                                        <option selected value="">--</option>
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                @if ($index > 0)
                                    <button type="button"
                                        class="px-3 py-1 bg-red-500 text-white text-sm rounded-md shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200"
                                        wire:click="removeHoliday({{ $index }})">
                                        Remove
                                    </button>
                                @endif
                            </div>
                        @endforeach

                        <input type="hidden" name="total_i" value="{{ $totalHolidays }}" id="total_i">
                        <div class="add_holiday">

                        </div>
                        <div class="mt-3">
                            <button type="button" class="tagsUnit p-2 border radius-5 cursor-pointer"
                                wire:click="addHoliday">Add More Holidays</button>
                        </div>
                    </div>
                    <p class="mt-2 font-s-14">{{ $lang['9'] }}</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="ex_in" class="label"> {{ $lang[42] }}:</label>
                            <div class="w-100 py-2">
                                <select wire:model="ex_in" id="ex_in" class="input">
                                    <option value="1">{{ $lang[43] }}</option>
                                    <option value="2">{{ $lang[44] }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="satting" class="label"> {{ $lang[45] }}:</label>
                            <div class="w-100 py-2">
                                <select wire:model="satting" wire:change="changesatting" id="satting"
                                    class="input">
                                    <option value="2">{{ $lang[46] }}</option>
                                    <option value="4" disabled>{{ $lang[47] }}</option>
                                    <option value="5">{{ $lang[48] }}</option>
                                    <option value="6">{{ $lang[49] }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="{{ $showSelectDays ? 'd-block' : 'hidden' }}" id="select_days">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div class="space-y-2">
                                    <label class="d-block">
                                        <input name="" wire:model="sun" type="checkbox" class="filled-in"
                                            aria-label="input field">
                                        <span class="black-text">{{ $lang['18'] }}</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="mon" type="checkbox" class="filled-in"
                                            aria-label="input field">
                                        <span class="black-text">{{ $lang['41'] }}</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="tue" type="checkbox" class="filled-in"
                                            aria-label="input field">
                                        <span class="black-text">{{ $lang['42'] }}</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="wed" type="checkbox" class="filled-in"
                                            aria-label="input field">
                                        <span class="black-text">{{ $lang['43'] }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="space-y-2">
                                    <label class="d-block">
                                        <input name="" wire:model="thu" type="checkbox" class="filled-in"
                                            aria-label="input field">
                                        <span class="black-text">{{ $lang['44'] }}</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="fri" type="checkbox" class="filled-in"
                                            aria-label="input field">
                                        <span class="black-text">{{ $lang['45'] }}</span>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="d-block my-2">
                                        <input name="" wire:model="sat" type="checkbox" class="filled-in"
                                            aria-label="input field">
                                        <span class="black-text">{{ $lang['46'] }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- advance22222222222222222222222222 --}}
                <div class=" grid grid-cols-1  advance  gap-4 {{ $mode !== 'simple' ? 'd-block' : 'hidden' }} ">
                    <div class="grid grid-cols-2 gap-4 lg:grid-cols-2 md:grid-cols-2">
                        <div class="col-lg-6 col-12 mt-4 pe-lg-4">
                            <label for="add_date" class="label">{{ $lang['2'] }}:</label>
                            <div class="w-100 py-2">
                                <input type="date" step="any" id="add_date" wire:model="add_date"
                                    class="input" aria-label="input" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-12 mt-4 ps-lg-4">
                            <label for="method" class="label">{{ $lang['13'] }} /
                                {{ $lang['14'] }}:</label>
                            <div class="w-100 py-2">
                                <select id="method" wire:model="method" class="input">
                                    <option value="+">Add (+)</option>
                                    <option value="-">Subtract (-)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class=" grid grid-cols-4 gap-4 ">
                        <div class="space-y-2 {{ $cal_bus ? 'hidden' : '' }} ">
                            <label for="years" class="label">{{ $lang['32'] }}:</label>
                            <div class="w-100 py-2">
                                <input type="number" min="1" name="" id="years" class="input"
                                    aria-label="input" wire:model="years" />
                            </div>
                        </div>
                        <div class="space-y-2 {{ $cal_bus ? 'hidden' : '' }}">
                            <label for="months" class="label">{{ $lang['33'] }}:</label>
                            <div class="w-100 py-2">
                                <input type="number" min="1" name="" id="months" class="input"
                                    aria-label="input" wire:model="months" />
                            </div>
                        </div>
                        <div class="space-y-2 {{ $cal_bus ? 'hidden' : '' }}">
                            <label for="weeks" class="label">{{ $lang['39'] }}:</label>
                            <div class="w-100 py-2">
                                <input type="number" min="1" name="" id="weeks" class="input"
                                    aria-label="input" wire:model="weeks" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="days" class="label">{{ $lang['34'] }}:</label>
                            <div class="w-100 py-2">
                                <input type="number" min="1" name="" id="days" class="input"
                                    aria-label="input" wire:model="days" />
                            </div>
                        </div>
                    </div>


                    <div class="col-6">
                        <input type="checkbox" id="cal_bus" wire:model.live="cal_bus">
                        <label for="cal_bus" class="label">{{ $lang['15'] }}</label>
                    </div>

                    <div class=" checkrow {{ $cal_bus ? 'row' : 'hidden' }}">
                        <p class="mt-2 font-s-14">{{ $lang['16'] }}</p>
                        <div class="col-6 mt-2">
                            <input type="radio" name="weekend_c" wire:click="changeweekendC('no')" id="weekr"
                                value="no" {{ $weekend_c === 'no' ? 'checked' : '' }}>
                            <label for="weekr" class="label">{!! $lang['17'] !!}:</label>
                        </div>

                        <div class="col-6 mt-2 ps-lg-4">
                            <input type="radio" name="weekend_c" wire:click="changeweekendC('yes')" id="weekr2"
                                value="yes" {{ $weekend_c === 'yes' ? 'checked' : '' }}>
                            <label for="weekr2" class="label">{!! $lang['18'] !!}:</label>
                        </div>
                    </div>
                    <div class="week my-3 {{ $weekend_c === 'yes' ? 'd-block' : 'hidden' }}">
                        <div class="d-lg-flex">
                            <div class="col-lg-6">
                                <label class="d-block">
                                    <input name="" wire:model="nyd" checked type="checkbox"
                                        class="filled-in" />
                                    <span class="black-text">New Year's Day</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="mlkd" checked type="checkbox"
                                        class="filled-in" />
                                    <span class="black-text">M. L. King Day (US)</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="psd" checked type="checkbox"
                                        class="filled-in" />
                                    <span class="black-text">President's Day (US)</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="memd" type="checkbox" class="filled-in" />
                                    <span class="black-text">Memorial Day (US)</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="ind" checked type="checkbox"
                                        class="filled-in" />
                                    <span class="black-text">Independence Day (US)</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="labd" type="checkbox" class="filled-in" />
                                    <span class="black-text">Labor Day (US)</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="cold" checked type="checkbox"
                                        class="filled-in" />
                                    <span class="black-text">Columbus Day (US)</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="vetd" checked type="checkbox"
                                        class="filled-in" />
                                    <span class="black-text">Veteran's Day (US)</span>
                                </label>
                            </div>
                            <div class="col-lg-6 ps-lg-4">
                                <label class="d-block">
                                    <input name="" wire:model="thankd" checked type="checkbox"
                                        class="filled-in" />
                                    <span class="black-text">Thanksgiving (US)</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="blkf" type="checkbox" class="filled-in" />
                                    <span class="black-text">Black Friday (US)</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="cheve" checked type="checkbox"
                                        class="filled-in" />
                                    <span class="black-text">Christmas Eve</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="chirs" type="checkbox" class="filled-in" />
                                    <span class="black-text">Christmas</span>
                                </label>
                                <label class="d-block my-2">
                                    <input name="" wire:model="nye" checked type="checkbox"
                                        class="filled-in" />
                                    <span class="black-text">New Year's Eve</span>
                                </label>
                            </div>
                        </div>

                        <p class="fw-bold my-2">{{ $lang == 'en' ? 'If not in the list,' : '' }}
                            {{ $lang['9'] }}
                        </p>
                        @foreach ($holidays_two as $index => $holiday)
                            <div class="grid grid-cols-3 gap-4 holiday-row">
                                {{-- Holiday Name --}}
                                <div class="space-y-2">
                                    <label for="holiday_name_{{ $index }}">Holiday</label>
                                    <input type="text" class="input my-2" id="holiday_name_{{ $index }}"
                                        wire:model="holidays_two.{{ $index }}.name"
                                        name="n{{ $index }}">
                                </div>

                                {{-- Month --}}
                                <div class="space-y-2">
                                    <label for="holiday_month_{{ $index }}">Month</label>
                                    <select class="input my-2" id="holiday_month_{{ $index }}"
                                        wire:model="holidays_two.{{ $index }}.month"
                                        name="m{{ $index }}">
                                        <option value="">--</option>
                                        <option value="01">Jan</option>
                                        <option value="02">Feb</option>
                                        <option value="03">Mar</option>
                                        <option value="04">Apr</option>
                                        <option value="05">May</option>
                                        <option value="06">Jun</option>
                                        <option value="07">Jul</option>
                                        <option value="08">Aug</option>
                                        <option value="09">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>
                                    </select>
                                </div>

                                {{-- Day --}}
                                <div class="space-y-2">
                                    <label for="holiday_day_{{ $index }}">Day</label>
                                    <select class="input my-2" id="holiday_day_{{ $index }}"
                                        wire:model="holidays_two.{{ $index }}.day"
                                        name="d{{ $index }}">
                                        <option value="">--</option>
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                {{-- Remove Button --}}
                                @if ($index > 0)
                                    <button type="button"
                                        class="px-3 py-1 bg-red-500 text-white text-sm rounded-md shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200"
                                        wire:click="removeHoliday_two({{ $index }})">
                                        Remove
                                    </button>
                                @endif
                            </div>
                        @endforeach
                        <input type="hidden" wire:model="total_j" id="" value="{{ $totalHolidays_two }}">
                        <div class="mt-3">
                            <button type="button" class="tagsUnit p-2 border radius-5 cursor-pointer"
                                wire:click="addHoliday_two">
                                {{ $lang['11'] ?? 'Add Holiday' }}
                            </button>

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
                class="w-full mx-auto p-4 lg:p-8 md:p-8 mt-5 result_calculator rounded-lg  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg  flex items-center justify-center">
                        <div class="w-full mt-3">
                            <div class="w-full my-2">
                                @if (isset($detail['count_days']))
                                    {{-- @dd($detail['count_days']); --}}
                                    <div class="col-lg-8 font-s-18">
                                        <table class="w-100">
                                            <tr class="col">
                                                <td class="border-b py-2"><strong>{{ $lang['19'] }}</strong></td>
                                                <td class="border-b py-2">
                                                    {{ $detail['from'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class=" py-2"><strong>{{ $lang['20'] }}</strong></td>
                                                <td class=" py-2">
                                                    {{ $detail['to'] }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-b py-2">
                                                    {{ $detail['getworkdays']['workdays'] }} {{ $lang['34'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-b py-2">
                                                    {{ $lang['35'] }} {{ $detail['getworkdays']['workdays'] * 8 }}
                                                    {{ $lang['36'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-b py-2">
                                                    {{ $lang['35'] }}
                                                    {{ $detail['getworkdays']['workdays'] * 8 * 60 }}
                                                    {{ $lang['37'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-b py-2">
                                                    {{ $lang['35'] }}
                                                    {{ $detail['getworkdays']['workdays'] * 8 * 60 * 60 }}
                                                    {{ $lang['38'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pt-2"><strong>{{ $lang['21'] }}</strong></td>
                                            </tr>
                                            {{-- <div class="col-lg-8 font-s-18"> --}}
                                            {{-- <div class="col s12 m3"></div> --}}
                                            <tr>
                                                <td class="border-b py-2">Total Days</td>
                                                <td class="border-b py-2">{{ $detail['t_days'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="border-b py-2">Business Days</td>
                                                <td class="border-b py-2">{{ $detail['getworkdays']['workdays'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-b py-2">Weekend Days</td>
                                                <td class="border-b py-2">{{ $detail['getworkdays']['weekend'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-b py-2">Work Hours</td>
                                                <td class="border-b py-2">
                                                    {{ $detail['getworkdays']['workdays'] * 8 }}h
                                                </td>
                                            </tr>
                                            @if ($detail['holiday_c'] == 'yes')
                                                <tr>
                                                    <td class="border-b py-2">Holidays
                                                        {{ $detail['getworkdays']['holidays'] != 0 ? "<span class='view_holi'>(View result)</span>" : '' }}
                                                    </td>
                                                    <td class="border-b py-2">
                                                        {{ $detail['getworkdays']['holidays'] }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                @if ($detail['t_days'] && $detail['ans2'])
                                                    <td class="border-b py-2">
                                                        <strong class="">{{ $detail['t_days'] }}</strong>
                                                        Calendar
                                                        Days – <strong class="">{{ $detail['ans2'] }}</strong>
                                                        Skipped Days
                                                    </td>
                                                @endif
                                                @if (!empty($detail['weekends_days']))
                                                    <td class="border-b py-2">{{ $detail['weekends_days'] }} Weekend
                                                        Days</td>
                                                @endif
                                                @if (!empty($detail['holi_days']))
                                                    <td class="border-b py-2">
                                                        <strong>{{ $detail['holi_days'] }}</strong> holidays
                                                    </td>
                                                @endif
                                                @if (!empty($detail['sun_day']))
                                                    <td class="border-b py-2">
                                                        <strong>{{ $detail['sun_day'] }}</strong>
                                                    </td>
                                                @endif
                                                @if (!empty($detail['mon_day']))
                                                    <td class="border-b py-2">
                                                        <strong>{{ $detail['mon_day'] }}</strong>
                                                    </td>
                                                @endif
                                                @if (!empty($detail['tue_day']))
                                                    <td class="border-b py-2">
                                                        <strong>{{ $detail['tue_day'] }}</strong>
                                                    </td>
                                                @endif
                                                @if (!empty($detail['wed_day']))
                                                    <td class="border-b py-2">
                                                        <strong>{{ $detail['wed_day'] }}</strong>
                                                    </td>
                                                @endif
                                                @if (!empty($detail['thu_day']))
                                                    <td class="border-b py-2">
                                                        <strong>{{ $detail['thu_day'] }}</strong>
                                                    </td>
                                                @endif
                                                @if (!empty($detail['fri_day']))
                                                    <td class="border-b py-2">
                                                        <strong>{{ $detail['fri_day'] }}</strong>
                                                    </td>
                                                @endif
                                                @if (!empty($detail['sat_day']))
                                                    <td class="border-b py-2">
                                                        <strong>{{ $detail['sat_day'] }}</strong>
                                                    </td>
                                                @endif
                                                @if (!empty($detail['res_days']))
                                                    <td class="border-b py-2" id="resu">Result: </td>
                                                    <td class="border-b py-2"> {{ $detail['res_days'] }} Days</td>
                                                @endif
                                            </tr>
                                            {{-- </div> --}}
                                            @if ($detail['holiday_c'] == 'yes' && $detail['getworkdays']['holidays'] != 0)
                                                {{-- <div class="col s12 margin_top_10 display_none holi_result"> --}}
                                                <tr>
                                                    <td class="border-b py-2"><strong>{{ $lang['25'] }}
                                                            {{ $detail['from'] }} and {{ $detail['to'] }}</strong>
                                                    </td>
                                                </tr>
                                                {{-- <table class="table text-center w-75 mx-auto"> --}}
                                                @php
                                                    $holidays = $detail['getworkdays']['get_holi'] ?? [];
                                                    $count = count($holidays);
                                                @endphp

                                                @for ($i = 0; $i < $count; $i++)
                                                    <tr>
                                                        <td class="border-b py-2">
                                                            {{ $detail['getworkdays']['dis_holi'][$i] }}</td>
                                                        <td class="border-b py-2">
                                                            <strong>{{ $detail['getworkdays']['get_holi'][$i] }}</strong>
                                                        </td>
                                                    </tr>
                                                @endfor
                                                {{-- </table> --}}
                                                {{-- </div> --}}
                                            @endif
                                        </table>
                                    </div>
                                @else
                                    {{-- avdance  --}}
                                    <div class="col-lg-8 font-s-18">
                                        <table class="w-100">

                                            @if (isset($detail['cal_bus']))
                                                <tr>
                                                    <td colspan="2" width="60%" class="border-b py-2">
                                                        {{ $detail['date'] }}</td>
                                                </tr>
                                                <tr>
                                                    @if ($detail['method'] == '+')
                                                        <td colspan="2" class="border-b py-2">{{ $lang['28'] }}
                                                            {{ $detail['days'] }} {{ $lang['22'] }}
                                                            {{ $lang['29'] }} {{ $detail['from'] }}
                                                            {{ $lang['30'] }} {{ $detail['from_s'] }}
                                                            {{ $lang['26'] }} {{ $detail['date_e'] }}</td>
                                                    @else
                                                        <td colspan="2" class="border-b py-2">{{ $lang['28'] }}
                                                            {{ $detail['days'] }} {{ $lang['22'] }} before
                                                            {{ $detail['from'] }} {{ $lang['30'] }}
                                                            {{ $detail['date_e'] }} {{ $lang['31'] }}
                                                            {{ $detail['from_s'] }} and</td>
                                                    @endif
                                                </tr>
                                                {{-- <div class="col s12">
                                                    <div class="col s12 m3"></div>
                                                    <table class="table text-center w-75 mx-auto"> --}}
                                                <tr>
                                                    <td class="border-b py-2">{{ $lang['22'] }}</td>
                                                    <td class="border-b py-2">{{ $detail['days'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="border-b py-2">{{ $lang['23'] }}</td>
                                                    <td class="border-b py-2">{{ $detail['weekends'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="border-b py-2">{{ $lang['24'] }}
                                                        {!! $detail['holidays'] != 0 ? "<span class='view_holi'>(View result)</span>" : '' !!}
                                                    </td>
                                                    <td class="border-b py-2">{{ $detail['holidays'] }}</td>
                                                </tr>
                                                {{-- </table>
                                                </div> --}}
                                                @if ($detail['weekend_c'] == 'yes' && $detail['holidays'] != 0)
                                                    {{-- <div class="col s12 margin_top_10 display_none holi_result"> --}}
                                                    <tr>
                                                        <td class="border-b py-2"><strong>{{ $lang['25'] }}
                                                                {{ $detail['from'] }} {{ $lang['26'] }}
                                                                {{ $detail['date'] }}</strong></td>
                                                    </tr>
                                                    {{-- <table class="table text-center w-75 mx-auto"> --}}
                                                     @php
                                                        $holidayses = $detail['get_holi'] ?? [];
                                                        $count = count($holidayses);
                                                    @endphp
                                                    
                                                    @for ($i = 0; $i < $count; $i++)
                                                        <tr>
                                                            <td class="border-b py-2">{{ $detail['dis_holi'][$i] }}
                                                            </td>
                                                            <td class="border-b py-2">{{ $detail['get_holi'][$i] }}
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                    {{-- </table> --}}
                                                    {{-- </div> --}}
                                                @endif
                                            @else
                                                <tr>
                                                    <td width="60%" class="border-b py-2">{{ $lang['19'] }}
                                                    </td>
                                                    <td class="border-b py-2">{{ $detail['from'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="border-b py-2">
                                                        {{ $detail['des'] ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="border-b py-2">{{ $lang['27'] }}</td>
                                                    <td class="border-b py-2">{{ $detail['date'] }}</td>
                                                    </td>
                                            @endif
                                        </table>
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

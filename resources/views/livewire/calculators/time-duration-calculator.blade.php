<div>
    <form wire:submit.prevent="calculate" class="row">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="col-12 col-lg-9 mx-auto mt-2 lg:w-[50%] w-full">
                <input type="hidden" wire:model="calculator_time" id="calculator_time">
                <div class="flex flex-wrap items-center bg-blue-100 border border-blue-500 text-center rounded-lg px-1">
                    <!-- Date Tab -->
                    <div class="lg:w-1/2 w-full px-2 py-1">
                        <div wire:click="changeOperation('date_cal')"
                            class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white pacetab 
                {{ $calculator_time === 'date_cal' ? 'tagsUnit' : '' }}">
                            {{ $lang['1'] }}
                        </div>
                    </div>
                    <!-- Time Tab -->
                    <div class="lg:w-1/2 w-full px-2 py-1">
                        <div wire:click="changeOperation('time_cal')"
                            class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white pacetab 
                {{ $calculator_time === 'time_cal' ? 'tagsUnit' : '' }}">
                            {{ $lang['2'] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-[80%] md:w-[80%] w-full mx-auto ">
                <p class="font-s-14 mt-4 text-blue">{{ $lang['3'] }}</p>
                <div
                    class="grid lg:grid-cols-5 grid-cols-2 md:gap-4 gap-2 time_betw  {{ $calculator_time === 'time_cal' ? 'flex' : 'hidden' }}">
                    <div class="space-y-2">
                        <label for="start_date" class="text-blue text-sm">Date:</label>
                        <div class="py-2">
                            <input type="date" step="any" name="" id="start_date"
                                class="input" wire:model="start_date" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="t_start_h" class="text-blue text-sm">Hrs:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="t_start_h"
                                class="input" wire:model="t_start_h"
                                placeholder="Hrs" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="t_start_m" class="text-blue text-sm">Min:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="t_start_m"
                                class="input" wire:model="t_start_m"
                                placeholder="Min" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="t_start_s" class="text-blue text-sm">Sec:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="t_start_s"
                                class="input" wire:model="t_start_s"
                                placeholder="Sec" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="py-2">
                            <label for="t_start_ampm" class="text-blue text-sm">&nbsp;</label>
                            <select name="" wire:model="t_start_ampm" id="t_start_ampm"
                                class="select mt-2">
                                <option value="am">AM</option>
                                <option value="pm">PM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div
                    class="grid lg:grid-cols-4 grid-cols-2 md:gap-4 gap-2 time_due {{ $calculator_time === 'time_cal' ? 'hidden' : 'flex' }} ">
                    <div class="space-y-2">
                        <label for="d_start_h" class="text-blue text-sm">Hrs:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="d_start_h"
                                class="input" wire:model="d_start_h"
                                placeholder="Hrs" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="d_start_m" class="text-blue text-sm">Min:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="d_start_m"
                                class="input" wire:model="d_start_m"
                                placeholder="Min" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="d_start_s" class="text-blue text-sm">Sec:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="d_start_s"
                                class="input" wire:model="d_start_s"
                                placeholder="Sec" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="py-2">
                            <label for="d_start_ampm" class="text-blue text-sm">&nbsp;</label>
                            <select name="" wire:model="d_start_ampm" id="d_start_ampm"
                                class="select mt-2">
                                <option value="am">AM</option>
                                <option value="pm">PM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <p class="label mt-2">{{ $lang['6'] }}</p>
                <div
                    class="grid lg:grid-cols-5 grid-cols-2 md:gap-4 gap-2 time_betw  {{ $calculator_time === 'time_cal' ? 'flex' : 'hidden' }}">
                    <div class="space-y-2">
                        <label for="end_date" class="text-blue text-sm">Date:</label>
                        <div class="py-2">
                            <input type="date" step="any" name="" id="end_date" class="input w-full"
                                wire:model="end_date" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="t_end_h" class="text-blue text-sm">Hrs:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="t_end_h" class="input w-full"
                                wire:model="t_end_h" placeholder="Hrs" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="t_end_m" class="text-blue text-sm">Min:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="t_end_m" class="input w-full"
                                wire:model="t_end_m" placeholder="Min" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="t_end_s" class="text-blue text-sm">Sec:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="t_end_s" class="input w-full"
                                wire:model="t_end_s" placeholder="Sec" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="py-2">
                            <label for="t_end_ampm" class="text-blue text-sm">&nbsp;</label>
                            <select name="" wire:model="t_end_ampm" id="t_end_ampm"
                                class="input w-full mt-2">
                                <option value="am">AM</option>
                                <option value="pm">PM</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div
                    class="grid lg:grid-cols-4 grid-cols-2 md:gap-4 gap-2 time_due {{ $calculator_time === 'time_cal' ? 'hidden' : 'flex' }} ">

                    <div class="space-y-2">
                        <label for="d_end_h" class="text-blue text-sm">Hrs:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="d_end_h" class="input w-full"
                                wire:model="d_end_h" placeholder="Hrs" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="d_end_m" class="text-blue text-sm">Min:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="d_end_m" class="input w-full"
                                wire:model="d_end_m" placeholder="Min" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="d_end_s" class="text-blue text-sm">Sec:</label>
                        <div class="py-2">
                            <input type="number" step="any" name="" id="d_end_s" class="input w-full"
                                wire:model="d_end_s" placeholder="Sec" />
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="py-2">
                            <label for="d_end_ampm" class="text-blue text-sm">&nbsp;</label>
                            <select name="" wire:model="d_end_ampm" id="d_end_ampm"
                                class="input w-full mt-2">
                                <option value="am">AM</option>
                                <option value="pm">PM</option>
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
                        <div class="w-full mt-3">
                            <div class="w-full my-2 overflow-auto">
                                <div class="w-full gap-4">
                                    <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                                        <div class="col-span-12 flex justify-center">
                                            <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4 mt-5">
                                                @if ($detail['calculator_time'] == 'date_cal')
                                                    <div class="col-span-12 md:col-span-3 lg:col-span-3 flex items-center px-5 text-center justify-center">
                                                        <img src="{{ asset('icons/r_days.png') }}" width="30px" height="auto" alt="Days"/>
                                                        <span class="text-[#49987d] text-[20px] mx-2">{{ $lang['4'] ?? 'Date' }}</span>
                                                        <span class="fs-2 text-dark text-[20px]">{{ $detail['days_ans'] }}</span>
                                                    </div>
                                                @endif

                                                <div class="col-span-12 md:col-span-3 lg:col-span-3 flex items-center px-5 text-center justify-center">
                                                    <img src="{{ asset('icons/r_hour.png') }}" width="30px" height="auto" alt="hours"/>
                                                    <span class="text-[#49987d] text-[20px] mx-2">{{ $lang['1'] ?? 'Hours' }}</span>
                                                    <span class="fs-2 text-dark text-[20px]">{{ $detail['hours'] }}</span>
                                                </div>
                                                <div class="col-span-12 md:col-span-3 lg:col-span-3 flex items-center px-5 text-center justify-center">
                                                    <img src="{{ asset('icons/r_mint.png') }}" width="30px" height="auto" alt="minuts"/>
                                                    <span class="text-[#49987d] text-[20px] mx-2">{{ $lang['2'] ?? 'Minutes' }}</span>
                                                    <span class="fs-2 text-dark text-[20px]">{{ $detail['minutes'] }}</span>
                                                </div>
                                                <div class="col-span-12 md:col-span-3 lg:col-span-3 flex items-center px-5 text-center justify-center">
                                                    <img src="{{ asset('icons/r_sec.png') }}" width="30px" height="auto" alt="second"/>
                                                    <span class="text-[#49987d] text-[20px] mx-2">{{ $lang['3'] ?? 'Seconds' }}</span>
                                                    <span class="fs-2 text-dark text-[20px]">{{ $detail['seconds'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-12 mt-5 ">
                                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                                                    <tr>
                                                        @if ($detail['calculator_time'] == 'date_cal')
                                                            <td class="text-[#49987d] border p-3 text-[14px] md:text-[16px] lg:text-[16px] font-semibold ">{{ $lang['9'] ?? "Total Days" }}</td>
                                                        @endif
                                                        <td class="text-[#49987d] border p-3 text-[14px] md:text-[16px] lg:text-[16px] font-semibold ">{{ $lang['10'] ?? "Total Hours" }}</td>
                                                        <td class="text-[#49987d] border p-3 text-[14px] md:text-[16px] lg:text-[16px] font-semibold ">{{ $lang['11'] ?? "Total Minutes" }}</td>
                                                        <td class="text-[#49987d] border p-3 text-[14px] md:text-[16px] lg:text-[16px] font-semibold ">{{ $lang['12'] ?? "Total Seconds" }}</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @if ($detail['calculator_time'] == 'date_cal')
                                                            <td class="border p-3 text-[14px] md:text-[16px] lg:text-[16px] ">{{ $detail['total_days'] }}</td>
                                                        @endif
                                                        <td class="border p-3 text-[14px] md:text-[16px] lg:text-[16px] ">{{ $detail['total_hours'] }}</td>
                                                        <td class="border p-3 text-[14px] md:text-[16px] lg:text-[16px] ">{{ $detail['total_minutes'] }}</td>
                                                        <td class="border p-3 text-[14px] md:text-[16px] lg:text-[16px] ">{{ $detail['total_seconds'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
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

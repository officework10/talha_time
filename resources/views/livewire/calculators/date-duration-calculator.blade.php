<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[60%] md:w-[90%] w-full mx-auto ">
                <div class="grid grid-cols-2 text-center gap-4">
                    <a href="{{ url('date-duration-calculator') }}/"
                        class="cursor-pointer py-2 text-[#55be30] border-b-2 border-[#55be30]">
                        <strong>{{ $lang['1'] }}</strong>
                    </a>
                    <a href="{{ url('date-calculator') }}/" class="cursor-pointer py-2">
                        <strong>{{ $lang['2'] }}</strong>
                    </a>
                </div>

                <div class="grid grid-cols-1 mt-4 lg:grid-cols-2 gap-4">
                    <!-- Start Date -->
                    <div class="space-y-2 relative">
                        <div class="flex justify-between items-center">
                            <label for="s_date" class="text-[14px] text-[#1670a7]">{{ $lang['6'] }}:</label>
                            <span
                                class="text-[14px] text-[#1670a7] underline cursor-pointer hover:text-[#125a87] transition-colors"
                                wire:click="setNowDate">
                                {{ $lang['now'] }}
                            </span>
                        </div>
                        <input type="date" id="s_date" wire:model.defer="s_date"
                            class="input input focus:outline-none focus:ring-2 focus:ring-[#1670a7]" />
                    </div>

                    <!-- End Date -->
                    <div class="space-y-2 relative">
                        <div class="flex justify-between items-center">
                            <label for="e_date" class="text-[14px] text-[#1670a7]">{{ $lang['8'] }}:</label>
                            <span
                                class="text-[14px] text-[#1670a7] underline cursor-pointer hover:text-[#125a87] transition-colors"
                                wire:click="settwoNowDate">
                                {{ $lang['now'] }}
                            </span>
                        </div>
                        <input type="date" id="e_date" wire:model.defer="e_date"
                            class="input input focus:outline-none focus:ring-2 focus:ring-[#1670a7]" />
                    </div>

                    <!-- Checkbox (full width on all screens) -->
                    <div class="space-y-2 relative col-span-1 lg:col-span-2 flex items-center gap-2">
                        <input type="checkbox" id="checkbox" wire:model="checkbox"
                            class="h-5 w-5 text-[#1670a7] focus:ring-[#1670a7] border-gray-300 rounded-full" />
                        <label for="checkbox" class="text-[14px] text-[#1670a7]"
                            style="margin-top: 0px;">{{ $lang['9'] }}</label>
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
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    
                    <div class="w-full mx-auto rounded-3xl">
                        <div class="w-full mx-auto">
                            <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                                <div id="res_copy" class="col-span-12 text-center">
                                    <div class="flex justify-center gap-4 text-[18px] my-4">
                                        <div>
                                            <span class="mb-0 text-color">{{ $lang['10'] }}:</span>
                                            <span class="mb-0">{{ $detail['from'] }}</span>
                                        </div>
                                        <div>
                                            <span class="mb-0 text-color">{{ $lang['11'] }}:</span>
                                            <span class="mb-0">{{ $detail['to'] }}</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-center items-center gap-3 mt-2">
                                        <p class="m-0 text-[30px] text-color text-[#49987d]"><b>{{ number_format($detail['total_days']) }} {{ $lang['14'] ?? 'Days' }}</b></p>
                                    </div>
                                    <p class="m-0 h4 mt-3 text-[25px] text-center"><b>{{ $lang['19'] ?? 'Alternative time units' }}</b></p>
                                    <p class="m-0 mt-2 text-center">{{ number_format($detail['total_days']) }} {{ $lang['20'] ?? 'Days can be converted to one of these units' }}</p>
                                    <div class="my-5 overflow-auto">
                                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 border">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 border">
                                                <tr>
                                                    <td class="text-[14px] md:text-[16px] lg:text-[16px] font-bold p-3 border text-center text-[#49987d]">{{ $lang['18'] }}</td>
                                                    <td class="text-[14px] md:text-[16px] lg:text-[16px] font-bold p-3 border text-center text-[#49987d]">{{ $lang['17'] }}</td>
                                                    <td class="text-[14px] md:text-[16px] lg:text-[16px] font-bold p-3 border text-center text-[#49987d]">{{ $lang['16'] }}</td>
                                                    <td class="text-[14px] md:text-[16px] lg:text-[16px] font-bold p-3 border text-center text-[#49987d]">{{ $lang['14'] }}</td>
                                                    <td class="text-[14px] md:text-[16px] lg:text-[16px] font-bold p-3 border text-center text-[#49987d]">{{ $lang['15'] }}</td>
                                                </tr>
                                            </thead>
                                            <tbody class="border">
                                                <tr>
                                                    <td class="text-[14px] md:text-[16px] lg:text-[16px] p-3 border text-center">{{ number_format($detail['total_days'] * 24 * 60 * 60) }}</td>
                                                    <td class="text-[14px] md:text-[16px] lg:text-[16px] p-3 border text-center">{{ number_format($detail['total_days'] * 24 * 60) }}</td>
                                                    <td class="text-[14px] md:text-[16px] lg:text-[16px] p-3 border text-center">{{ number_format($detail['total_days'] * 24) }}</td>
                                                    <td class="text-[14px] md:text-[16px] lg:text-[16px] p-3 border text-center">{{ number_format($detail['total_days']) }}</td>
                                                    <td class="text-[14px] md:text-[16px] lg:text-[16px] p-3 border text-center">
                                                        {{ number_format(floor($detail['total_days'] / 7)) }} {{ $lang['15'] }},
                                                        {{ number_format($detail['total_days'] % 7) }} {{ $lang['14'] }}
                                                    </td>
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
        @endisset
    </form>

</div>


<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="lg:w-[60%] md:w-[100%] w-full mx-auto">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-12 p-select-color mt-2">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                            <div class="col-span-6 md:col-span-3 lg:col-span-3 flex items-center">
                                <label class="flex items-center space-x-3 label">
                                    <input type="checkbox" wire:model.live="checkbox1" id="hours_check" class="filled-in">
                                    <span class="black-text">{{ $lang['1'] ?? 'Hours' }}</span>
                                </label>
                            </div>
                            <div class="col-span-6 md:col-span-3 lg:col-span-3 flex items-center">
                                <label class="flex items-center space-x-3 label">
                                    <input type="checkbox" wire:model.live="checkbox2" id="min_check" class="filled-in">
                                    <span class="black-text">{{ $lang['2'] ?? 'Minutes' }}</span>
                                </label>
                            </div>
                            <div class="col-span-6 md:col-span-3 lg:col-span-3 flex items-center">
                                <label class="flex items-center space-x-3 label">
                                    <input type="checkbox" wire:model.live="checkbox3" id="sec_check" class="filled-in">
                                    <span class="black-text">{{ $lang['3'] ?? 'Seconds' }}</span>
                                </label>
                            </div>
                            <div class="col-span-6 md:col-span-3 lg:col-span-3 flex items-center">
                                <label class="flex items-center space-x-3 label">
                                    <input type="checkbox" wire:model.live="checkbox4" id="milli_check" class="filled-in">
                                    <span class="black-text">{{ $lang['4'] ?? 'Milliseconds' }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="first_time" class="col-span-12">
                        @foreach($rows as $index => $row)
                            <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4 my-2 items-end border-b md:border-none pb-4 md:pb-0">
                                <div class="col-span-3 md:col-span-3 relative">
                                    <label class="label text-[10px] md:text-sm">{{ $lang['1'] ?? 'Hours' }}</label>
                                    <input type="number" wire:model.live="rows.{{ $index }}.inhour" 
                                           class="input remove_shadow t_sec py-1 px-2" placeholder="_ _"
                                           {{ !$checkbox1 ? 'disabled' : '' }}>
                                </div>
                                <div class="col-span-3 md:col-span-3 relative">
                                    <label class="label text-[10px] md:text-sm">{{ $lang['2'] ?? 'Minutes' }}</label>
                                    <input type="number" wire:model.live="rows.{{ $index }}.inminutes" 
                                           class="input remove_shadow t_sec py-1 px-2" placeholder="_ _"
                                           {{ !$checkbox2 ? 'disabled' : '' }}>
                                </div>
                                <div class="col-span-3 md:col-span-3 relative">
                                    <label class="label text-[10px] md:text-sm">{{ $lang['3'] ?? 'Seconds' }}</label>
                                    <input type="number" wire:model.live="rows.{{ $index }}.inseconds" 
                                           class="input remove_shadow t_sec py-1 px-2" placeholder="_ _"
                                           {{ !$checkbox3 ? 'disabled' : '' }}>
                                </div>
                                <div class="col-span-2 md:col-span-2 relative">
                                    <label class="label text-[10px] md:text-sm">{{ $lang['4'] ?? 'Milli' }}</label>
                                    <input type="number" wire:model.live="rows.{{ $index }}.inmiliseconds" 
                                           class="input remove_shadow t_sec py-1 px-2" placeholder="_ _"
                                           {{ !$checkbox4 ? 'disabled' : '' }}>
                                </div>
                                @if(count($rows) > 2)
                                    <div class="col-span-1 md:col-span-1 flex items-center justify-center">
                                        <img src="{{ asset('icons/delete_btn.png') }}" wire:click="removeRow({{ $index }})" 
                                             width="18px" height="18px" class="cursor-pointer mb-2" alt="Delete">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="text-end col-span-12">
                        <button type="button" wire:click="addRow" title="Add New Time" 
                                class="btn add_btn bg-green-600 text-white p-2 rounded-lg border_1px_blue">+ Add Row</button>
                    </div>
                </div>

                @if ($type == 'calculator')
                    @include('inc.button')
                @endif
                @if ($type == 'widget')
                    @include('inc.widget-button')
                @endif
            </div>
        </div>

        @if (isset($detail))
            <div id="result-section" wire:loading.remove wire:target="calculate"
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif

                    <div class="w-full mx-auto rounded-3xl">
                        <div class="w-full mx-auto">
                            <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                                <div class="col-span-12 relative overflow-x-auto mt-4">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <tr>
                                            <td class="p-4 border">
                                                <div class="flex justify-center align-center text-center">
                                                    <img src="{{ asset('icons/r_days.png') }}" width="24px" height="22px" alt="Hours">
                                                    <span class="text-[#49987d] text-[12px] md:text-[20px] lg:text-[20px] mx-2">{{ $lang['1'] ?? 'Hours' }}</span>
                                                </div>
                                            </td>
                                            <td class="p-4 border">
                                                <div class="flex justify-center align-center text-center">
                                                    <img src="{{ asset('icons/r_hour.png') }}" width="22px" height="22px" alt="Minutes">
                                                    <span class="text-[#49987d] text-[12px] md:text-[20px] lg:text-[20px] mx-2">{{ $lang['2'] ?? 'Minutes' }}</span>
                                                </div>
                                            </td>
                                            <td class="p-4 border">
                                                <div class="flex justify-center align-center text-center">
                                                    <img src="{{ asset('icons/r_mint.png') }}" width="22px" height="22px" alt="Second">
                                                    <span class="text-[#49987d] text-[12px] md:text-[20px] lg:text-[20px] mx-2">{{ $lang['3'] ?? 'Seconds' }}</span>
                                                </div>
                                            </td>
                                            <td class="p-4 border">
                                                <div class="flex justify-center align-center text-center">
                                                    <img src="{{ asset('icons/r_sec.png') }}" width="19px" height="22px" alt="Millisecond">
                                                    <span class="text-[#49987d] text-[12px] md:text-[20px] lg:text-[20px] mx-2">{{ $lang['4'] ?? 'Milliseconds' }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-4 text-center border text-[14px] md:text-[20px] lg:text-[20px]">
                                                <b class="clr text-[14px] md:text-[20px] lg:text-[20px]">
                                                    {{ round($detail['time_hour']) }}
                                                </b>
                                                {{ $lang['1'] ?? 'Hours' }}
                                            </td>
                                            <td class="p-4 text-center border text-[14px] md:text-[20px] lg:text-[20px]">
                                                <b class="clr text-[14px] md:text-[20px] lg:text-[20px]">
                                                    {{ round($detail['time_minutes']) }}
                                                </b>
                                                {{ $lang['2'] ?? 'Minutes' }}
                                            </td>
                                            <td class="p-4 text-center border text-[14px] md:text-[20px] lg:text-[20px]">
                                                <b class="clr text-[14px] md:text-[20px] lg:text-[20px]">
                                                    {{ round($detail['time_seconds']) }}
                                                </b>
                                                {{ $lang['3'] ?? 'Seconds' }}
                                            </td>
                                            <td class="p-4 text-center border text-[14px] md:text-[20px] lg:text-[20px]">
                                                <b class="clr text-[14px] md:text-[20px] lg:text-[20px]">
                                                    {{ round($detail['time_miliseconds'], 2) }}
                                                </b>
                                                {{ $lang['4'] ?? 'Milliseconds' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>

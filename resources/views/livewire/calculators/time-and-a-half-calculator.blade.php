<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[60%] md:w-[100%] w-full mx-auto">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-12">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4 mx-auto">
                            {{-- Currency --}}
                            <div class="col-span-2 hidden md:block lg:block"></div>
                            <div class="col-span-12 md:col-span-6 lg:col-span-8">
                                <label for="next" class="label">{{ $lang['0'] ?? "Currency:" }}</label>
                                <div class="grid grid-cols-6 gap-2 md:gap-4 lg:gap-4 currency_box border">
                                    @foreach(['$', '€', '£', '₹', '¥', 'Rs'] as $currency)
                                        <p wire:click="setCurrency('{{ $currency }}')" 
                                           class="col cursor-pointer text-center border-end py-2 text-[14px] {{ $selected_currency === $currency ? 'v_active' : '' }}">
                                            {{ $currency }}
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-span-2 hidden md:block lg:block"></div>
                            <div class="col-span-2 hidden md:block lg:block"></div>

                            {{-- Pay rate choice --}}
                            <div class="col-span-12 md:col-span-6 lg:col-span-8">
                                <label for="next" class="label">{{ $lang['1'] ?? 'Pay rate choice:' }}</label>
                                <div class="grid grid-cols-5 gap-2 md:gap-4 lg:gap-4 border days_box">
                                    <p wire:click="setPayRateType('Standard hourly pay rate:', null)" 
                                       class="col text-center cursor-pointer border-end py-2 text-[14px] {{ $selected_value === null ? 'v_active' : '' }}">
                                        Hourly
                                    </p>
                                    <p wire:click="setPayRateType('Standard daily pay:', 8)" 
                                       class="col text-center cursor-pointer border-end py-2 text-[14px] {{ $selected_value == 8 ? 'v_active' : '' }}">
                                        Daily
                                    </p>
                                    <p wire:click="setPayRateType('Standard weekly pay:', 40)" 
                                       class="col text-center cursor-pointer border-end py-2 text-[14px] {{ $selected_value == 40 ? 'v_active' : '' }}">
                                        Weekly
                                    </p>
                                    <p wire:click="setPayRateType('Standard monthly salary:', 160)" 
                                       class="col text-center cursor-pointer border-end py-2 text-[14px] {{ $selected_value == 160 ? 'v_active' : '' }}">
                                        Monthly
                                    </p>
                                    <p wire:click="setPayRateType('Standard annual salary:', 2080)" 
                                       class="col text-center cursor-pointer border-end py-2 text-[14px] {{ $selected_value == 2080 ? 'v_active' : '' }}">
                                        Annual
                                    </p>
                                </div>
                            </div>
                            <div class="col-span-2 hidden md:block lg:block"></div>
                        </div>
                    </div>
                    
                    <div class="col-span-12">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4 mx-auto">
                            <div class="col-span-12 md:col-span-6 lg:col-span-6">
                                <div class="mb-1 relative">
                                    <label for="daily_rate" class="form-label">{{ $pay_rate_label }}</label>
                                    <input type="number" wire:model.live="daily_rate" id="daily_rate" class="input remove_shadow t_sec" placeholder="_ _">
                                    <span class="text-blue input_unit">{{ $selected_currency }}</span>
                                </div>
                            </div>
                            
                            @if($selected_value !== null)
                                <div class="col-span-12 md:col-span-6 lg:col-span-6">
                                    <div class="mb-1 relative">
                                        <label for="working_hour" class="form-label">{{ $lang['3'] ?? 'Standard working hours:' }}</label>
                                        <input type="number" wire:model.live="working_hour" id="working_hour" class="input remove_shadow t_sec" placeholder="_ _">
                                    </div>
                                </div>
                            @endif

                            <div class="col-span-12 md:col-span-6 lg:col-span-6">
                                <div class="mb-1 relative">
                                    <label for="normal_pay" class="form-label">{{ $lang['4'] ?? 'Overtime hours:' }}</label>
                                    <input type="number" wire:model.live="normal_pay" id="normal_pay" class="input remove_shadow t_sec" placeholder="{{ $lang['opt'] ?? 'optional' }}">
                                </div>
                            </div>
                            <div class="col-span-12 md:col-span-6 lg:col-span-6">
                                <div class="mb-1 relative">
                                    <label for="normal_time" class="form-label">{{ $lang['5'] ?? 'Regular hours:' }}</label>
                                    <input type="number" wire:model.live="normal_time" id="normal_time" class="input remove_shadow t_sec" placeholder="{{ $lang['opt'] ?? 'optional' }}">
                                </div>
                            </div>
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

        @if (isset($detail))
            <div id="result-section" wire:loading.remove wire:target="calculate" class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="w-full mx-auto rounded-3xl">
                        <div class="w-full mx-auto">
                            <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                                <div class="col-span-12 mt-5">
                                    <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                                        <div class="col-span-12 md:col-span-6 lg:col-span-6 text-center md:border-r lg:border-r">
                                            <p class="mb-0 mx-2">{{ $lang['7'] ?? 'Time and an Half Pay Rate:' }}</p>
                                            <p class="mb-1 mx-2 text-[30px] text-[#49987d] font-bold">{{ $selected_currency }} {{ number_format($detail['time_and_half'], 2) }}</p>
                                        </div>
                                        <div class="col-span-12 md:col-span-6 lg:col-span-6 text-center md:border-r lg:border-r">
                                            <p class="mb-0 mx-2">{{ $lang['6'] ?? 'Standard Hourly Pay Rate:' }}</p>
                                            <p class="mb-1 mx-2 text-[30px] text-[#49987d] font-bold">{{ $selected_currency }} {{ number_format($detail['standard_hour_rate'], 2) }}</p>
                                        </div>
                                        @if (!empty($normal_pay))
                                            <div class="col-span-12 md:col-span-6 lg:col-span-6 text-center md:border-r lg:border-r">
                                                <p class="mb-0 mx-2">{{ $lang['8'] ?? 'Time and a Half Pay:' }}</p>
                                                <p class="mb-1 mx-2 text-[30px] text-[#49987d] font-bold">{{ $selected_currency }} {{ number_format($detail['Time_and_half_pay'], 2) }}</p>
                                            </div>
                                        @endif
                                        @if (!empty($normal_time))
                                            <div class="col-span-12 md:col-span-6 lg:col-span-6 text-center md:border-r lg:border-r">
                                                <p class="mb-0 mx-2">{{ $lang['9'] ?? 'Standard Pay:' }}</p>
                                                <p class="mb-1 mx-2 text-[30px] text-[#49987d] font-bold">{{ $selected_currency }} {{ number_format($detail['Standard_pay'], 2) }}</p>
                                            </div>
                                        @endif
                                        @if (!empty($normal_time) && !empty($normal_pay))
                                            <div class="col-span-12 md:col-span-6 lg:col-span-6 text-center md:border-r lg:border-r">
                                                <p class="mb-0 mx-2">{{ $lang['10'] ?? 'Total Pay:' }}</p>
                                                <p class="mb-1 mx-2 text-[30px] text-[#49987d] font-bold">{{ $selected_currency }} {{ number_format($detail['Standard_pay'] + $detail['Time_and_half_pay'], 2) }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>

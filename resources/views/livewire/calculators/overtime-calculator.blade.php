<div x-data="{
    conversionFactors: {
        'week': 4.344,
        'month': 1,
        'year': 12,
    },
    unit: 'month',
    initialValue: {{ $detail['total'] ?? 0 }},
    get convertedValue() {
        const factor = this.conversionFactors[this.unit];
        if (this.unit === 'year') {
            return (this.initialValue * factor).toFixed(4);
        } else {
            return (this.initialValue / factor).toFixed(4);
        }
    }
}">
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="lg:w-[100%] md:w-[100%] w-full mx-auto">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-12 flex justify-center">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                            <!-- Pay Rate Label -->
                            <div class="col-span-12 md:col-span-6 lg:col-span-2 flex p-0 items-center lg:justify-end">
                                <div class="fw-semibold pt-1 px-3 px-lg-0 text-lg-center text-start no-wrap">
                                    {{ $lang['15'] ?? 'Pay Rate' }}
                                </div>
                            </div>
                            <!-- Base Pay Input -->
                            <div class="col-span-6 md:col-span-2 lg:col-span-2">
                                <div class="mb-1 relative">
                                    <label for="pay" class="label" id="changeText">{{ $lang['1'] ?? 'Base Pay' }}</label>
                                    <input type="number" wire:model="pay" id="pay" class="input remove_shadow t_sec" placeholder="">
                                    <span class="text-blue input_unit whitespace-nowrap">{{ $currencySymbol }}</span>
                                </div>
                            </div>
                            <!-- Pay Period Select -->
                            <div class="col-span-6 md:col-span-2 lg:col-span-2">
                                <div class="mb-1">
                                    <label for="per" class="label box-shadow-0">{{ $lang['2'] ?? 'per' }}</label>
                                    <select wire:model="per" id="per" class="input remove_shadow" aria-label="Default select example">
                                        <option value="hour">{{ $lang['7'] ?? 'hour' }}</option>
                                        <option value="day">{{ $lang['8'] ?? 'day' }}</option>
                                        <option value="week">{{ $lang['17'] ?? 'week' }}</option>
                                        <option value="month">{{ $lang['18'] ?? 'month' }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Work Time Amount -->
                            <div class="col-span-6 md:col-span-2 lg:col-span-2">
                                <div class="mb-1">
                                    <label for="time" class="label" id="changeText">{{ $lang['33'] ?? 'Regular Hours' }}</label>
                                    <input type="number" step="any" wire:model="time" id="time" class="input remove_shadow t_sec" placeholder="">
                                </div>
                            </div>
                            <!-- Work Time Period -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1">
                                    <label for="timeper" class="label box-shadow-0">&nbsp;</label>
                                    <select wire:model="timeper" id="timeper" class="input remove_shadow" aria-label="Default select example">
                                        <option value="h_m">{{ $lang['19'] ?? 'Hours' }}/{{ $lang['25'] ?? 'Month' }}</option>
                                        <option value="d_m">{{ $lang['20'] ?? 'Days' }}/{{ $lang['25'] ?? 'Month' }}</option>
                                        <option value="w_m">{{ $lang['21'] ?? 'Weeks' }}/{{ $lang['25'] ?? 'Month' }}</option>
                                        <option value="h_w">{{ $lang['22'] ?? 'Hours' }}/{{ $lang['26'] ?? 'Week' }}</option>
                                        <option value="d_w">{{ $lang['23'] ?? 'Days' }}/{{ $lang['26'] ?? 'Week' }}</option>
                                        <option value="h_d">{{ $lang['24'] ?? 'Hours' }}/{{ $lang['27'] ?? 'Day' }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 flex justify-center mt-4">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                            <!-- Overtime Section Label -->
                            <div class="col-span-12 md:col-span-2 lg:col-span-2 p-0 flex items-center lg:justify-end">
                                <div class="fw-semibold pt-1 px-3 px-lg-0 text-start">
                                    {{ $lang['16'] ?? 'Overtime' }}
                                </div>
                            </div>
                            <!-- Overtime Type -->
                            <div class="col-span-6 md:col-span-4 lg:col-span-4">
                                <div class="mb-1">
                                    <label for="overtime" class="label box-shadow-0">{{ $lang['4'] ?? 'Overtime Rate' }}</label>
                                    <select wire:model.live="overtime" id="overtime" class="input remove_shadow" aria-label="Default select example">
                                        <option value="half">Time and a Half</option>
                                        <option value="double">Double Time</option>
                                        <option value="triple">Triple Time</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Multiplier -->
                            <div class="col-span-6 md:col-span-2 lg:col-span-2">
                                <div class="mb-1">
                                    <label for="multi" class="label" id="changeText">&nbsp;</label>
                                    <input type="number" step="any" wire:model="multi" id="multi" class="input remove_shadow t_sec" placeholder="" {{ $overtime !== 'other' ? 'readonly' : '' }}>
                                </div>
                            </div>
                            <!-- Overtime hours -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 relative">
                                    <label for="over" class="label" id="changeText">{{ $lang['5'] ?? 'Overtime Hours' }}</label>
                                    <input type="number" step="any" wire:model="over" id="over" class="input remove_shadow t_sec" placeholder="">
                                    <span class="text-blue input_unit whitespace-nowrap">{{ $lang['6'] ?? 'hrs' }}</span>
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
                                <div class="col-span-12 mt-5">
                                    <table class="w-full text-[18px]">
                                        <tbody>
                                            <tr>
                                                <td class="py-2 border-b text-[#49987d]" width="50%">
                                                    <strong>{{ $lang['28'] ?? 'Overtime Pay per Hour' }}</strong>
                                                </td>
                                                <td class="py-2 border-b text-dark">
                                                    {{ $currencySymbol }}{{ $detail['overPayPerHour'] ?? '0.00' }} {{ $lang['29'] ?? 'per hour' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 border-b text-[#49987d]" width="50%">
                                                    <strong>{{ $lang['30'] ?? 'Total Overtime Pay' }}</strong>
                                                </td>
                                                <td class="py-2 border-b text-dark">
                                                    {{ $currencySymbol }}{{ $detail['overTotalPay'] ?? '0.00' }} {{ $lang['31'] ?? 'per month' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 border-b text-[#49987d]" width="50%">
                                                    <strong>{{ $lang['36'] ?? 'Regular Pay' }}</strong>
                                                </td>
                                                <td class="py-2 border-b text-dark">
                                                    {{ $currencySymbol }}{{ $detail['regPay'] ?? '0.00' }} {{ $lang['31'] ?? 'per month' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 border-b text-[#49987d]" width="50%">
                                                    <strong>{{ $lang['32'] ?? 'Total Pay' }} ({{ $lang['33'] ?? 'Regular' }} + {{ $lang['34'] ?? 'Overtime' }})</strong>
                                                </td>
                                                <td class="py-2 border-b text-dark">
                                                    {{ $currencySymbol }}<span x-text="convertedValue"></span>
                                                    {{ $lang['35'] ?? 'per' }}
                                                    <select x-model="unit" class="d-inline droup_btn" style="width: 120px">
                                                        <option value="week">{{ $lang['37'] ?? 'week' }}</option>
                                                        <option value="month" selected>{{ $lang['38'] ?? 'month' }}</option>
                                                        <option value="year">{{ $lang['39'] ?? 'year' }}</option>
                                                    </select>
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
        @endisset
    </form>
</div>

<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="lg:w-[70%] md:w-[80%] w-full mx-auto ">
                <div class="grid grid-cols-12  gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-12 text-center">
                        <p class="text-lg italic">
                            \[\Delta t' = \frac{\Delta t}{\sqrt{1 - \frac{v^2}{c^2}}}\]
                        </p>
                    </div>

                    <div class="col-span-12 md:col-span-2 lg:col-span-2 flex items-center">
                        <div class="fw-semibold px-3 text-start no-wrap flex items-center">
                            {{ $lang['11'] ?? 'Time Interval' }}:
                        </div>
                    </div>

                    <div class="{{ in_array($interval_unit, ['mins/sec', 'hrs/mins', 'yrs/mos', 'wks/days']) ? 'col-span-4 md:col-span-3' : 'col-span-8 md:col-span-6' }}">
                        <div class="mb-1 relative">
                            <label class="form-label" id="changeText">{{ explode('/', $interval_unit)[0] ?? $interval_unit }}</label>
                            <input type="number" wire:model.live="interval" step="any" class="input remove_shadow t_sec" placeholder="00">
                        </div>
                    </div>

                    @if (in_array($interval_unit, ['mins/sec', 'hrs/mins', 'yrs/mos', 'wks/days']))
                        <div class="col-span-4 md:col-span-3 lg:col-span-3">
                            <div class="mb-1 relative">
                                <label class="form-label" id="changeText">{{ explode('/', $interval_unit)[1] ?? '' }}</label>
                                <input type="number" wire:model.live="interval_sec" step="any" class="input remove_shadow t_sec" placeholder="00">
                            </div>
                        </div>
                    @endif

                    <div class="col-span-4 md:col-span-2 lg:col-span-2">
                        <div class="mb-1 relative">
                            <label class="form-label">&nbsp;</label>
                            <select class="input remove_shadow t_sec" wire:model.live="interval_unit">
                                <option value="sec">sec</option>
                                <option value="mins">mins</option>
                                <option value="hrs">hrs</option>
                                <option value="days">days</option>
                                <option value="wks">wks</option>
                                <option value="mos">mos</option>
                                <option value="yrs">yrs</option>
                                <option value="mins/sec">mins/sec</option>
                                <option value="hrs/mins">hrs/mins</option>
                                <option value="yrs/mos">yrs/mos</option>
                                <option value="wks/days">wks/days</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-2 lg:col-span-2 flex items-center">
                        <div class="fw-semibold px-3 text-start no-wrap flex items-center">
                            {{ $lang['10'] ?? 'Observer Velocity' }}:
                        </div>
                    </div>

                    <div class="col-span-6 md:col-span-5 lg:col-span-5">
                        <div class="mb-1 relative">
                            <label class="form-label" id="changeText">{{ $lang['10'] ?? 'Velocity' }}</label>
                            <input type="number" wire:model.live="velocity" step="any" class="input remove_shadow t_sec" placeholder="0.8">
                        </div>
                    </div>

                    <div class="col-span-6 md:col-span-5 lg:col-span-5">
                        <div class="mb-1 relative">
                            <label class="form-label">Unit</label>
                            <select class="input remove_shadow t_sec" wire:model.live="velocity_unit">
                                <option value="m/s">m/s</option>
                                <option value="km/s">km/s</option>
                                <option value="mi/s">mi/s</option>
                                <option value="c">c (light speed)</option>
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

        @if ($detail)
            <div id="result-section" wire:loading.remove wire:target="calculate"
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif

                    <div class="w-full mx-auto   rounded-3xl">
                        <div class=" w-full mx-auto ">
                            <div class="grid grid-cols-12  gap-2 md:gap-4 lg:gap-4">
                                <div class="col-span-12">
                                    <div class="flex justify-center">
                                        <div class="grid grid-cols-12  gap-2 md:gap-4 lg:gap-4 my-5 text-[20px]">
                                            <div class="flex items-center col-span-12 md:border-r px-4 lg:border-r">
                                                <img src="{{ asset('icons/r_sec.png') }}" width="30" height="22" alt="Seconds">
                                                <span class="text-[#49987d] mx-2">{{ $lang['8'] ?? "Relative Time" }}</span>
                                                <span class="fs-2 text-dark">{{ round($detail['answer'], 4) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-[16px] text-[#49987d] text-center">{{ $lang['9'] ?? "Relative Time In Other Units" }}</p>

                                    <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4 my-5">
                                        @php
                                            $units = [
                                                ['key' => '2', 'label' => 'Minutes', 'divisor' => 60, 'icon' => 'r_mint.png'],
                                                ['key' => '3', 'label' => 'Hours', 'divisor' => 3600, 'icon' => 'r_hour.png'],
                                                ['key' => '4', 'label' => 'Days', 'divisor' => 86400, 'icon' => 'r_days.png'],
                                                ['key' => '5', 'label' => 'Weeks', 'divisor' => 604800, 'icon' => 'r_days.png'],
                                                ['key' => '6', 'label' => 'Months', 'divisor' => 2629800, 'icon' => 'r_days.png'],
                                                ['key' => '7', 'label' => 'Years', 'divisor' => 31557600, 'icon' => 'r_days.png'],
                                            ];
                                        @endphp

                                        @foreach ($units as $u)
                                            <div class="col-span-12 md:col-span-4 lg:col-span-4 flex items-center px-4">
                                                <img src="{{ asset('icons/' . $u['icon']) }}" width="25" height="22" class="mr-2">
                                                <span class="text-[#49987d] text-[16px] mx-2">{{ $lang[$u['key']] ?? $u['label'] }}</span>
                                                <span class="fs-2 text-dark">{{ round($detail['answer'] / $u['divisor'], 4) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="mt-4 text-center">
                                        <p class="text-gray-600">Lorentz Factor: <strong>{{ round($detail['lorentz_factor'], 6) }}</strong></p>
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


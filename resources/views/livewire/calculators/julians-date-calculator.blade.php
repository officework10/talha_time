<div>

    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[60%] md:w-[60%] w-full mx-auto ">
                <div>
                <div class="md:flex lg:flex mb-3 justify-content-center pt-1 col-10 mx-auto">
                    <p>
                        <input type="radio" name="timecheck" id="stat" wire:model="timecheck"
                            wire:click="changeOperation('stat')" class="cursor-pointer" value="stat">
                        <label for="stat"
                            class="font-s-14 cursor-pointer text-blue pe-lg-3 pe-2">{{ $lang['1'] }}</label>
                        @if ($device == 'mobile')
                            <br>
                        @endif
                    </p>
                    <p>
                        <input type="radio" name="timecheck" id="dyna" wire:model="timecheck"
                            wire:click="changeOperation('dyna')" class="cursor-pointer pt-2" value="dyna">
                        <label for="dyna" class="font-s-14 cursor-pointer text-blue">{{ $lang['2'] }}</label>
                    </p>
                </div>

                <div class="grid grid-cols-1   mt-3 gap-4 timeclock {{ $timecheck != 'stat' ? 'hidden' : '' }}  ">
                    <div class="col-span-12 lg:w-[70%] md:w-[70%]">
                        <div class="grid grid-cols-12 w-full  gap-4  ">
                            <div class="col-span-4 relative">
                                <label for="month" class="label">{{ $lang['3'] }}</label>
                                <select wire:model="month" class="input">
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}">
                                            {{ Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-4 relative">
                                <label for="day" class="label">{{ $lang['4'] }}</label>
                                <select wire:model="day" class="input">
                                    @foreach (range(1, 31) as $d)
                                        <option value="{{ $d }}">{{ $d }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-4 relative">
                                <label for="year" class="label">{{ $lang['5'] }}</label>
                                <select wire:model="year" class="input">
                                    @foreach (range(1950, 2050) as $y)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="  col-span-12   lg:w-[70%] md:w-[70%]">
                        <div class="grid grid-cols-12 gap-4 ">
                            <div class="col-span-12 relative date-now">
                                <div class="flex justify-between">
                                    <label for="time" class="label">{{ $lang['6'] }}</label>
                                    <span
                                        class="font-s-14 text-end text-blue text-decoration-underline cursor-pointer now"
                                        wire:click="setNow">
                                        {{ isset($lang['now']) ? $lang['now'] : 'Now' }}
                                    </span>
                                </div>
                                <div class="w-100 ">
                                    <input type="time" name="time" wire:model="time" id="time" class="input"
                                        aria-label="input" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="grid grid-cols-1   gap-4 dateclock {{ $timecheck != 'stat' ? '' : 'hidden' }}">
                      <div class="  col-span-6   lg:w-[70%] md:w-[70%]">
                        <div class=" relative mt-3">
                            <label for="julian" class="label">{{ $lang['7'] }}</label>
                            <input type="text" name="julian" id="julian" class="input px-3"
                                placeholder="e.g: 2458759.500000" wire:model="julian" aria-label="input"
                                autocomplete="off" />
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
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif   
                    <div class="rounded-lg  flex items-center justify-center">
                        <div class="w-full bg-light-blue result p-3 radius-10 mt-3 overflow-auto">
                            <div class="w-full md:w-[40%] lg:w-[40%] mx-auto p-1 mb-2">
                                <div class="border radius-5 bg-gray-100 p-2 text-center">
                                    @if ($detail['timecheck'] == 'dyna')
                                        <p class="pb-1 text-[20px]">📅 Calendar Date</p>
                                        <p class="text-[25px]"><strong class="text-blue">{{ $detail['jul_date'] }}</strong>
                                        </p>
                                    @else
                                        <p class="pb-1 text-[20px]">📅 Julian Date</p>
                                        <p class="text-[25px]"><strong class="text-blue">{{ $detail['julianDate'] }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset

    </form>
</div>

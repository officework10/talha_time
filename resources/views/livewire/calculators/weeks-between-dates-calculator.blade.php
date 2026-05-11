<div>

    <form wire:submit.prevent="calculate">

        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[50%] md:w-[80%] w-full mx-auto">
                <div class="grid grid-cols-12 mt-3 gap-2 md:gap-4 lg:gap-4">
                    <!-- {{-- First Date --}} -->
                    <div class="col-span-12 gap-2 md:gap-4 lg:gap-4">
                         <div class="grid grid-cols-12 mt-3 gap-2 md:gap-4 lg:gap-4">
                        <div class="col-span-5">
                            <label class="label">From Month</label>
                            <select wire:model="month" class="input">
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}">
                                        {{ Carbon\Carbon::create()->month($m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-3">
                            <label class="label">&nbsp;</label>
                            <select wire:model="day" class="input">
                                @foreach (range(1, 31) as $d)
                                    <option value="{{ $d }}">{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-4">
                            <label class="label">&nbsp;</label>
                            <select wire:model="year" class="input">
                                @foreach (range(1950, 2050) as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                    </div>

                    <!-- {{-- Second Date --}} -->
                    <div class="col-span-12 gap-2 md:gap-4 lg:gap-4">
                           <div class="grid grid-cols-12 mt-3 gap-2 md:gap-4 lg:gap-4">
                            <div class="col-span-5">
                                <label class="label">To Month</label>
                                <select wire:model="month1" class="input">
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}">
                                            {{ Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-3">
                                <label class="label">&nbsp;</label>
                                <select wire:model="day1" class="input">
                                    @foreach (range(1, 31) as $d)
                                        <option value="{{ $d }}">{{ $d }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-4">
                                <label class="label">&nbsp;</label>
                                <select wire:model="year1" class="input">
                                    @foreach (range(1950, 2050) as $y)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
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
                class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg  flex items-center justify-center">
                        <div class="w-full overflow-auto">
                            @php
                                $days = $detail['days'];
                                $weeks = $detail['weeks'];
                                $date1 = $detail['date1'];
                                $date2 = $detail['date2'];
                            @endphp
                            <div class="w-full">
                                <div class="w-full md:w-[60%] lg:w-[60%]  p-1 mx-auto text-center">
                                    <div class="border  rounded-lg bg-[#F6FAFC] p-2 mt-3"
                                        style="border: 1px solid #c1b8b899;">
                                        <p>📅 Weeks Between Dates</p>
                                        <p class="text-[25px]"><strong
                                                class="text-blue">{{ (int)$weeks > 0 ? $weeks . ' ' . Str::plural('Week', (int)$weeks) : '' }}
                                                {{ (int)$days > 0 ? $days . ' ' . Str::plural('Day', (int)$days) : '' }}</strong>
                                        </p>

                                        @if ($days == 0)
                                            <p class="text-[18px]"><strong class="text-blue">0 Weeks</strong></p>
                                        @endif
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

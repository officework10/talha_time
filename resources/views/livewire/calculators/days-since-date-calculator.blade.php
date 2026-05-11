<div>

    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[50%] md:w-[80%] w-full mx-auto ">
                <div class="grid grid-cols-1   gap-4">


                    <div class="grid grid-cols-12  gap-4">
                        <div class="col-span-4 ">
                            <label for="month" class="label">{{ $lang['1'] }}</label>
                            <div class="w-100 py-2">
                                <select wire:model="month" class="input">
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}">
                                            {{ Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-span-4">
                            <label for="day" class="label">&nbsp;</label>
                            <div class="w-100 py-2">
                                <select wire:model="day" class="input">
                                    @foreach (range(1, 31) as $d)
                                        <option value="{{ $d }}">{{ $d }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-span-4">
                            <label for="year" class="label">&nbsp;</label>
                            <div class="w-100 py-2">
                                <select wire:model="year" class="input">
                                    @foreach (range(1950, 2050) as $y)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-12  gap-4">
                        <div class="col-span-4 ">
                            <label for="month1" class="label">{{ $lang['2'] }}</label>
                            <div class="w-100 py-2">
                                <select wire:model="month1" class="input">
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}">
                                            {{ Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-span-4">
                            <label for="day1" class="label">&nbsp;</label>
                            <div class="w-100 py-2">
                                <select wire:model="day1" class="input">
                                    @foreach (range(1, 31) as $d)
                                        <option value="{{ $d }}">{{ $d }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-span-4">
                            <label for="year1" class="label">&nbsp;</label>
                            <div class="w-100 py-2">
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
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg  flex items-center justify-center">

                        <div class="w-full bg-light-blue result p-3 radius-10 mt-3 overflow-auto">
                            @php
                                $holidays = $detail['holidays'];
                                $totaldays = $detail['totaldays'];
                                $workingDays = $detail['workingDays'];
                            @endphp
                            <p class="mb-2 text-center">Days Since the Start Date</p>
                            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2   gap-4">
                                <div class="space-y-2">
                                    <div class="border radius-10 bg-sky p-2">
                                        <p>📅 Total Days</p>
                                        <p class="font-s-25"><strong
                                                class="text-blue">{{ $totaldays > 0 ? $totaldays . ' Day' . ($totaldays == 1 ? '' : 's') : '' }}
                                            </strong></p>
                                        @if ($totaldays == 0)
                                            <p class="font-s-18"><strong class="text-blue">0 Days</strong></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="border radius-10 bg-sky p-2">
                                        <p>📅 Business Days</p>
                                        <p class="font-s-25"><strong
                                                class="text-blue">{{ $workingDays > 0 ? $workingDays . ' Day' . ($workingDays == 1 ? '' : 's') : '' }}
                                            </strong></p>
                                        @if ($workingDays == 0)
                                            <p class="font-s-18"><strong class="text-blue">0 Days</strong></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="border radius-10 bg-sky p-2">
                                        <p>📅 Weekend Days</p>
                                        <p class="font-s-25"><strong
                                                class="text-blue">{{ $holidays > 0 ? $holidays . ' Day' . ($holidays == 1 ? '' : 's') : '' }}
                                            </strong></p>
                                        @if ($holidays == 0)
                                            <p class="font-s-18"><strong class="text-blue">0 Days</strong></p>
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

<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
           
            <div class="lg:w-[50%] md:w-[50%] w-full mx-auto">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-12 md:col-span-6 lg:col-span-6">
                        <label for="decimal" class="label">{{ $lang['decimal'] ?? 'Decimal' }}:</label>
                        <div class="w-full">
                            <input type="number" step="any" wire:model="decimal" id="decimal"
                                class="input form-control rounded-pill remove_shadow d" aria-label="input"
                                placeholder="42.756" />
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 lg:col-span-6">
                        <label for="startEvent" class="label">{{ $lang['unit'] ?? 'Unit' }}:</label>
                        <div class="w-full">
                            <select wire:model="startEvent" id="startEvent"
                                class="input form-control rounded-pill remove_shadow">
                                <option value="days">Days</option>
                                <option value="hours">Hours</option>
                                <option value="minutes">Minutes</option>
                                <option value="seconds">Seconds</option>
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

                <div class="w-full mx-auto rounded-3xl">
                    <div class="w-full mx-auto">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                            <div class="col-span-12">
                                <div class="lg:w-[80%] md:w-[80%] w-full mx-auto">
                                    <div class="grid grid-cols-12 gap-4 my-10">
                                        <div class="col-span-12 md:col-span-3 lg:col-span-3 flex items-center px-md-4 md:border-r lg:border-r">
                                            <img src="{{ asset('icons/r_days.png') }}" width="25px" height="22px" alt="days">
                                            <span class="text-[#49987d] text-[25px] mx-2">{{ $lang['days'] ?? 'Days' }}</span>
                                            <span class="fs-2 text-[25px]">{{ isset($detail['days']) ? round($detail['days'], 2) : 0 }}</span>
                                        </div>
                                        <div class="col-span-12 md:col-span-3 lg:col-span-3 flex items-center px-md-4 md:border-r lg:border-r">
                                            <img src="{{ asset('icons/r_hour.png') }}" width="25px" height="22px" alt="hours">
                                            <span class="text-[#49987d] text-[25px] mx-2">{{ $lang['hours'] ?? 'Hours' }}</span>
                                            <span class="fs-2 text-[25px]">{{ isset($detail['hours']) ? round($detail['hours'], 2) : 0 }}</span>
                                        </div>
                                        <div class="col-span-12 md:col-span-3 lg:col-span-3 flex items-center px-md-4 md:border-r lg:border-r">
                                            <img src="{{ asset('icons/r_mint.png') }}" width="25px" height="22px" alt="minutes">
                                            <span class="text-[#49987d] text-[25px] mx-2">{{ $lang['minutes'] ?? 'Minutes' }}</span>
                                            <span class="fs-2 text-[25px]">{{ isset($detail['mins']) ? round($detail['mins'], 2) : 0 }}</span>
                                        </div>
                                        <div class="col-span-12 md:col-span-3 lg:col-span-3 flex items-center px-md-4">
                                            <img src="{{ asset('icons/r_sec.png') }}" width="25px" height="22px" alt="seconds">
                                            <span class="text-[#49987d] text-[25px] mx-2">{{ $lang['seconds'] ?? 'Seconds' }}</span>
                                            <span class="fs-2 text-[25px]">{{ isset($detail['secs']) ? round($detail['secs'], 2) : 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="h5 text-[#49987d] text-[16px]">{{ $lang['5'] ?? 'Result' }}</p>
                                <div class="text-[16px] overflow-auto">
                                    <!-- Display Time -->
                                    <p>Converted Time (in Days:Hours:Minutes:Seconds):
                                        <strong>{{ $detail['days'] }} days, {{ $detail['hours'] }} hours, {{ $detail['mins'] }} minutes, {{ $detail['secs'] }} seconds</strong>
                                    </p>
                                    
                                    <!-- Explanation for Days -->
                                    <p class="text-[#49987d] text-[16px]"><strong>Step 1: Calculate Days</strong></p>
                                    <p>
                                        @if ($detail['unit'] == 'days')
                                            The total days is {{ $detail['days'] }} days.
                                        @elseif ($detail['unit'] == 'hours')
                                            The total day equivalent of {{ $detail['decimal'] }} hours is calculated as follows:
                                            <br>
                                            \[
                                            \text{Days} = \frac{{ $detail['decimal'] }}{24} = {{ $detail['days'] }} \, \text{days}
                                            \]
                                        @elseif ($detail['unit'] == 'minutes')
                                            The total day equivalent of {{ $detail['decimal'] }} minutes is calculated as follows:
                                            <br>
                                            \[
                                            \text{Days} = \frac{{ $detail['decimal'] }}{1440} = {{ $detail['days'] }} \, \text{days} \, \text{(since there are 1440 minutes in a day)}
                                            \]
                                        @elseif ($detail['unit'] == 'seconds')
                                            The total day equivalent of {{ $detail['decimal'] }} seconds is calculated as follows:
                                            <br>
                                            \[
                                            \text{Days} = \frac{{ $detail['decimal'] }}{86400} = {{ $detail['days'] }} \, \text{days} \, \text{(since there are 86400 seconds in a day)}
                                            \]
                                        @endif
                                    </p>
                                    
                                    <!-- Explanation for Remaining Hours -->
                                    <p class="text-[#49987d] text-[16px]"><strong>Step 2: Calculate Remaining Hours</strong></p>
                                    <p>
                                        <br>
                                        @if ($detail['unit'] == 'days')
                                            The hours of {{ $detail['decimal'] }} days is {{ $detail['hours'] }} hours.
                                            It calculates in that way:
                                            <br>
                                            \[
                                            \text{Hours} = {{ $detail['decimal'] }} \times 24 = {{ $detail['decimal'] * 24 }} \text{ hours}
                                            \]
                                            <br>
                                            \[
                                            \text{Remaining Hours} = {{ $detail['decimal'] }} \mod 24 = {{ $detail['decimal'] % 24 }} \text{ hours}
                                            \]
                                            <br>
                                            The integer part is:
                                            \[
                                            \text{Hours} = \left\lfloor {{ $detail['hours'] }} \right\rfloor = {{ $detail['hours'] }} \, \text{hours}
                                            \]
                                        @elseif ($detail['unit'] == 'hours')
                                            The hours of {{ $detail['decimal'] }} hours is {{ $detail['hours'] }} hours.
                                            It calculates in that way:
                                            <br>
                                            \[
                                            \text{Remaining Hours} = {{ $detail['decimal'] }} \mod 24 = {{ $detail['decimal'] % 24 }} \text{ hours}
                                            \]
                                            <br>
                                            The integer part is:
                                            \[
                                            \text{Hours} = \left\lfloor {{ $detail['hours'] }} \right\rfloor = {{ $detail['hours'] }} \, \text{hours}
                                            \]
                                        @elseif ($detail['unit'] == 'minutes')
                                            The hours of {{ $detail['decimal'] }} minutes is {{ $detail['hours'] }} hours.
                                            It calculates in that way:
                                            <br>
                                            \[
                                            \text{Remaining Hours} = \left( \frac{{ $detail['decimal'] }}{60} \right) \mod 24 = {{ ($detail['decimal'] / 60) % 24 }} \text{ hours}
                                            \]
                                            <br>
                                            The integer part is:
                                            \[
                                            \text{Hours} = \left\lfloor {{ $detail['hours'] }} \right\rfloor = {{ $detail['hours'] }} \, \text{hours}
                                            \]
                                        @elseif ($detail['unit'] == 'seconds')
                                            The hours of {{ $detail['decimal'] }} seconds is {{ $detail['hours'] }} hours.
                                            It calculates in that way:
                                            <br>
                                            \[
                                            \text{Remaining Hours} = \left( \frac{{ $detail['decimal'] }}{3600} \right) \mod 24 = {{ ($detail['decimal'] / 3600) % 24 }} \text{ hours}
                                            \]
                                            <br>
                                            The integer part is:
                                            \[
                                            \text{Hours} = \left\lfloor {{ $detail['hours'] }} \right\rfloor = {{ $detail['hours'] }} \, \text{hours}
                                            \]
                                        @endif
                                    </p>

                                    <!-- Explanation for Minutes -->
                                    <p class="text-[#49987d] text-[16px]"><strong>Step 3: Calculate Minutes</strong></p>
                                    <p>
                                        We calculate the minutes from the fractional part of the remaining hours:
                                        <br>
                                        @if ($detail['unit'] == 'days')
                                            We start with the remaining minutes calculated from {{ $detail['decimal'] }} days.
                                            <br>
                                            The formula for calculating the minutes is:
                                            <br>
                                            \[
                                            \text{Minutes} = \left( \left( {{ $detail['decimal'] }} \mod 24 \right) \times 60 \right) \mod 60 = {{ $detail['mins'] }} \, \text{minutes}
                                            \]
                                        @elseif ($detail['unit'] == 'hours')
                                            We start with the remaining hours calculated from {{ $detail['decimal'] }} hours.
                                            <br>
                                            The remaining fractional part of hours is \(\left( {{ $detail['decimal'] }} \mod 24 \right)\):
                                            <br>
                                            \[
                                            \text{Minutes} = \left( \left( {{ $detail['decimal'] }} \mod 24 \right) - \left\lfloor {{ $detail['decimal'] }} \mod 24 \right\rfloor \right) \times 60 = {{ $detail['mins'] }} \, \text{minutes}
                                            \]
                                        @elseif ($detail['unit'] == 'minutes')
                                            We start with the remaining hours calculated from {{ $detail['decimal'] }} minutes.
                                            <br>
                                            The total hours from minutes is \(\left( \frac{{ $detail['decimal'] }}{60} \right)\):
                                            <br>
                                            \[
                                            \text{Minutes} = \left( \left( \frac{{ $detail['decimal'] }}{60} \right) - \left\lfloor \frac{{ $detail['decimal'] }}{60} \right\rfloor \right) \times 60 = {{ $detail['mins'] }} \, \text{minutes}
                                            \]
                                        @elseif ($detail['unit'] == 'seconds')
                                            We start with the remaining hours calculated from {{ $detail['decimal'] }} seconds.
                                            <br>
                                            The total hours from seconds is \(\left( \frac{{ $detail['decimal'] }}{3600} \right)\):
                                            <br>
                                            \[
                                            \text{Minutes} = \left( \left( \frac{{ $detail['decimal'] }}{3600} \right) - \left\lfloor \frac{{ $detail['decimal'] }}{3600} \right\rfloor \right) \times 60 = {{ $detail['mins'] }} \, \text{minutes}
                                            \]
                                        @endif

                                        The integer part is:
                                        <br>
                                        \[
                                        \text{Minutes} = \left\lfloor {{ $detail['mins'] }} \right\rfloor = {{ $detail['mins'] }} \, \text{minutes}
                                        \]
                                    </p>

                                    <p class="text-[#49987d] text-[16px]"><strong>Step 4: Calculate Seconds</strong></p>
                                    <p>
                                        Finally, we calculate the remaining seconds from the fractional part of the minutes:
                                        <br>
                                        @if ($detail['unit'] == 'days')
                                            We start with the remaining minutes calculated from {{ $detail['decimal'] }} days.
                                            <br>
                                            The remaining fractional part of minutes is used to find seconds:
                                            <br>
                                            \[
                                            \text{Seconds} = \left( \text{Fractional Minutes} \right) \times 60 = {{ $detail['secs'] }} \, \text{seconds}
                                            \]
                                        @elseif ($detail['unit'] == 'hours')
                                            We start with the remaining minutes calculated from {{ $detail['decimal'] }} hours.
                                            <br>
                                            The remaining fractional part of minutes is used to find seconds:
                                            <br>
                                            \[
                                            \text{Seconds} = \left( \text{Fractional Minutes} \right) \times 60 = {{ $detail['secs'] }} \, \text{seconds}
                                            \]
                                        @elseif ($detail['unit'] == 'minutes')
                                            We start with the remaining seconds calculated from {{ $detail['decimal'] }} minutes.
                                            <br>
                                            The remaining fractional part of seconds is:
                                            <br>
                                            \[
                                            \text{Seconds} = {{ $detail['decimal'] }} \mod 60 = {{ $detail['secs'] }} \, \text{seconds}
                                            \]
                                        @elseif ($detail['unit'] == 'seconds')
                                            We start with the remaining seconds calculated from {{ $detail['decimal'] }} seconds.
                                            <br>
                                            The remaining fractional part is:
                                            <br>
                                            \[
                                            \text{Seconds} = {{ $detail['decimal'] }} \mod 60 = {{ $detail['secs'] }} \, \text{seconds}
                                            \]
                                        @endif
                                       
                                        The integer part is:
                                        <br>
                                        \[
                                        \text{Seconds} = \left\lfloor {{ $detail['secs'] }} \right\rfloor = {{ $detail['secs'] }} \, \text{seconds}
                                        \]
                                    </p>

                                    <!-- Summary -->
                                    <p class="text-[#49987d] text-[16px]"><strong>Summary:</strong></p>
                                    <p>
                                        The total time is {{ $detail['days'] }} days, {{ $detail['hours'] }} hours, {{ $detail['mins'] }} minutes, and {{ $detail['secs'] }} seconds.
                                    </p>
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

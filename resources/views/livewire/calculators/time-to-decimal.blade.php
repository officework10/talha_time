
<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
                <div class="lg:w-[70%] md:w-[80%] w-full mx-auto ">
                    <div class="grid grid-cols-12  gap-2 md:gap-4 lg:gap-4">

                            <div class="col-span-12 md:col-span-2 lg:col-span-2 flex items-center">
                                <div  class="fw-semibold px-3   text-start no-wrap flex items-center">
                                    {{ $lang['10'] ?? 'Enter Time:' }}
                                </div>
                            </div>
                            <div class="col-span-4 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 relative">
                                    <label for="hh" class="form-label" id="changeText">{{ $lang['1'] ?? 'Hours' }}</label>
                                    <input type="number" wire:model="hh" id="hh" class="input remove_shadow t_sec"  placeholder="00" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-span-4 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 relative">
                                    <label for="mm" class="form-label" id="changeText">{{ $lang['2'] ?? 'Minutes' }}</label>
                                    <input type="number" wire:model="mm" id="mm" class="input remove_shadow t_sec"  placeholder="00" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-span-4 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 relative">
                                    <label for="ss" class="form-label" id="changeText">{{ $lang['3'] ?? 'Seconds' }}</label>
                                    <input type="number" wire:model="ss" id="ss" class="input remove_shadow t_sec"  placeholder="00" aria-describedby="emailHelp">
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

                                <div class="col-span-12  ">
                                    <div class="flex justify-center">
                                    <div class="grid grid-cols-12  gap-2 md:gap-4 lg:gap-4 my-5 text-[20px]">
                                            <div class="flex items-center col-span-12 md:col-span-4 lg:col-span-4 md:border-r px-4 lg:border-r">
                                                <img src="{{ asset('icons/r_hour.png') }}" width="30px" height="22px"
                                                    alt="hours">
                                                <span class="text-[#49987d] mx-2">{{ $lang['1'] ?? 'Hours' }}</span>
                                                <span class="fs-2 text-dark">{{ isset($detail['hours']) ? round($detail['hours'], 2) : 0 }}</span>
                                            </div>
                                            <div class="flex items-center col-span-12 md:col-span-4 lg:col-span-4 md:border-r px-4 lg:border-r">
                                                <img src="{{ asset('icons/r_mint.png') }}" width="30px" height="22px"
                                                    alt="minuts">
                                                <span class="text-[#49987d] mx-2">{{ $lang['2'] ?? 'Minutes' }}</span>
                                                <span class="fs-2 text-dark">{{ isset($detail['mins']) ? round($detail['mins'], 2) : 0 }}</span>
                                            </div>
                                            <div class="flex items-center col-span-12 md:col-span-4 lg:col-span-4  px-4">
                                                <img src="{{ asset('icons/r_sec.png') }}" width="30px" height="22px" alt="second">
                                                <span class="text-[#49987d] mx-2">{{ $lang['3'] ?? 'Seconds' }}</span>
                                                <span class="fs-2 text-dark">{{ isset($detail['secs']) ? round($detail['secs'], 2) : 0 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-[16px] text-[#49987d]">{{ $lang['5'] ?? 'Result' }}</p>
                                    <div class="text-[16px] overflow-auto">
                                        <p class="p-2">{{ $lang['9'] ?? 'Total Time:' }}
                                            <strong>{{ $detail['hour'] }}:{{ $detail['min'] }}:{{ $detail['sec'] }}</strong>
                                            ({{ $detail['hour'] }} {{ $lang['2'] ?? 'Hours' }} {{ $detail['min'] }} {{ $lang['3'] ?? 'Minutes' }} {{ $detail['sec'] }} {{ $lang['4'] ?? 'Seconds' }})
                                        </p>
                                        <p  class="text-[#49987d] p-2"><strong>{{ $lang['6'] ?? 'Total Hours' }}:</strong></p>
                                        <p class="p-2">\( {{ $detail['hour'] }} \, hr + {{ $detail['min'] }} \, min \times \frac{1 \, hr}{60
                                            \, min} + {{ $detail['sec'] }} \, s \times \frac{1 \, hr}{3600 \, s}\)</p>
                                        <p class="p-2">\( = {{ $detail['hour'] }} \, hr + {{ $detail['min'] / 60 }} \, hr +
                                            {{ $detail['sec'] / 3600 }} \, hr \)</p>
                                        <p class="p-2">\( = {{ $detail['hours'] }}\, hr \)</p>
                                        <p  class=" text-[#49987d] p-2"><strong>{{ $lang['7'] ?? 'Total Minutes' }}:</strong></p>
                                        <p class="p-2">\( {{ $detail['hour'] }} \, hr \times \frac{60 \, min}{1 \, hr} + {{ $detail['min'] }}
                                            \, min + {{ $detail['sec'] }} \, s \times \frac{1 \, min}{60 \, s}\)</p>
                                        <p class="p-2">\( = {{ $detail['hour'] * 60 }} \, min + {{ $detail['min'] }} \, min +
                                            {{ $detail['sec'] / 60 }} \, min \)</p>
                                        <p class="p-2">\( = {{ $detail['mins'] }}\, min \)</p>

                                        <p  class=" text-[#49987d] p-2"><strong>{{ $lang['8'] ?? 'Total Seconds' }}:</strong></p>
                                        <p class="p-2">\( {{ $detail['hour'] }} \, hr \times \frac{3600 \, s}{1 \, hr} + {{ $detail['min'] }}
                                            \, min \times \frac{60 \, s}{1 \, min} + {{ $detail['sec'] }} \, s \)</p>
                                        <p class="p-2">\( = {{ $detail['hour'] * 3600 }} \, s + {{ $detail['min'] * 60 }} \, s +
                                            {{ $detail['sec'] }} \, s \)</p>
                                        <p class="p-2">\( = {{ $detail['secs'] }}\, s \)</p>
                                    </div>
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

<div>
    <style>
        .content table,
        .content th,
        .content td {
            border: 1px solid #9f9d9d;
            border-collapse: collapse;
            padding: 5px;
            text-align: center;
        }

        .content table tr:hover td {
            color: #fff !important;
            background-color: rgb(0, 0, 0) !important;
        }

        #current {
            padding-right: 8px;
        }

        #current::-webkit-calendar-picker-indicator {
            cursor: pointer;
            font-size: 20px;
        }

        #next {
            padding-right: 8px;
        }

        #next::-webkit-calendar-picker-indicator {
            cursor: pointer;
            font-size: 20px;
        }
    </style>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[60%] md:w-[90%] w-full mx-auto  ">
                <div class="grid grid-cols-1 gap-4 mb-4">
                    <div class="space-y-2 overflow-auto">
                        <div class="flex items-center md:space-x-4 space-x-1">
                            <label class="flex items-center cursor-pointer space-x-2">
                                <input type="radio" wire:model="stype" value="s_date"
                                    wire:click="changeOperation('s_date')" class="cursor-pointer" />
                                <span>{{ $lang[4] }}</span>
                            </label>

                            <label class="flex items-center cursor-pointer space-x-2">
                                <input type="radio" wire:model="stype" value="e_date"
                                    wire:click="changeOperation('e_date')" class="cursor-pointer" />
                                <span>{{ $lang[5] }}</span>
                            </label>

                            <label class="flex items-center cursor-pointer space-x-2">
                                <input type="radio" wire:model="stype" value="date"
                                    wire:click="changeOperation('date')" class="cursor-pointer" />
                                <span>{{ $lang[6] }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Inputs and Symbol -->
                <div class="grid grid-cols-5 gap-2 items-center">

                    <div class="space-y-1 md:col-span-2 col-span-6">
                        <label for="current" class="text-sm">{{ $lang[1] }}</label>
                        <div class="w-full py-2">
                            <input type="date" id="current" wire:model="current"
                                class="input" />
                        </div>
                    </div>
                    <!-- Symbol -->
                    <p class="text-lg mt-3 md:col-span-1 col-span-6 text-center symble">{{ $this->symbol }}</p>
                    <!-- Show only when stype == date -->
                    <div class="space-y-1 md:col-span-2 col-span-6"
                        style="{{ $stype === 'date' ? 'display:block' : 'display:none' }}">
                        <label for="next" class="text-sm">{{ $lang[2] }}</label>
                        <div class="w-full py-2">
                            <input type="date" id="next" wire:model="next"
                                class="input" />
                        </div>
                    </div>
                    <!-- Show only when stype != date -->
                    <div class="space-y-1 md:col-span-2 col-span-6"
                        style="{{ $stype !== 'date' ? 'display:block' : 'display:none' }}">
                        <label for="number" class="text-sm">{{ $lang[3] }}</label>
                        <div class="w-full py-2">
                            <input type="number" id="number" wire:model="number"
                                class="input" autocomplete="off" />
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
                        <div class="w-full  p-1 rounded-lg mt-3 overflow-auto">
                            <div class="grid grid-cols-1">
                                <div class="w-full">
                                    @if ($detail['stype'] == 'date')
                                        <div class="text-center">
                                            <p
                                                class="md:text-[30px] text-[20px] bg-[#55be30] px-4 py-3 rounded-lg inline-block my-6">
                                                <strong class="text-white">{{ $detail['weeks'] }}<span class="text-xl">
                                                        Weeks</span></strong>
                                            </p>
                                        </div>
                                    @elseif($detail['stype'] == 's_date')
                                        <div class="text-center">
                                            <p
                                                class="md:text-[30px] text-[20px] bg-[#55be30] px-4 py-3 rounded-lg inline-block my-6">
                                                <strong class="text-white">{{ $detail['adding'] }}</strong>
                                            </p>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <p
                                                class="md:text-[30px] text-[20px] bg-[#55be30] px-4 py-3 rounded-lg inline-block my-6">
                                                <strong class="text-white">{{ $detail['subbtract'] }}</strong>
                                            </p>
                                        </div>
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

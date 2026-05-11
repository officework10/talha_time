<div>
    <style>
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

        .toggle-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0px;
        }

        .toggle-label {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }

        .toggle-switch {
            position: relative;
            width: 60px;
            height: 30px;
            margin-left: 10px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 30px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 24px;
            width: 24px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #55be30;
        }

        input:checked+.slider:before {
            transform: translateX(30px);
        }
    </style>
    @php
        $request = request();
        $nextYear = date('Y-m-d', strtotime('+1 month'));
        $selectedDays = request()->has('weekDay') ? request()->input('weekDay') : [''];
    @endphp
    <form wire:submit.prevent="calculate" class="row">

        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[50%] md:w-[60%] w-full mx-auto ">
                <div class="grid grid-cols-12  gap-4">
                    <div class="col-span-6">
                        <label for="current" class="label">{{ $lang['1'] }}</label>
                        <div class="w-100 py-2">
                            <input type="date" wire:model="current" name="" id="current" class="input"
                                aria-label="input" />
                        </div>
                    </div>
                    <div class="col-span-6">
                        <label for="next" class="label">{{ $lang['2'] ?? 'Next Date' }}</label>
                        <div class="w-100 py-2">
                            <input type="date" wire:model="next" id="next" class="input" aria-label="input" />
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <label for="next" class="label">{{ $lang['3'] }}</label>
                        <div class="w-100 py-2">
                            <select wire:model="startEvent" wire:change="changestartEvent" id="startEvent"
                                class="input">
                                <option value="empty">---</option>
                                <option value="Thanksgiving (Canada)">Thanksgiving (Canada)</option>
                                <option value="Halloween">Halloween</option>
                                <option value="Thanksgiving (US)">Thanksgiving (US)</option>
                                <option value="Christmas">Christmas</option>
                                <option value="New Year's Eve">New Year's Eve</option>
                                <option value="Easter (Easter Sunday)">Easter (Easter Sunday)</option>
                            </select>
                        </div>
                        {{-- @dd($request->startEvent) --}}
                    </div>
                </div>
                <div class="grid grid-cols-1   gap-4">
                    <div class="toggle-container {{ $device == 'mobile' ? 'row' : '' }}">
                        <div class="toggle-label col-lg-6 col-12">
                            <span>Include all days?</span>
                            <label class="toggle-switch">
                                <input type="checkbox" id="chkPassport" wire:change="changeinc_all"
                                    wire:model="inc_all" />
                                <span class="slider"></span>
                            </label>
                        </div> <br>

                        <div class="toggle-label col-lg-6 col-12">
                            <span>Include end day?</span>
                            <label class="toggle-switch">
                                <input type="checkbox" wire:model="inc_day" />
                                <span class="slider"></span>
                            </label>
                        </div>

                    </div>

                    <div class="px-2 mt-2 {{ $inc_all ? 'hidden' : '' }}" id="dvPassport">
                        <label for="currency" class="heading">Days to include:</label>
                        <span class="radio-switch">
                            <input type="checkbox" id="check-0" class="rounded-full w-5 h-5" value="Mon"
                                wire:model="weekDay">
                            <label for="check-0">M</label>

                            <input type="checkbox" id="check-1" class="rounded-full w-5 h-5" value="Tue"
                                wire:model="weekDay">
                            <label for="check-1">T</label>

                            <input type="checkbox" id="check-2" class="rounded-full w-5 h-5" value="Wed"
                                wire:model="weekDay">
                            <label for="check-2">W</label>

                            <input type="checkbox" id="check-3" class="rounded-full w-5 h-5" value="Thu"
                                wire:model="weekDay">
                            <label for="check-3">T</label>

                            <input type="checkbox" id="check-4" class="rounded-full w-5 h-5" value="Fri"
                                wire:model="weekDay">
                            <label for="check-4">F</label>

                            <input type="checkbox" id="check-5" class="rounded-full w-5 h-5" value="Sat"
                                wire:model="weekDay">
                            <label for="check-5">S</label>

                            <input type="checkbox" id="check-6" class="rounded-full w-5 h-5" value="Sun"
                                wire:model="weekDay">
                            <label for="check-6">S</label>
                        </span>
                        <span class="clearElement"></span>
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

                @if ($type == 'calculator')
                    @include('inc.copy-pdf')
                @endif
                <div class="w-full mt-3">
                    <div class="w-full my-2 overflow-auto">
                        <div class="lg:w-[50%] md:w-[80%] w-full gap-4 md:text-[18px] text-[16px]">
                            <table class="w-full table-auto px-5">
                                <tbody>
                                    @if ($inc_all)
                                        @isset($detail['totaldays'])
                                            <tr class="border-b p-2">
                                                <td class="px-4 py-2 font-semibold">Total Days</td>
                                                <td class="px-4 py-2 ">{{ $detail['totaldays'] }}</td>
                                            </tr>
                                        @endisset

                                        @isset($detail['months'])
                                            <tr class="border-b p-2">
                                                <td class="px-4 py-2 font-semibold ">Months</td>
                                                <td class="px-4 py-2 ">{{ $detail['months'] }}</td>
                                            </tr>
                                        @endisset
                                    @endif

                                    @if ($inc_all)
                                        @isset($detail['weeks'])
                                            <tr class="border-b p-2">
                                                <td class="px-4 py-2 font-semibold ">Weeks</td>
                                                <td class="px-4 py-2 ">{{ $detail['weeks'] }}</td>
                                            </tr>
                                        @endisset
                                    @endif

                                    @isset($detail['days'])
                                        <tr class="border-b p-2">
                                            <td class="px-4 py-2 font-semibold ">Days</td>
                                            <td class="px-4 py-2  ">{{ $detail['days'] }}</td>
                                        </tr>
                                    @endisset

                                    @isset($detail['hours'])
                                        <tr class="border-b p-2">
                                            <td class="px-4 py-2 font-semibold ">Hours</td>
                                            <td class="px-4 py-2  ">{{ $detail['hours'] }}</td>
                                        </tr>
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endisset

    </form>
</div>

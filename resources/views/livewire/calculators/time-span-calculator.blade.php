<div>
    <form wire:submit.prevent="calculate" class="row">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="mt-0 my-2 text-center">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8">
                    <span class="text-sm text-blue-600">Clock Format</span>

                    <div>
                        {{-- 12 Hour --}}
                        <label for="clock12" class="inline-flex items-center cursor-pointer text-blue-600 text-sm">
                            <input type="radio" id="clock12" value="12" wire:model="clock_format"
                                wire:click="changeOperation('12')" class="form-radio text-blue-600 mr-2">
                            12 Hour
                        </label>

                        {{-- 24 Hour --}}
                        <label for="clock24" class="inline-flex items-center cursor-pointer text-blue-600 text-sm">
                            <input type="radio" id="clock24" value="24" wire:model="clock_format"
                                wire:click="changeOperation('24')" class="form-radio text-blue-600 mr-2">
                            24 Hour
                        </label>
                    </div>
                </div>
            </div>

            <div class="lg:w-[60%] md:w-[90%] w-full mx-auto overflow-auto">
                <div class="flex flex-wrap">
                    <label class="label">Start Time:</label>
                    <div class="w-full flex space-x-4">
                        <div class="w-full px-2">
                            <label class="label">Hours:</label>
                            <input type="number" min="0" max="23" wire:model="s_hour" class="input"
                                placeholder="Hrs">
                        </div>
                        <div class="w-full px-2">
                            <label class="label">Minutes:</label>
                            <input type="number" min="0" max="59" wire:model="s_min" class="input"
                                placeholder="Min" >
                        </div>
                        <div class="w-full px-2">
                            <label class="label">Seconds:</label>
                            <input type="number" min="0" max="59" wire:model="s_sec" class="input"
                                placeholder="Sec" >
                        </div>
                        @if ($clock_format == '12')
                            <div class="w-full px-2">
                                <label class="label">AM/PM:</label>
                                <select wire:model="s_ampm" class="input">
                                    <option value="am">AM</option>
                                    <option value="pm">PM</option>
                                </select>
                            </div>
                        @endif
                    </div>

                    <label class="label">End Time:</label>
                    <div class="w-full flex space-x-4">
                        <div class="w-full px-2">
                            <label class="label">Hours:</label>
                            <input type="number" min="0" max="23" wire:model="e_hour" class="input"
                                placeholder="Hrs">
                        </div>
                        <div class="w-full px-2">
                            <label class="label">Minutes:</label>
                            <input type="number" min="0" max="59" wire:model="e_min" class="input"
                                placeholder="Min">
                        </div>
                        <div class="w-full px-2">
                            <label class="label">Seconds:</label>
                            <input type="number" min="0" max="59" wire:model="e_sec" class="input"
                                placeholder="Sec">
                        </div>
                        @if ($clock_format == '12')
                            <div class="w-full px-2">
                                <label class="label">AM/PM:</label>
                                <select wire:model="e_ampm" class="input">
                                    <option value="am">AM</option>
                                    <option value="pm">PM</option>
                                </select>
                            </div>
                        @endif
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
            {{-- result --}}
            <div id="result-section" wire:loading.remove wire:target="calculate"
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg  flex items-center justify-center">
                        <div class="w-full bg-light-blue  rounded-[10px] mt-3">
                            <div class="my-2">
                                <div class="md:text-[18px] text-[16px]">
                                    <table class="w-full">
                                        <tr>
                                            <td class="w-[70%] border-b py-2">
                                                <strong>{{ $lang[7] ?? 'From first time to second time' }} :</strong>
                                            </td>
                                            <td class="border-b py-2">
                                                {{ $detail['first_to_second'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border-b py-2">
                                                <strong>{{ $lang[8] ?? 'From second time to first time' }} :</strong>
                                            </td>
                                            <td class="border-b py-2">
                                                {{ $detail['second_to_first'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border-b py-2">
                                                <strong>{{ $lang[9] ?? 'From first time to second time over midnight' }} :</strong>
                                            </td>
                                            <td class="border-b py-2">
                                                {{ $detail['first_to_second_over_night'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border-b py-2">
                                                <strong>{{ $lang[10] ?? 'From second time to first time over midnight' }} :</strong>
                                            </td>
                                            <td class="border-b py-2">
                                                {{ $detail['second_to_first_over_night'] }}
                                            </td>
                                        </tr>
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

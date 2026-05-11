<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
          
    
            <div class="lg:w-[50%] md:w-[80%] w-full mx-auto ">
                <div class="grid grid-cols-12  gap-2 md:gap-4 lg:gap-4">

                        <div class="mt-2 flex oprations col-span-12">
                            <input type="radio" wire:model.live="outputformate" id="hr12" name="outputformate" value="hr12" {{ $outputformate == 'hr12' ? 'checked' : '' }}>
                            <label for="hr12" class="mx-1">12h am/pm</label><br>
                            <input type="radio" wire:model.live="outputformate" id="hr24" name="outputformate" value="hr24" {{ $outputformate == 'hr24' ? 'checked' : '' }} class="mx-1">
                            <label for="hr24">24 hour</label><br>
                        </div>
                        <p class="col-span-12 head_clr "><strong> {{ @$lang['1'] ?? 'Start Time' }} </strong></p>

                        <div class="col-span-4 md:col-span-3 lg:col-span-3  relative colons mb-2 fixLayoutCol">
                            <div class="mb-1 relative">
                                <label for="hh" class="form-label" id="CurrentHour">{{$lang['hrs'] ?? 'Hours'}}</label>
                                <input type="number" wire:model="hh" required min="0" max="12" name="hh" id="hh" class="input remove_shadow t_sec" placeholder="_ _">
                            </div>
                        </div>
                        <div class="col-span-4 md:col-span-3 lg:col-span-3  relative colons fixLayoutCol">
                            <div class="mb-1 relative">
                                <label for="mm" class="form-label" id="CurrentMinutes">{{$lang['min'] ?? 'Minutes'}}</label>
                                <input type="number" wire:model="mm" required min="0" max="59" name="mm" id="mm" class="input remove_shadow t_sec" placeholder="_ _">
                            </div>
                        </div>
                        <div class="col-span-4 md:col-span-3 lg:col-span-3  fixLayoutCol">
                            <div class="mb-1 relative ">
                                <label for="ss" min="0" max="60" class="form-label" id="CurrentSeconds">{{$lang['sec'] ?? 'Seconds'}}</label>
                                <input type="number" wire:model="ss" required min="0" max="60" name="ss" id="ss" class="input remove_shadow t_sec" placeholder="_ _">
                            </div>
                        </div>
                        <div class="col-span-4 md:col-span-3 lg:col-span-3  am_pm" style="display: {{ $outputformate == 'hr24' ? 'none' : 'block' }}">
                            <div class="mb-1 relative">
                                <label for="method" class="form-label" id="CurrentMinutes">AM/PM</label>
                                <select wire:model="method" name="method" id="method" class="input input remove_shadow dotdown">
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                        </div>

                        <p class="col-span-12 head_clr "><strong> {{ @$lang['2'] ?? "End Time" }} </strong></p>
                        <div class="col-span-4 md:col-span-3 lg:col-span-3 relative colons mb-2 fixLayoutCol">
                            <div class="mb-1 relative">
                                <label for="hhe" class="form-label" id="CurrentHour">{{$lang['hrs'] ?? 'Hours'}}</label>
                                <input type="number" wire:model="hhe" required min="0" max="12" name="hhe" id="hhe" class="input remove_shadow t_sec" placeholder="_ _">
                            </div>
                        </div>
                        <div class="col-span-4 md:col-span-3 lg:col-span-3 relative colons fixLayoutCol">
                            <div class="mb-1 relative">
                                <label for="mme" class="form-label" id="CurrentMinutes">{{$lang['min'] ?? 'Minutes'}}</label>
                                <input type="number" wire:model="mme" required min="0" max="59" name="mme" id="mme" class="input remove_shadow t_sec" placeholder="_ _">
                            </div>
                        </div>
                        <div class="col-span-4 md:col-span-3 lg:col-span-3 fixLayoutCol">
                            <div class="mb-1 relative ">
                                <label for="sse" min="0" max="60" class="form-label" id="CurrentSeconds">{{$lang['sec'] ?? 'Seconds'}}</label>
                                <input type="number" wire:model="sse" required min="0" max="60" name="sse" id="sse" class="input remove_shadow t_sec" placeholder="_ _">
                            </div>
                        </div>
                       <div class="col-span-4 md:col-span-3 lg:col-span-3  am_pm" style="display: {{ $outputformate == 'hr24' ? 'none' : 'block' }}">
                            <div class="mb-1 relative">
                                <label for="methode" class="form-label" id="CurrentMinutes">AM/PM</label>
                                <select wire:model="methode" name="methode" id="methode" class="input input remove_shadow dotdown">
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-span-12">
                            <div class="grid grid-cols-12" id="breaks">
                                @if(!empty($breaks) && is_array($breaks))
                                    @foreach($breaks as $index => $breakValue)
                                            <div class="col-span-4 md:col-span-3 lg:col-span-3 mb-2 mt-2 p-1 p-lg-2 jsdivs">
                                                <label for="break_{{ $index + 1 }}" class="text-[14px] text-blue flex relative w-full justify-between items-center" onclick="breaksInstance.removeDiv(this)">
                                                    <div>Break {{ $index + 1 }}:</div>
                                                    <div class=""><img src="/images/assets/images/icons/delete_btn.png" width="15px" /></div>
                                                </label>
                                                <div class="w-full py-2 flex gap-3 items-center">
                                                    <input type="number" wire:model="breaks.{{ $index }}" required max="1000" name="breaks_{{ $index + 1 }}" class="input input remove_shadow d" aria-label="input" value="{{ $breakValue }}" />
                                                    Min
                                                </div>
                                            </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded-lg focus:ring-2 focus:ring-gray-500 mt-[10px] text-[16px]" id="addBreaks">Add Break</button>
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
                    <div class="w-full mx-auto   rounded-3xl">
                        <div class=" w-full mx-auto ">
                            <div class="grid grid-cols-12  gap-2 md:gap-4 lg:gap-4">
                                <div class="col-span-12">
                                    @if (!isset($error))
                                        <div class="w-full mt-5">
                                            <table class="w-full text-base">
                                                <tbody>
                                                    <tr class="bg-gray-100">
                                                        <td class="py-3 px-4 font-semibold text-gray-900" width="50%">
                                                            {{ $lang['3'] ?? 'Time Worked (hh:mm):' }}
                                                        </td>
                                                        <td class="py-3 px-4 text-gray-900">
                                                            {{ $detail['time_worked'] }}
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-white">
                                                        <td class="py-3 px-4 font-semibold text-gray-900">
                                                            {{ $lang['4'] ?? "In Hours:" }}
                                                        </td>
                                                        <td class="py-3 px-4 text-gray-900">
                                                            {{ $detail['in_hours'] }} hr
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-gray-100">
                                                        <td class="py-3 px-4 font-semibold text-gray-900">
                                                            {{ $lang['5'] ?? "In Minutes:" }}
                                                        </td>
                                                        <td class="py-3 px-4 text-gray-900">
                                                            {{ $detail['in_minutes'] }} min
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @else 
                                        <div class="w-full text-center">
                                            <p class="text-lg text-red-600 font-semibold">
                                                The break time exceeds the time worked
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

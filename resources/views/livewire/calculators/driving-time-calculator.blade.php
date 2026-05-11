<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="lg:w-[80%] md:w-[100%] w-full mx-auto ">
                <div class="grid grid-cols-12  gap-2 md:gap-4 lg:gap-4">

                    <div class="col-span-12">
                        <div class="grid grid-cols-12  gap-2 md:gap-4 lg:gap-4">
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 ">
                                    <label for="distance" class="form-label" id="changeText">{{ $lang['1'] ?? 'Distance' }}</label>
                                    <input type="number" step="any" wire:model="distance" id="distance" class="input remove_shadow t_sec" placeholder="00">
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-2 lg:col-span-2">
                                <div class="mb-1">
                                    <label for="distance_unit" class="form-label box-shadow-0">&nbsp;</label>
                                    <select wire:model="distance_unit" id="distance_unit" class="input remove_shadow">
                                        <option value="km">km</option>
                                        <option value="mi">mi</option>
                                        <option value="m">m</option>
                                        <option value="nmi">nmi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 ">
                                    <label for="average_speed" class="form-label" id="changeText">{{ $lang['2'] ?? 'Average Speed' }}</label>
                                    <input type="number" step="any" wire:model="average_speed" id="average_speed" class="input remove_shadow t_sec" placeholder="00">
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-2 lg:col-span-2">
                                <div class="mb-1">
                                    <label for="average_speed_unit" class="form-label box-shadow-0">&nbsp;</label>
                                    <select wire:model="average_speed_unit" id="average_speed_unit" class="input remove_shadow">
                                        <option value="km/h">km/h</option>
                                        <option value="m/h">m/h</option>
                                        <option value="mph">mph</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 ">
                                    <label for="breaks" class="form-label" id="changeText">{{ $lang['3'] ?? 'Breaks' }}</label>
                                    <input type="number" step="any" wire:model="breaks" id="breaks" class="input remove_shadow t_sec" placeholder="00">
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-2 lg:col-span-2">
                                <div class="mb-1">
                                    <label for="breaks_unit" class="form-label box-shadow-0">&nbsp;</label>
                                    <select wire:model="breaks_unit" id="breaks_unit" class="input remove_shadow">
                                        <option value="sec">sec</option>
                                        <option value="min">min</option>
                                        <option value="hrs">hrs</option>
                                        <option value="days">days</option>
                                        <option value="wks">wks</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-5 lg:col-span-5">
                                <div class="mb-1 ">
                                    <label for="departure_time" class="form-label" id="changeText">{{ $lang['4'] ?? 'Departure Time' }}</label>
                                    <input type="datetime-local" wire:model="departure_time" id="departure_time" class="input remove_shadow t_sec">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12">
                        <div class="grid grid-cols-12  gap-2 md:gap-4 lg:gap-4">
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 ">
                                    <label for="fuel_e" class="form-label" id="changeText">{{ $lang['5'] ?? 'Fuel Efficiency' }}</label>
                                    <input type="number" step="any" wire:model="fuel_e" id="fuel_e" class="input remove_shadow t_sec" placeholder="00">
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-2 lg:col-span-2">
                                <div class="mb-1">
                                    <label for="fuel_e_unit" class="form-label box-shadow-0">&nbsp;</label>
                                    <select wire:model="fuel_e_unit" id="fuel_e_unit" class="input remove_shadow">
                                        <option value="L/100km">L/100km</option>
                                        <option value="us mpg">us mpg</option>
                                        <option value="uk mpg">uk mpg</option>
                                        <option value="km/L">km/L</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 ">
                                    <label for="fuel_p" class="form-label" id="changeText">{{ $lang['7'] ?? 'Price' }}</label>
                                    <input type="number" step="any" wire:model="fuel_p" id="fuel_p" class="input remove_shadow t_sec" placeholder="00">
                                </div>
                            </div>
                            <div class="col-span-6 md:col-span-2 lg:col-span-2">
                                <div class="mb-1">
                                    <label for="fuel_p_unit" class="form-label box-shadow-0">&nbsp;</label>
                                    <select wire:model="fuel_p_unit" id="fuel_p_unit" class="input remove_shadow">
                                        <option value="{{ $currancy }}/L">{{ $currancy }} /L</option>
                                        <option value="{{ $currancy }}/us gal">{{ $currancy }} /us gal</option>
                                        <option value="{{ $currancy }}/uk gal">{{ $currancy }} /uk gal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-6">
                                <div class="mb-1 ">
                                    <label for="passengers" class="form-label" id="changeText">{{ $lang['8'] ?? 'Passengers' }}</label>
                                    <input type="number" step="any" wire:model="passengers" id="passengers" class="input remove_shadow t_sec" placeholder="00">
                                </div>
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
                <div class="w-full mx-auto rounded-3xl">
                    <div class="w-full mx-auto">
                        <div class="col-span-12 overflow-x-auto mt-4">
                            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                                <tbody>
                                    <tr>
                                        <td class="py-2 border p-2 text-[#49987d]" width="50%"><strong>{{ $lang['28'] ?? 'Travel Time' }}</strong></td>
                                        <td class="py-2 border p-2 text-dark">
                                            @php
                                                $totalHours = $detail['total_drive_hours'] ?? 0;
                                                $wholeHours = floor($totalHours);
                                                $remainingMinutes = round(($totalHours - $wholeHours) * 60);
                                            @endphp
                                            {{ sprintf("%02d", $wholeHours) }} {{ $lang['19'] ?? 'hr' }}
                                            {{ sprintf("%02d", $remainingMinutes) }} {{ $lang['20'] ?? 'min' }}
                                        </td>
                                    </tr>
                                    @if(isset($detail['arrival_time']))
                                        <tr>
                                            <td class="py-2 border p-2 text-[#49987d]"><strong>{{ $lang['32'] ?? 'Arrival' }} :</strong></td>
                                            <td class="py-2 border p-2 text-dark">{{ $detail['arrival_time'] }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="py-2 border p-2 text-[#49987d]" width="50%"><strong>{{ $lang['30'] ?? 'Cost' }} </strong></td>
                                        <td class="py-2 border p-2 text-dark"> {{ $currencySymbol ?? '$' }}{{ number_format($detail['total_drive_cost'] ?? 0, 2) }} </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 border p-2 text-[#49987d]" width="50%"><strong>{{ $lang['41'] ?? 'Cost Per Person' }}</strong></td>
                                        <td class="py-2 border p-2 text-dark"> {{ $currencySymbol ?? '$' }}{{ number_format($detail['drive_cost_per_person'] ?? 0, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                       
                    </div>
                </div>
        </div>
        </div>
 @endisset
   </form>
     </div>
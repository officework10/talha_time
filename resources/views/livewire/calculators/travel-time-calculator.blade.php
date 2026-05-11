<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            
            <div class="lg:w-[65%] md:w-[80%] w-full mx-auto ">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">

                    <div class="col-span-12 flex justify-center">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                            <!-- Distance -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1">
                                    <label for="distance" class="label" id="changeText">{{ $lang['1'] ?? 'Distance' }}</label>
                                    <input type="number" wire:model="distance" id="distance" class="input remove_shadow t_sec" placeholder="00" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <!-- Distance Unit -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1">
                                    <label for="distance_unit" class="label box-shadow-0">&nbsp;</label>
                                    <select wire:model="distance_unit" id="distance_unit" class="input remove_shadow" aria-label="Default select example">
                                        <option value="km">{{ $lang['39'] ?? 'Kilometers (km)' }}</option>
                                        <option value="mi">{{ $lang['38'] ?? 'Miles (mi)' }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Speed -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1">
                                    <label for="speed" class="label" id="changeText">{{ $lang['2'] ?? 'Average Speed' }}</label>
                                    <input type="number" wire:model="speed" id="speed" class="input remove_shadow t_sec" placeholder="00" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <!-- Speed Unit -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1">
                                    <label for="speed_unit" class="label box-shadow-0">&nbsp;</label>
                                    <select wire:model="speed_unit" id="speed_unit" class="input remove_shadow" aria-label="Default select example">
                                        <option value="kmpl">{{ $lang['37'] ?? 'km/h' }}</option>
                                        <option value="mpg">{{ $lang['36'] ?? 'mph' }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                            <!-- Break Hrs -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 relative">
                                    <label for="break_hrs" class="label">{{ $lang['3'] ?? 'Total Break Time' }}</label>
                                    <input type="number" wire:model="break_hrs" id="break_hrs" class="input remove_shadow t_sec" placeholder="00" aria-describedby="emailHelp">
                                    <span class="text-blue input_unit whitespace-nowrap">{{ $lang['6'] ?? 'hrs' }}</span>
                                </div>
                            </div>
                            <!-- Break Min -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1 relative">
                                    <label for="break_min" class="label">{{ $lang['3'] ?? 'Total Break Time' }}</label>
                                    <input type="number" wire:model="break_min" id="break_min" class="input remove_shadow t_sec" placeholder="00" aria-describedby="emailHelp">
                                    <span class="text-blue input_unit whitespace-nowrap">{{ $lang['40'] ?? 'min' }}</span>
                                </div>
                            </div>
                            <!-- Departure Time -->
                            <div class="col-span-12 md:col-span-6 lg:col-span-6">
                                <div class="mb-1">
                                    <label for="dep_time" class="label">{{ $lang['4'] ?? 'Departure Time' }}</label>
                                    <input type="datetime-local" wire:model="dep_time" id="dep_time" class="input remove_shadow t_sec uppercase" placeholder="00" aria-describedby="emailHelp">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cost Section Title -->
                    <div class="col-span-12 flex justify-md-center">
                        <div class="text-start text-[#49987d] font-bold">{{ $lang['13'] ?? 'Cost' }}</div>
                    </div>

                    <div class="col-span-12">
                        <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                            <!-- Fuel efficiency -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1">
                                    <label for="fule_effi" class="label">{{ $lang['5'] ?? 'Fuel Economy' }}</label>
                                    <input type="number" wire:model="fule_effi" id="fule_effi" class="input remove_shadow t_sec" placeholder="00" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <!-- Fuel Efficiency Unit -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1">
                                    <label for="fule_effi_unit" class="label box-shadow-0">&nbsp;</label>
                                    <select wire:model="fule_effi_unit" id="fule_effi_unit" class="input remove_shadow" aria-label="Default select example">
                                        <option value="kmpl">{{ $lang['37'] ?? 'kmpl' }}</option>
                                        <option value="mpg">{{ $lang['36'] ?? 'mpg' }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Fuel Price -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1">
                                    <label for="price" class="label">{{ $lang['2'] ?? 'Average Speed' }}</label> <!-- Matching user's label id from 816 -->
                                    <input type="number" wire:model="price" id="price" class="input remove_shadow t_sec" placeholder="00" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <!-- Fuel Price Unit -->
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1">
                                    <label for="price_unit" class="label box-shadow-0">{{ $lang['2'] ?? 'Average Speed' }}</label> <!-- Matching user's label id from 816 -->
                                    <select wire:model="price_unit" id="price_unit" class="input remove_shadow" aria-label="Default select example">
                                        <option value="liter">{{ $currencySymbol ?? '$' }}liter</option>
                                        <option value="gallon">{{ $currencySymbol ?? '$' }} gallon</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Passengers -->
                    <div class="col-span-12">
                        <div class="grid grid-cols-12 gap-2">
                            <div class="col-span-6 md:col-span-3 lg:col-span-3">
                                <div class="mb-1">
                                    <p class="label mb-1">{{ $lang['per_unit'] ?? 'per unit' }}</p> <!-- Added based on screenshot -->
                                    <label for="passenger" class="label hidden">{{ $lang['8'] ?? 'Passengers' }}</label>
                                    <input type="number" wire:model="passenger" id="passenger" class="input remove_shadow t_hour" placeholder="00" aria-describedby="emailHelp">
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

        <!-- Result Section -->
        @isset($detail)
            <div id="result-section" wire:loading.remove wire:target="calculate"
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="w-full mx-auto rounded-3xl">
                        <div class="w-full mx-auto">
                            <div class="grid grid-cols-12 mt-4 gap-2 md:gap-4 lg:gap-4">
                                <div class="col-span-12" id="res_copy">
                                    <table class="w-full text-[18px] md:w-[70%] lg:w-[70%]">
                                        <tbody>
                                            <tr>
                                                <td class="py-2 border-b text-[#49987d]" width="60%"><strong>{{ $lang['28'] ?? 'Travel Time' }}</strong></td>
                                                <td class="py-2 border-b text-dark">{{ $detail['hours'] ?? '0' }} {{ $lang['19'] ?? 'hr' }} {{ $detail['mins'] ?? '0' }} {{ $lang['20'] ?? 'min' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 border-b text-[#49987d]" width="60%"><strong>{{ $lang['30'] ?? 'Departure' }}</strong></td>
                                                <td class="py-2 border-b text-dark">{{ $detail['depature'] ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 border-b text-[#49987d]" width="60%"><strong>{{ $lang['41'] ?? 'Arrival' }}</strong></td>
                                                <td class="py-2 border-b text-dark">{{ $detail['arrival'] ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 border-b" width="60%"><strong>{{ $lang['31'] ?? 'Fuel Consumption' }}</strong></td>
                                                <td class="py-2 border-b text-dark">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 border-b text-[#49987d]" width="60%"><strong>{{ $lang['32'] ?? 'Total Fuel Cost' }}</strong></td>
                                                <td class="py-2 border-b text-dark">{{ $currencySymbol ?? '$' }}{{ $detail['fule_price'] ?? '0.00' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 border-b text-[#49987d]" width="60%"><strong>{{ $lang['33'] ?? 'Cost per Person' }}</strong></td>
                                                <td class="py-2 border-b text-dark">{{ $currencySymbol ?? '$' }}{{ $detail['per_person'] ?? '0.00' }}</td>
                                            </tr>
                                        </tbody>
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
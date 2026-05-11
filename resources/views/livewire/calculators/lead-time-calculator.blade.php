<div>
    <form wire:submit.prevent="calculate" class="row">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[50%] md:w-[90%] w-full mx-auto ">
                <div class="grid grid-cols-1  gap-4">
                    <div class="space-y-2 relative">
                        <label for="type" class="label">{!! $lang['1'] !!}:</label>
                        <select class="input" wire:model="types" wire:change="changetype" name="type" id="type">
                            <option value="manufac">{{ $lang['24'] ?? 'Manufacturing' }}</option>
                            <option value="order">{{ $lang['25'] ?? 'Order' }}</option>
                            <option value="supply">{{ $lang['26'] ?? 'Supply Chain Management' }}</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 mt-4  lg:grid-cols-2 md:grid-cols-2  gap-4">
                    <div class="space-y-2 {{ $types == 'manufac' ? 'd-block' : 'hidden' }}">
                        <label for="pre_time" class="label">{{ $lang['2'] }}:</label>

                        <div class="relative w-full" x-data="{ open: false }">
                            <input type="number" wire:model="pre_time" step="any" id="pre_time"
                                class="input" aria-label="input"
                                placeholder="00">

                            <label for="pre_units" class="absolute cursor-pointer text-sm underline right-6 top-4"
                                @click="open = !open">
                                {{ $pre_units }} ▾
                            </label>

                            <input type="hidden" wire:model="pre_units" id="pre_units">

                            <div x-show="open" x-cloak
                                class="absolute z-10 p-1 bg-white border border-gray-300 rounded-md lg:w-[30%] md:w-[30%] w-[30%] mt-1 right-0"
                                @click.away="open = false">
                                @foreach (['days', 'sec', 'min', 'hrs', 'wks', 'mos', 'yrs'] as $name)
                                    <p class="p-1 hover:bg-gray-100 cursor-pointer"
                                        wire:click="setPreUnit('{{ $name }}')" @click="open = false">
                                        {{ $name }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2 {{ $types == 'manufac' ? 'd-block' : 'hidden' }}">
                        <label for="p_time" class="label">{{ $lang['3'] }}:</label>

                        <div class="relative w-full" x-data="{ showDropdown: false }">
                            <input type="number" step="any" wire:model.lazy="p_time"
                                class="input" placeholder="00" />

                            <label class="absolute cursor-pointer text-sm underline right-6 top-4"
                                @click="showDropdown = !showDropdown">
                                {{ $p_units }} ▾
                            </label>

                            <div class="absolute z-10 p-1 bg-white border border-gray-300 rounded-md lg:w-[30%] md:w-[30%] w-[30%] mt-1 right-0"
                                x-show="showDropdown" @click.away="showDropdown = false" x-transition x-cloak>
                                @foreach (['days', 'sec', 'min', 'hrs', 'wks', 'mos', 'yrs'] as $name)
                                    <p class="p-1 hover:bg-gray-100 cursor-pointer"
                                        wire:click="$set('p_units', '{{ $name }}')"
                                        @click="showDropdown = false">
                                        {{ $name }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 {{ $types === 'manufac' ? 'd-block' : 'hidden' }}">
                        <label for="post_time" class="label">{{ $lang['4'] ?? 'Post Time' }}:</label>
                        <div class="relative w-full" x-data="{ open: false }">
                            <input type="number" name="post_time" id="post_time" step="any" wire:model="post_time"
                                class="input" placeholder="00" />

                            <label for="post_units" class="absolute cursor-pointer text-sm underline right-6 top-4"
                                x-on:click="open = !open">
                                {{ $post_units }} ▾
                            </label>

                            <input type="text" id="post_units" name="post_units" class="hidden"
                                wire:model="post_units" />

                            <div id="post_units_dropdown"
                                class="absolute z-10 p-1 bg-white border border-gray-300 rounded-md lg:w-[30%] md:w-[30%] w-[30%] mt-1 right-0"
                                x-show="open" x-on:click.outside="open = false" x-cloak>
                                @foreach (['days', 'sec', 'min', 'hrs', 'wks', 'mos', 'yrs'] as $unit)
                                    <p class="p-1 hover:bg-gray-100 cursor-pointer"
                                        x-on:click="$wire.set('post_units', '{{ $unit }}'); open = false">
                                        {{ $unit }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 date {{ $types == 'order' ? 'd-block' : 'hidden' }}">
                        <label for="place_time" class="label">{{ $lang['5'] }}:</label>
                        <input type="datetime-local" step="any" name="" id="place_time" class="input"
                            aria-label="input" wire:model="place_time" />
                    </div>
                    <div class="space-y-2 date {{ $types == 'order' ? 'd-block' : 'hidden' }}">
                        <label for="receive_time" class="label">{{ $lang['6'] }}:</label>
                        <input type="datetime-local" wire:model="receive_time" step="any" name="receive_time"
                            id="receive_time" class="input" aria-label="input" />
                    </div>


                    <div class="space-y-2 supplys {{ $types == 'supply' ? 'd-block' : 'hidden' }}">
                        <label for="s_delay" class="label">{{ $lang['7'] }}:</label>
                        <div class="relative w-full" x-data="{ open: false }">
                            {{-- Delay input --}}
                            <input type="number" wire:model="s_delay" id="s_delay" step="any"
                                class="input" placeholder="00" />

                            {{-- Unit dropdown toggle --}}
                            <label for="supply_units" class="absolute cursor-pointer text-sm underline right-6 top-4"
                                x-on:click="open = !open">
                                {{ $supply_units }} ▾
                            </label>

                            {{-- Hidden input (optional) --}}
                            <input type="text" wire:model="supply_units" id="supply_units" class="hidden" />

                            {{-- Dropdown options --}}
                            <div x-show="open" x-cloak
                                class="absolute z-10 p-1 bg-white border border-gray-300 rounded-md lg:w-[30%] md:w-[30%] w-[30%] mt-6 right-0 top-5">
                                @foreach (['days', 'sec', 'min', 'hrs', 'wks', 'mos', 'yrs'] as $unit)
                                    <p class="p-1 hover:bg-gray-100 cursor-pointer"
                                        wire:click="setUnit('supply_units', '{{ $unit }}')"
                                        x-on:click="open = false">
                                        {{ $unit }}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 supplys {{ $types === 'supply' ? 'd-block' : 'hidden' }}">
                        <label for="r_delay" class="label">{{ $lang['8'] }}:</label>
                        <div class="relative w-full">
                            <input type="number" wire:model="r_delay" id="r_delay" step="any"
                                class="input" placeholder="00" />

                            <div x-data="{ open: false }" class="">
                                <label class="absolute cursor-pointer text-sm underline right-6 top-3"
                                    x-on:click="open = !open">
                                    {{ $r_units }} ▾
                                </label>

                                <input type="text" wire:model="r_units" id="r_units" class="hidden" />

                                <div class="absolute z-10 p-1 bg-white border border-gray-300 rounded-md lg:w-[30%] md:w-[30%] w-[30%] mt-6 right-0 top-6"
                                    x-show="open" x-cloak>
                                    @foreach (['days', 'sec', 'min', 'hrs', 'wks', 'mos', 'yrs'] as $unit)
                                        <p class="p-1 hover:bg-gray-100 cursor-pointer"
                                            wire:click="setUnit('r_units', '{{ $unit }}')"
                                            x-on:click="open = false">
                                            {{ $unit }}
                                        </p>
                                    @endforeach
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
                    <div class="rounded-lg  flex items-center justify-center">
                        <div class="w-full mt-3">
                            <div class="w-full my-2 overflow-auto">
                                <div class="lg:w-[60%] md:w-[80%] w-full gap-4 text-[18px]">
                                    @php
                                        $days = 0;
                                        $mainResult = '';
                                        
                                        if ($detail['type'] == 'manufac') {
                                            $days = $detail['manufac']; 
                                            $mainResult = round($days, 2) . ' ' . ($lang['19'] ?? 'days');
                                        } elseif ($detail['type'] == 'order') {
                                            $days = $detail['diff_minutes'] / 1440;
                                            $mainResult = $detail['timeDiff'];
                                        } elseif ($detail['type'] == 'supply') {
                                            $days = $detail['supply'];
                                            $mainResult = round($days, 2) . ' ' . ($lang['19'] ?? 'days');
                                        }
                                    @endphp

                                    <div class="flex flex-col md:flex-row gap-8">
                                        <!-- Left Column: Detailed Breakdown -->
                                        <div class="w-full md:w-2/3">
                                            <table class="w-full">
                                                <tr class="border-b border-gray-300">
                                                    <td class="py-3 font-bold text-[#49987d]">{{ $lang['13'] ?? 'Lead Seconds' }}</td>
                                                    <td class="py-3 text-right">{{ number_format($days * 86400, 0) }} {{ $lang['13'] == 'Lead Seconds' ? 'sec' : '' }}</td>
                                                </tr>
                                                <tr class="border-b border-gray-300">
                                                    <td class="py-3 font-bold text-[#49987d]">{{ $lang['14'] ?? 'Lead Minutes' }}</td>
                                                    <td class="py-3 text-right">{{ number_format($days * 1440, 0) }} {{ $lang['14'] == 'Lead Minutes' ? 'min' : '' }}</td>
                                                </tr>
                                                <tr class="border-b border-gray-300">
                                                    <td class="py-3 font-bold text-[#49987d]">{{ $lang['15'] ?? 'Lead Hours' }}</td>
                                                    <td class="py-3 text-right">{{ number_format($days * 24, 0) }} {{ $lang['15'] == 'Lead Hours' ? 'hrs' : '' }}</td>
                                                </tr>
                                                <tr class="border-b border-gray-300">
                                                    <td class="py-3 font-bold text-[#49987d]">{{ $lang['16'] ?? 'Lead Weeks' }}</td>
                                                    <td class="py-3 text-right">{{ number_format($days / 7, 4) }} {{ $lang['16'] == 'Lead Weeks' ? 'wks' : '' }}</td>
                                                </tr>
                                                <tr class="border-b border-gray-300">
                                                    <td class="py-3 font-bold text-[#49987d]">{{ $lang['17'] ?? 'Lead Months' }}</td>
                                                    <td class="py-3 text-right">{{ number_format($days / 30.417, 4) }} {{ $lang['17'] == 'Lead Months' ? 'mos' : '' }}</td>
                                                </tr>
                                                <tr class="border-b border-gray-300">
                                                    <td class="py-3 font-bold text-[#49987d]">{{ $lang['18'] ?? 'Lead Years' }}</td>
                                                    <td class="py-3 text-right">{{ number_format($days / 365, 4) }} {{ $lang['18'] == 'Lead Years' ? 'yrs' : '' }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <!-- Right Column: Main Result -->
                                        <div class="w-full md:w-1/3 flex items-start justify-end">
                                            <div class="text-right">
                                                <h2 class="text-4xl font-bold text-[#49987d]">{{ $mainResult }}</h2>
                                            </div>
                                        </div>
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

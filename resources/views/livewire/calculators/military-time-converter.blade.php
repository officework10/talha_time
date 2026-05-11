<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[50%] md:w-[90%] w-full mx-auto ">
                <div class="grid grid-cols-1  lg:grid-cols-2 md:grid-cols-2  gap-4">
                    <div class="space-y-2 ">
                        <label for="conversion"
                            class="label">{{ $lang['1'] }}({{ $lang['2'] }}):</label>
                        <select class="input mt-2" wire:model="conversion" wire:change="changeconversion"
                            name="conversion" id="conversion">
                            <option value="1">{{ $lang[3] }}</option>
                            <option value="2">{{ $lang[4] }}</option>
                        </select>
                    </div>
                    <div class="space-y-2 formate {{ $conversion == '2' ? 'hidden' : 'd-block' }} ">
                        <label for="military_time" class="label">{{ $lang['5'] }}:</label>
                        <input type="number" name="military_time" id="military_time" min="100" max="2400"
                            class="input military_time" aria-label="input" wire:model="military_time" />
                    </div>
                    <div class="space-y-2 hours {{ $conversion == '2' ? 'd-block' : 'hidden' }}">
                        <label class="label">&nbsp;</label>
                        {{-- AM/PM Toggle --}}
                        {{-- 12h / 24h Toggle --}}
                        <div class="flex items-center bg-white text-center mt-3 border rounded-lg p-1">
                            <div class="w-1/2 py-2 cursor-pointer rounded-md {{ $hourFormat === '12h' ? 'tagsUnit' : '' }}"
                                wire:click="setHourFormat('12h')">
                                12 Hours
                            </div>
                            <div class="w-1/2 py-2 cursor-pointer rounded-md {{ $hourFormat === '24h' ? 'tagsUnit' : '' }}"
                                wire:click="setHourFormat('24h')">
                                24 Hours
                            </div>
                        </div>
                        <input type="hidden" name="hours" id="hours" wire:model="hours">

                    </div>

                    <div class="space-y-2 hours {{ $conversion == '2' ? 'd-block' : 'hidden' }}">
                        <label for="hur" class="text-sm text-blue-500">{{ $lang['6'] }}:</label>
                        <div class="py-2 flex items-center">
                            <input type="number" max="12" min="1" name="hur" id="hur"
                                placeholder="Hour"
                                class="input"
                                aria-label="input" wire:model="hur" />
                            <span class="mt-2 px-2">:</span>
                            <input type="number" max="59" min="0" name="min" id="min"
                                placeholder="Minutes"
                                class="input"
                                aria-label="input" wire:model="min" />
                        </div>
                    </div>
                    <div class="space-y-2 hours {{ $conversion == '2' ? 'd-block' : 'hidden' }}">
                        <label class="label">&nbsp;</label>
                        <div
                            class="flex items-center bg-white text-center mt-3 border border-gray-300 rounded-lg p-1 {{ $hourFormat !== '12h' ? 'hidden' : 'block' }} ">
                            <div id="am" wire:click="$set('am_pm', 'am')"
                                class="w-1/2 py-2 cursor-pointer rounded-md am {{ $am_pm === 'am' ? 'tagsUnit' : '' }}">
                                AM
                            </div>
                            <div id="pm" wire:click="$set('am_pm', 'pm')"
                                class="w-1/2 py-2 cursor-pointer rounded-md pm {{ $am_pm === 'pm' ? 'tagsUnit' : '' }}">
                                PM
                            </div>
                            <input type="hidden" id="am_pm" wire:model="am_pm">
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
            <div id="result-section" wire:loading.remove wire:target="calculate" class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg  flex items-center justify-center">
                       <div class="w-full mt-3">
                            <div class="w-full my-2 overflow-auto">
                                <div class="lg:w-[70%] md:w-[90%] w-full gap-4 text-[16px]">
                                    <table class="w-full text-lg">
                                        <!-- Military Time Row -->
                                        <tr>
                                            <td class="border-b py-2 font-bold">{{ $lang['8'] ?? 'Military Time' }} :</td>
                                            <td class="border-b py-2">{{ $detail['military_time'] }}</td>
                                        </tr>

                                        <!-- English Word Row -->
                                        <tr>
                                            <td class="border-b py-2 font-bold">{{ $lang['9'] ?? 'Read as' }} :</td>
                                            <td class="border-b py-2">{{ $detail['eng_word'] }}</td>
                                        </tr>

                                        <!-- 12-Hour Format Row -->
                                        <tr>
                                            <td class="border-b py-2 font-bold">{{ $lang['10'] ?? 'Regular time (12h format)' }} :</td>
                                            <td class="border-b py-2">{{ $detail['bara_ghante'] }}</td>
                                        </tr>

                                        <!-- 24-Hour Format Row -->
                                        <tr>
                                            <td class="border-b py-2 font-bold">{{ $lang['11'] ?? 'Regular time (24h format)' }} :</td>
                                            <td class="border-b py-2">{{ $detail['chubees_ghante'] }}</td>
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

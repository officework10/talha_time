<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3 bg-gray-100">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="lg:w-[60%] md:w-[80%] w-full mx-auto">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">

                    <div class="col-span-7 md:col-span-3 lg:col-span-3">
                        <label for="a" class="label">{{ $lang['1'] }}</label>
                        <input type="number" step="any" wire:model="a" id="a" class="input remove_shadow t_sec" placeholder="45">
                    </div>
                    <div class="col-span-5 md:col-span-3 lg:col-span-3">
                        <label for="a_unit" class="label box-shadow-0">&nbsp;</label>
                        <select wire:model="a_unit" id="a_unit" class="input remove_shadow">
                            <option value="deg">deg</option>
                            <option value="rad">rad</option>
                        </select>
                    </div>
                    <div class="col-span-7 md:col-span-3 lg:col-span-3">
                        <label for="h" class="label">{{ $lang['2'] }} (h)</label>
                        <input type="number" step="any" wire:model="h" id="h" class="input remove_shadow t_sec" placeholder="0">
                    </div>
                    <div class="col-span-5 md:col-span-3 lg:col-span-3">
                        <label for="h_unit" class="label box-shadow-0">&nbsp;</label>
                        <select wire:model="h_unit" id="h_unit" class="input remove_shadow">
                            <option value="cm">cm</option>
                            <option value="m">m</option>
                            <option value="km">km</option>
                            <option value="in">in</option>
                            <option value="ft">ft</option>
                            <option value="yd">yd</option>
                            <option value="mi">mi</option>
                        </select>
                    </div>

                    <div class="col-span-7 md:col-span-3 lg:col-span-3">
                        <label for="v" class="label">{{ $lang['3'] }} (V)</label>
                        <input type="number" step="any" wire:model="v" id="v" class="input remove_shadow t_sec" placeholder="5">
                    </div>
                    <div class="col-span-5 md:col-span-3 lg:col-span-3">
                        <label for="v_unit" class="label box-shadow-0">&nbsp;</label>
                        <select wire:model="v_unit" id="v_unit" class="input remove_shadow">
                            <option value="ms">m/s</option>
                            <option value="kmh">km/h</option>
                            <option value="fts">ft/s</option>
                            <option value="mph">mph</option>
                        </select>
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
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="w-full mx-auto rounded-3xl">
                        <div class="w-full mx-auto">
                            <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                                
                                <div class="col-span-12">
                                    <div class="w-full md:w-[60%] lg:w-[60%] my-4">
                                        <table class="w-full text-[18px]">
                                            <tbody>
                                                <tr>
                                                    <td class="py-2 border-b text-[#49987d]" width="70%"><strong>{{ $lang['28'] }}</strong></td>
                                                    <td class="py-2 border-b text-dark">{{ $detail['tof'] }} sec</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 border-b text-[#49987d]" width="70%"><strong>{{ $lang['30'] }}</strong></td>
                                                    <td class="py-2 border-b text-dark">{{ $detail['vx'] }} m/s</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 border-b text-[#49987d]" width="70%"><strong>{{ $lang['41'] }}</strong></td>
                                                    <td class="py-2 border-b text-dark">{{ $detail['vy'] }} m/s</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 border-b text-[#49987d]" width="70%"><strong>{{ $lang['31'] }}</strong></td>
                                                    <td class="py-2 border-b text-dark">{{ $detail['g'] }} m/s²</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-span-12 text-[14px] md:text-[15px] lg:text-[15px] overflow-auto">
                                    <p class="mt-2 text-dark font-semibold"><span>{{ $lang['9'] }}</span></p>
                                    @if ($detail['h'] == 0)
                                        <p class="mt-2 text-dark font-medium">\(\text{∴ {{ $lang['18'] }} = 0}\)</p>
                                        <p class="mt-2">\(t = \dfrac{2 V_o sin(α)}{g}\)</p>
                                        <p class="mt-2">{{ $lang['11'] }}</p>
                                        <p class="mt-2">\(V_o - \text{ {{ $lang['19'] }} } = {{ $detail['v'] }} m/s\)</p>
                                        <p class="mt-2">\(α - \text{ {{ $lang['20'] }} } = {{ $detail['a'] }} deg\)</p>
                                        <p class="mt-2">\(g - \text{ {{ $lang['21'] }} } = {{ $detail['g'] }} m/s²\)</p>
                                        <p class="mt-2">{{ $lang['22'] }}</p>
                                        <p class="mt-2">\(t = \dfrac{2 V_o sin(α)}{g}\)</p>
                                        <p class="mt-2">\(t = \dfrac{2 \times {{ $detail['v'] }} \times sin({{ $detail['a'] }})}{{{ $detail['g'] }}}\)</p>
                                        <p class="mt-2">\(t = \dfrac{2 \times {{ $detail['v'] }} \times {{ $detail['sin'] }}}{{{ $detail['g'] }}}\)</p>
                                        <p class="mt-2">\(t = \dfrac{{{ $detail['res'] ?? 0 }}}{{{ $detail['g'] }}}\)</p>
                                        <p class="mt-2">\(\text{t = {{ $detail['tof'] }} sec}\)</p>
                                    @endif
                                    @if ($detail['h'] > 0)
                                        <p class="mt-2 text-dark font-medium">\(\text{∴ {{ $lang['18'] }} > 0}\)</p>
                                        <p class="mt-2">\(t = \dfrac{V_o sin(α) + \sqrt{(V_o sin(α))^2 + 2gh}}{g}\)</p>
                                        <p class="mt-2">{{ $lang['11'] }}</p>
                                        <p class="mt-2">\(V_o - \text{ {{ $lang['19'] }} } = {{ $detail['v'] }} m/s\)</p>
                                        <p class="mt-2">\(α - \text{ {{ $lang['20'] }} } = {{ $detail['a'] }} deg\)</p>
                                        <p class="mt-2">\(g - \text{ {{ $lang['21'] }} } = {{ $detail['g'] }} m/s²\)</p>
                                        <p class="mt-2">{{ $lang['22'] }}</p>
                                        <p class="mt-2">\(t = \dfrac{V_o sin(α) + \sqrt{(V_o sin(α))^2 + 2gh}}{g}\)</p>
                                        <p class="mt-2">\(t = \dfrac{ {{ $detail['v'] }} \times sin({{ $detail['a'] }}) + \sqrt{({{ $detail['v'] }} \times sin({{ $detail['a'] }}))^2 + 2 \times{{ $detail['g'] }}\times{{ $detail['h'] }}}}{{{ $detail['g'] }}}\)</p>
                                        <p class="mt-2">\(t = \dfrac{ {{ $detail['v'] }} \times {{ $detail['sin'] }} + \sqrt{({{ $detail['v'] }} \times {{ $detail['sin'] }})^2 + 2 \times{{ $detail['g'] }}\times{{ $detail['h'] }}}}{{{ $detail['g'] }}}\)</p>
                                        <p class="mt-2">\(t = \dfrac{ {{ $detail['vy'] }} + \sqrt{({{ $detail['vy'] }})^2 + {{ $detail['gh'] }}}}{{{ $detail['g'] }}}\)</p>
                                        <p class="mt-2">\( t = \dfrac{ {{ $detail['vy'] }} + \sqrt{ {{ $detail['vs2gh'] }}}}{{ $detail['g'] }}\)</p>
                                        <p class="mt-2">\(t = \dfrac{{{ $detail['vysqrt'] }}}{{{ $detail['g'] }}}\)</p>
                                        <p class="mt-2">\(\text{t = {{ $detail['tof'] }} sec}\)</p>
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
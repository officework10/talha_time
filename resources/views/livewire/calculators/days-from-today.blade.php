<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[50%] md:w-[70%] w-full mx-auto">
                <div class="grid grid-cols-12 gap-4">
                    <div class=" lg:px-0 col-span-6">
                        <div class="w-full mx-auto">
                            <label class="text-sm">{{ $lang['1'] }}</label>
                            <div class="grid grid-cols-7 text-center border rounded-md mt-2 bg-white">

                                @foreach ($days as $day)
                                    <p wire:click="selectDay({{ $day }})"
                                        class="col cursor-pointer border-r py-2
                                {{ $number == $day ? 'bg-[#55be30] text-white font-semibold' : '' }}">
                                        {{ $day }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class=" lg:px-0 col-span-6">
                        <div class="space-y-2">
                            <label for="number" class="text-sm">&nbsp;</label>
                            <input type="number" name="number" id="number" class="input border p-2 rounded w-full"
                                wire:model="number" aria-label="input" autocomplete="off" min="1" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-[50%] md:w-[70%] w-full mx-auto">
                <div class="grid grid-cols-12 mt-5gap-4">
                    <div class="date-now col-span-6 md:col-span-6 relative">
                        <div class="flex justify-between items-center">
                            <label for="current" class="text-sm">{{ $lang['2'] ?? 'Select Date' }}:</label>

                            <!-- Livewire action for click -->
                            <span wire:click="setNow" class="text-sm text-right text-[#55be30] underline cursor-pointer"
                                style="user-select:none;">
                                {{ $lang['now'] ?? 'Now' }}
                            </span>
                        </div>

                        <div class="w-full py-2">
                            <input type="date" name="current" id="current" wire:model="current"
                                class="input-lg focus:ring-2 input focus:ring-[#38A169]"
                                aria-label="input" />
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
                        <div class="w-full bg-light-blue p-3 rounded-lg mt-3 overflow-auto">
                            <div class="flex flex-col">
                                <div class="w-full">
                                    <div class="text-center">
                                        <p class="text-xl bg-[#55be30] text-white px-3 py-2 rounded-lg inline-block my-3">
                                            <strong class="text-blue">
                                                {{ $detail['date_name'] }}
                                                <img src="{{ asset('images/r_days.png') }}" alt="Calendar"
                                                    class="inline mb-1 w-7 h-7">
                                                {{ $detail['t_date'] }}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="lg:w-7/12 w-full mx-auto mt-2">
                                        <table class="w-full">
                                            <tr>
                                                <td class="border-b border-dark py-2 w-1/3">
                                                    <img src="{{ asset('images/days_usa.svg') }}" class="w-1/4"
                                                        alt="USA Flag">
                                                </td>
                                                <td class="border-b border-dark py-2 text-right">
                                                    {{ $detail['t_date'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-b border-dark py-2">
                                                    <img src="{{ asset('images/days_uk.svg') }}" class="w-1/4"
                                                        alt="UK Flag">
                                                </td>
                                                <td class="border-b border-dark py-2 text-right">
                                                    {{ $detail['uk_date'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-b border-dark py-2">
                                                    <img src="{{ asset('images/days_usa.svg') }}" class="w-1/4"
                                                        alt="USA Flag">
                                                </td>
                                                <td class="border-b border-dark py-2 text-right">
                                                    {{ $detail['usa_num'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-b border-dark py-2">
                                                    <img src="{{ asset('images/days_uk.svg') }}" class="w-1/4"
                                                        alt="UK Flag">
                                                </td>
                                                <td class="border-b border-dark py-2 text-right">
                                                    {{ $detail['number'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2">
                                                    <span class="border rounded-md p-1 mb-1 text-sm">ISO</span>
                                                </td>
                                                <td class="py-2 text-right">
                                                    {{ $detail['iso'] }}
                                                </td>
                                            </tr>
                                        </table>
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

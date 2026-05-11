<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 rounded-lg bg-gray-100 space-y-6 mb-3">
            @if ($error)
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <input type="hidden" name="language" value="{{ $language }}">

            @if(\Illuminate\Support\Facades\View::exists('livewire.calculators.time-calculator-'.$language))
                @include('livewire.calculators.time-calculator-'.$language)
            @else
                @include('livewire.calculators.time-calculator-en')
            @endif

            <div class="mt-10 text-center space-x-2">
                @include('inc.button')
            </div>
        </div>

        @if ($detail)
            <div id="result-section" class="w-full mx-auto p-4 lg:p-8 md:p-8 bg-white rounded-lg shadow-md space-y-6 result">
                <div class="w-full">
                    @include('inc.copy-pdf')

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-10">
                        @if (isset($detail['days']))
                            <div class="flex items-center p-3 bg-gray-50 border rounded-lg">
                                <img src="{{ asset('icons/r_days.png') }}" width="30">
                                <span class="text-[#49987d] font-bold mx-2">{{ $lang['1'] ?? 'Days' }}</span>
                                <span class="text-xl">{{ $detail['days'] }}</span>
                            </div>
                        @endif
                        @if (isset($detail['hour']) || isset($detail['hours']))
                            <div class="flex items-center p-3 bg-gray-50 border rounded-lg">
                                <img src="{{ asset('icons/r_hour.png') }}" width="30">
                                <span class="text-[#49987d] font-bold mx-2">{{ $lang['2'] ?? 'Hours' }}</span>
                                <span class="text-xl">{{ $detail['hour'] ?? $detail['hours'] }}</span>
                            </div>
                        @endif
                        @if (isset($detail['min']) || isset($detail['minutes']))
                            <div class="flex items-center p-3 bg-gray-50 border rounded-lg">
                                <img src="{{ asset('icons/r_mint.png') }}" width="30">
                                <span class="text-[#49987d] font-bold mx-2">{{ $lang['3'] ?? 'Minutes' }}</span>
                                <span class="text-xl">{{ $detail['min'] ?? $detail['minutes'] }}</span>
                            </div>
                        @endif
                        @if (isset($detail['seconds']))
                            <div class="flex items-center p-3 bg-gray-50 border rounded-lg">
                                <img src="{{ asset('icons/r_sec.png') }}" width="30">
                                <span class="text-[#49987d] font-bold mx-2">{{ $lang['4'] ?? 'Seconds' }}</span>
                                <span class="text-xl">{{ $detail['seconds'] }}</span>
                            </div>
                        @endif

                        @if (isset($detail['finalDate']))
                            <div class="col-span-full text-center py-6 bg-green-50 rounded-xl border border-green-200">
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ $detail['resTime'] }} {{ $detail['finalDate'] }}
                                </p>
                                <p class="text-lg text-gray-600">{{ $detail['resDay'] }}</p>
                            </div>
                        @endif

                        @if (isset($detail['formattedDate']))
                             <div class="col-span-full text-center py-6 bg-green-50 rounded-xl border border-green-200">
                                <p class="text-2xl font-bold text-gray-800">
                                    {{ $detail['formattedDate'] }} {{ $detail['formattedTime'] }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>

<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[60%] md:w-[60%] w-full mx-auto ">
                <div class="grid grid-cols-1 lg:grid-cols-2 md:grid-cols-2 gap-4">
                    <div class="space-y-2 ">
                        <label for="current" class="label">{{ $lang['1'] }}</label>
                        <div class="w-100 py-2">
                            <input type="datetime-local" id="current" class="input cursor-pointer"
                                wire:model.lazy="current" aria-label="input" />
                        </div>
                    </div>
                    <div class="space-y-2 ">
                        <label for="next" class="label">{{ $lang['2'] }}</label>
                        <div class="w-100 py-2">
                            <input type="datetime-local" id="next" class="input cursor-pointer"
                                wire:model.lazy="next" aria-label="input" />
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
                        <div class="w-full p-3 rounded-lg mt-3 overflow-auto">
                            <div class="loader-container">
                                <div id="loading" class="loader"></div>
                                <div class="loader-text"></div>
                            </div>
                            <div class="loader-container hidden">
                                <div id="loading" class="loader"></div>
                                <div class="loader-text"></div>
                            </div>
                            <div class="flex flex-wrap">
                                <div class="lg:w-2/12 w-6/12">
                                    <p class="border-b border-dark pt-2 pb-1">
                                        <strong id="years" class="text-xl mr-1">{{ $detail['years'] }}</strong>
                                        Years
                                    </p>
                                    <p class="border-b border-dark pt-2 pb-1">
                                        <strong id="months" class="text-xl mr-1">{{ $detail['months'] }}</strong>
                                        Months
                                    </p>
                                    <p class="border-b border-dark pt-2 pb-1">
                                        <strong id="days" class="text-xl mr-1">{{ $detail['days'] }}</strong>
                                        Days
                                    </p>
                                    <p class="border-b border-dark pt-2 pb-1">
                                        <strong id="hours" class="text-xl mr-1">{{ $detail['hours'] }}</strong>
                                        Hours
                                    </p>
                                    <p class="border-b border-dark pt-2 pb-1">
                                        <strong id="minutes" class="text-xl mr-1">{{ $detail['minutes'] }}</strong>
                                        Minutes
                                    </p>
                                    <p class="border-b border-dark pt-2 pb-1">
                                        <strong id="seconds" class="text-xl mr-1">{{ $detail['seconds'] }}</strong>
                                        Seconds
                                    </p>
                                </div>
                            </div>
                            <p class="pt-3"><strong>Until The Final Date! ⏱️🗓️</strong></p>
                        </div>

                    </div>
                </div>
            </div>
            @endif
        </form>

    </div>

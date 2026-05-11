<div>
    <style>
        .mera_table table thead tr {
            margin-top: 10px !important;
        }

        .filled-in {
            width: 15px;
            height: auto;
            margin-right: 10px
        }

        [type="checkbox"]+span:not(.lever) {
            position: relative;
            cursor: pointer;
            display: inline-block;
            font-size: 1rem;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        input[type="number"]:not(.browser-default):disabled {
            color: rgba(0, 0, 0, 0.42)
        }

        .time_table tbody tr .plus {
            font-size: 30px;
            margin-bottom: 12px !important;
        }

        .time_table tbody tr p {
            font-size: 20px;
            margin-bottom: 12px !important;
        }

        .mera_table table tr {
            border-bottom: 0px !important;
        }

        .del_btn {
            padding: 12px
        }

        .add {
            padding-right: 20px
        }

        .add_btn {
            float: right
        }

        .khali_div td {
            padding-top: 0px !important;
            margin-top: 0px !important;
        }

        td ::placeholder {
            /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: var(--pClr) !important;
        }

        #remove {
            cursor: pointer
        }

        input[type="number"]:disabled {
            cursor: not-allowed
        }

        .result tr {
            border-bottom: 2px solid #ddd !important
        }

        .result tr:last-child {
            border-bottom: none !important
        }

        @media (max-width: 480px) {
            .border_form {
                padding: 10px !important
            }

            .add {
                margin-right: 0px !important;
                margin-top: 10px !important
            }


        }

        table tr td {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        td {
            padding: 15px 5px;
            display: table-cell;
            text-align: left;
            vertical-align: middle;
            border-radius: 2px;
        }

        .p_5 {
            padding: 5px
        }
    </style>
    <form wire:submit.prevent="calculate" class="row">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[70%] md:w-[100%] w-full mx-auto ">
                <input type="hidden" id="count_val" name="count_val" wire:model="count_val">
                <div class="grid grid-cols-1 gap-4">
                    <div class="w-full overflow-auto mera_table">
                        <table class="w-full time_table table-auto border-collapse">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td>
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="hours_check"
                                                wire:change="toggleColumn('hours')">
                                            <span class="text-black ml-2">Hours</span>
                                        </label>
                                    </td>
                                    <td></td>
                                    <td>
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="min_check"
                                                wire:change="toggleColumn('minutes')">
                                            <span class="text-black ml-2">Minutes</span>
                                        </label>
                                    </td>
                                    <td></td>
                                    <td>
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="sec_check"
                                                wire:change="toggleColumn('seconds')">
                                            <span class="text-black ml-2">Seconds</span>
                                        </label>
                                    </td>
                                    <td></td>
                                    <td>
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="milli_check"
                                                wire:change="toggleColumn('milliseconds')">
                                            <span class="text-black ml-2">Milliseconds</span>
                                        </label>
                                    </td>
                                    <td></td>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>
                                            @if ($index > 0)
                                                <p class="plus text-blue">+</p>
                                            @endif
                                        </td>

                                        {{-- Hours --}}
                                        <td>
                                            <input type="number" min="0" placeholder="hours"
                                                wire:model.defer="rows.{{ $index }}.inhour"
                                                @if (!$hours_check) disabled @endif class="input hours">
                                        </td>

                                        <td>
                                            <p>:</p>
                                        </td>

                                        {{-- Minutes --}}
                                        <td>
                                            <input type="number" min="0" placeholder="minutes"
                                                wire:model.defer="rows.{{ $index }}.inminutes"
                                                @if (!$min_check) disabled @endif class="input minutes">
                                        </td>

                                        <td>
                                            <p>:</p>
                                        </td>

                                        {{-- Seconds --}}
                                        <td>
                                            <input type="number" min="0" placeholder="seconds"
                                                wire:model.defer="rows.{{ $index }}.inseconds"
                                                @if (!$sec_check) disabled @endif class="input seconds">
                                        </td>

                                        <td>
                                            <p>:</p>
                                        </td>

                                        {{-- Milliseconds --}}
                                        <td>
                                            <input type="number" min="0" placeholder="milliseconds"
                                                wire:model.defer="rows.{{ $index }}.inmiliseconds"
                                                @if (!$milli_check) disabled @endif
                                                class="input milliseconds">
                                        </td>

                                        {{-- Delete Row Button --}}
                                        <td>
                                            <div style="width: 30px;">
                                                @if ($index > 1)
                                                    <img src="{{ asset('assets/img/belete_btn.png') }}" width="50"
                                                        class="p_5 cursor-pointer image_more"
                                                        wire:click="removeRow({{ $index }})" alt="Delete">
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="w-full add">
                        <button type="button" wire:click="addRow"
                            class="add_btn relative bg-[#55be30] shadow-2xl text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[500] text-[14px] rounded-lg px-3 py-2 flex items-center justify-center gap-2">
                            <div class="flex items-center justify-center">
                                <strong class="font-semibold text-lg pe-2">+</strong>
                                <strong><?= $lang[5] ?></strong>
                            </div>
                        </button>
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
        @if ($total_time)
            <div id="result-section" class="mt-4 p-3 bg-gray-100 rounded">
                <strong>Total Time:</strong> {{ $total_time }}
            </div>
        @endif
        @isset($detail)
            <div id="result-section" wire:loading.remove wire:target="calculate"
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg  space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg  flex items-center justify-center">
                        <div class="w-full bg-light-blue result p-3 radius-10 mt-3">
                            <div class="row">
                                <div class="w-full overflow-auto">
                                    <table class="w-full" cellspacing="0">
                                        @php
                                            $develop = 0;
                                        @endphp
                                        @foreach ($detail['hour_list'] as $key => $value)
                                            <tr>
                                                <td class="border-b p-2">
                                                    <p class="text-center">

                                                        @php
                                                            if (++$develop === count($detail['hour_list'])) {
                                                                echo '+';
                                                            }
                                                        @endphp
                                                        {!! $value !!}
                                                        <span class="font_size16"> {!! $lang[1] !!}</span>
                                                    </p>
                                                </td>
                                                <td class="border-b p-2">
                                                    <p class="text-center">{!! $detail['min_list'][$key] !!}
                                                        {!! $lang[2] !!}
                                                    </p>
                                                </td>
                                                <td class="border-b p-2">
                                                    <p class="text-center">{!! $detail['sec_list'][$key] !!}
                                                        {!! $lang[3] !!}
                                                    </p>
                                                </td>
                                                <td class="border-b p-2">
                                                    <p class="text-center">{!! $detail['mili_list'][$key] !!}
                                                        {!! $lang[4] !!}
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="p-2">
                                                <p class="text-center">
                                                    <strong class="text-green font-s-25">
                                                        {!! round($detail['time_hour']) !!}
                                                    </strong>
                                                    {!! $lang[1] !!}
                                                </p>
                                            </td>
                                            <td class="p-2">
                                                <p class="text-center">
                                                    <strong class="text-green font-s-25">
                                                        {!! round($detail['time_minutes']) !!}
                                                    </strong>
                                                    {!! $lang[2] !!}
                                                </p>
                                            </td>
                                            <td class="p-2">
                                                <p class="text-center">
                                                    <strong class="text-green font-s-25">
                                                        {!! round($detail['time_seconds']) !!}
                                                    </strong>
                                                    {!! $lang[3] !!}
                                                </p>
                                            </td>
                                            <td class="p-2">
                                                <p class="text-center">
                                                    <strong class="text-green font-s-25">
                                                        {!! round($detail['time_miliseconds']) !!}
                                                    </strong>
                                                    {!! $lang[4] !!}
                                                </p>
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
        @push('calculatorJS')
            <script>
                window.addEventListener('alert', event => {
                    alert(event.detail.message);
                });
            </script>
        @endpush
    </form>
</div>

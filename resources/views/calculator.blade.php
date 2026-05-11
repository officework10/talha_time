@extends('layouts.app')
@section('title', $meta_title)
@section('meta_des', $meta_des)

@section('content')
    @php
        $detail = session('calculator_result');
    @endphp
    <div class="max-w-screen-xl mx-auto">
        <div class="flex flex-wrap mx-4 justify-center">
            <div class=" w-full   pt-4  mx-auto lg:py-5 md:py-5  relative z-10">
                <div class="text-center py-5">
                    <h1
                        class="xl:text-[35px] lg:text-[30] md:text-[30px] text-[27px] font-[700] px-2 leading-[40.68px] ">
                        {{ $cal_name }}
                    </h1>
                    @if (isset($cal_detail))
                        <p class="lg:text-[16px] md:text-[16px] text-[16px]  my-3 px-2">{{ $cal_detail }}
                        </p>
                    @endif
                </div>
           
                <div class="bordercalculator w-full  rounded-lg bg  space-y-6 mb-3 mt-5"
                    style="box-shadow: 0px 0px 20px 4px #0000001a">

                    @livewire('calculators.' . $page, [
                        'lang' => [],
                        'currancy' => $currancy,
                    ])

                    @if ($detail)
                        <livewire:component.calculator-result-actions :detail="$detail" :calculator-name="$cal_name" :calculator-link="$cal_data->cal_link"
                            :pageUrl="rtrim(url()->current(), '/') . '/'" />
                    @endif

                </div>
                
                {{-- Description Ad before content --}}
                <!-- @include('components.ads.TimeDescriptionAds') -->
                
                {{-- About Calculator --}}
                <div class="max-w-full mx-auto   px-3 my-5">
                    <div class="contentAll overflow-x-auto">
                        {!! $content !!}
                    </div>
                </div>
             
            </div>
           
        </div>
    </div>
    <!-- Feedback Modal -->
    <div id="default-modalfeed" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 items-center justify-center w-full h-full bg-black/50">
        <div class="relative w-full max-w-xl mx-auto p-4">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="text-2xl font-semibold text-[#000000]">
                        Give Us Your Feedback
                    </h3>
                    <button type="button"
                        class="text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-full p-1 transition"
                        data-modal-hide="default-modalfeed">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Modal Body -->
                <div class="px-6 py-6">
                    <livewire:feedback.calculator-feedback :calName="$cal_name" />
                </div>
            </div>
        </div>
    </div>
@endsection
@push('calculatorJS')
    <script>
        window.addEventListener('open-share-link', event => {
            const url = event.detail.url;
            window.open(url, '_blank', 'noopener,noreferrer,width=600,height=500');
        });
    </script>
@endpush

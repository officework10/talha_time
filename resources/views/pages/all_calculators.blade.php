@extends('layouts.app')
@section('title', $meta_title)
@section('meta_des', $meta_des)

@section('content')




    <div class="max-w-screen-xl mx-auto lg:px-0 px-5">
        <div class="xl:mt-[70px] lg:mt-[60px] mt-[50px]">
            <div class="xl:mb-[50px] lg:mb-[40px] mb-[40px]">
                <h1 class="text-center text-[36px] font-[700] leading-[46.87px]">
                    All Calculators
                </h1>
                <p class="text-[15px] text-opacity-60 lg:mt-5 mt-3 leading-[20.83px] lg:px-[150px] md:px-[150px] text-center font-[500]">
                    Explore a wide range of calculators designed to simplify your everyday tasks, from Health and Math calculations to Finance, Physics, and more. Whether you're looking for quick answers or in-depth analysis, our tools cover everything from Chemistry to Construction, Statistics, and even Pets and Time management.
                </p>
            </div>
            {{-- Mathematical Calculators --}}
            @foreach ($allcategories as $category)
                <div class="">
                    <h1
                        class="text-center lg:mb-12 md:mb-12 mb-6 lg:text-[36px] md:text-[36px] text-[25px] font-[700] md:leading-[46.87px]">
                        {{ $category->cat_name }} Calculators
                    </h1>
                    <?php
                    $allcalculators = Illuminate\Support\Facades\DB::table('calculators')
                        ->where('cal_cat', $category->cat_name)->where('show_hide', 1)
                        ->limit(12)
                        ->get();
                    ?>
                    <div
                        class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 grid-cols-1 xl:my-[50px] lg:my-[50px] my-[30px]">
                        @foreach ($allcalculators as $allcalculator)
                            <div
                                class="justify-between px-2 py-5  border-[#DEDEDE] hover_border cursor-pointer items-center">
                                <a href="{{ url($allcalculator->cal_link) }}/"
                                    class="flex justify-between items-center px-1">
                                    <h3 class="hover:underline">{{ $allcalculator->cal_title }}</h3>
                                    <svg width="6" height="11" viewBox="0 0 6 11" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 10L6 5.5L1 1" stroke="#55be30" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    @if ($category->cat_name != 'Pets')
                        <div class="flex justify-center">
                        @if($category->cat_name == 'Math')
                            <a href="{{ url(Str::lower($category->cat_name)) }}/"
                                class="bg-[#55be30] shadow-2xl mb-10 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3">
                                View All
                            </a>
                            @elseif($category->cat_name == 'Health')
                            <a href="{{ url(Str::lower($category->cat_name)) }}/"
                                class="bg-[#55be30] shadow-2xl mb-10 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3">
                                View All
                            </a>

                        @elseif($category->cat_name == 'Everyday-Life')
                            <a href="{{ url(Str::lower($category->cat_name)) }}/"
                                class="bg-[#55be30] shadow-2xl mb-10 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3">
                                View All
                            </a>
                        @elseif($category->cat_name == 'Finance')
                            <a href="{{ url(Str::lower($category->cat_name)) }}/"
                                class="bg-[#55be30] shadow-2xl mb-10 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3">
                                View All
                            </a>
                        @elseif($category->cat_name == 'Physics')
                            <a href="{{ url(Str::lower($category->cat_name)) }}/"
                                class="bg-[#55be30] shadow-2xl mb-10 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3">
                                View All
                            </a>
                        @elseif($category->cat_name == 'Chemistry')
                            <a href="{{ url(Str::lower($category->cat_name)) }}/"
                                class="bg-[#55be30] shadow-2xl mb-10 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3">
                                View All
                            </a>
                        @elseif($category->cat_name == 'Statistics')
                            <a href="{{ url(Str::lower($category->cat_name)) }}/"
                                class="bg-[#55be30] shadow-2xl mb-10 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3">
                                View All
                            </a>

                            @elseif($category->cat_name == 'Construction')
                            <a href="{{ url(Str::lower($category->cat_name)) }}/"
                                class="bg-[#55be30] shadow-2xl mb-10 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3">
                                View All
                            </a>
                            @elseif($category->cat_name == 'Timedate')
                            <a href="{{ url(Str::lower($category->cat_name)) }}/"
                                class="bg-[#55be30] shadow-2xl mb-10 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 py-3">
                                View All
                            </a>

                            @endif
                        </div>
                    @endif
                </div>
            @endforeach




        </div>
    </div>

@endsection

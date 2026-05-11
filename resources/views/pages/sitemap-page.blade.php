@extends('layouts.app')
@section('title', $meta_title)
@section('meta_des', $meta_des)
@section('content')


<div class="container-fluid mx-auto  container-fluid mt-[20px]">
    <div class="w-full max-w-6xl mx-auto py-1 rounded-lg text-center">
        <h1 class="text-2xl lg:text-3xl md:text-3xl px-5 font-semibold "><strong >All Calculators</strong></h1>
    </div>
    <div class="flex flex-col items-center py-1 mb-5">
        <div class="mt-2 w-full max-w-6xl bg-right bg-cover bg-white rounded-lg px-[12px] ">
            <div class="flex flex-col lg:flex-row">
                <div class=" w-full  order-1 lg:order-2  px-[5px]   rounded-lg md:mb-6 lg:mb-6 ">
                    <p class="text-gray-600  text-center ">
                      {{ $calculatorsCount }} Calculators
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-12 items-center py-1 mb-5">
                <div class="mt-2 col-span-12 md:col-span-4 lg w-full max-w-1xl bg-right bg-cover bg-white rounded-lg">
                    <label for="myInput" class="py-5">Filter Searching</label>
                    <input id="myInput" type="text" placeholder="Search.." class="mt-2">
                </div>
            </div>

            <div class="flex flex-col lg:flex-row">
                <div class="lg:w-[100%]  md:w-[100%] w-full  order-2 lg:order-1 p-[20px] lg:p-[10px] md:p-[10px]   rounded-lg inset-0  bg-center bg-no-repeat filter" style="background-image: url('{{ asset('new_page/finance_bg.svg') }}');">
                    <div class="grid grid-cols-12 gap-4   Everyday-Life" id="myTable">


                        @foreach($categories as $category)
                        @if(isset($groupedCalculators[$category->cat_name]) && $groupedCalculators[$category->cat_name]->isNotEmpty())


                                <h2 class="mb-3 mt-1 text-[25px] col-span-12"><strong>{{ $category->cat_name }} Calculators</strong></h2>
                                @foreach($groupedCalculators[$category->cat_name] as $calculator)
                                @if ($calculator->cal_title == $calculator->parent)

                                <h2 class="text-20px col-span-12 md:col-span-6">
                                    <ul class="list-disc pl-4 marker:text-black marker:text-[22px]">
                                        <li class="">
                                            <a href="{{ url($calculator->cal_link) }}" class="bg-white py-1 text-[18px] font-medium rounded-[12px] block hover:underline hover:text-black">
                                                {{ $calculator->cal_title }}
                                            </a>
                                        </li>
                                    </ul>
                                </h2>

                                @endif
                                @endforeach


                        @endif
                    @endforeach
                 
                       


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable h2").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>



@endsection
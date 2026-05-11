{{-- @if ($cal_data->is_calculator == 'Calculator' && app()->getLocale() == 'en')
 <!-- Breadcrumb -->
 <div class=" my-4 text-[12px] lg:text-[18px] md:text-[18px]">
    <span>Home</span> <span class="mx-1">&gt;</span> <span>{{ $cal_cat }}</span> <span class="mx-1">&gt;</span> <span>{{ $brudcum_parent }}</span>
  </div>
@endif --}}

@if ($cal_data->is_calculator == 'Converter' && app()->getLocale() == 'en')
 <!-- Breadcrumb -->
 <div class=" my-4 text-[12px] lg:text-[18px] md:text-[18px]">
    <span>Unit Converter</span> <span class="mx-1">&gt;</span> <span >{{ $brudcum_parent }}</span>
  </div>
@endif


@if ($cal_data->is_calculator == 'Calculator' && app()->getLocale() == 'en')
<nav class="text-black xl:text-[20px] lg:text-[20px] text-[14px] leading-[26.04px] font-[600] my-[20px]"
aria-label="Breadcrumb">
<ol class="list-none p-0 inline-flex">
    <!-- Home -->
    <li class="flex items-center  mx-1">
        <a href="{{ url('/') }}" class="hover:underline lg:text-[16px] md:text-[16px] text-[10px]">Home</a>
        <!-- Arrow SVG -->
        <svg width="8" class="mx-3" height="10" viewBox="0 0 8 14" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M1 13L7 7L0.999999 1" stroke="#55be30" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </li>
    
    <!-- Category Page Name -->
    <li class="flex items-center  mx-1">
        <a href="#" class="hover:underline  lg:text-[16px] md:text-[16px] text-[10px]">{{ $cal_cat }}</a>
        <!-- Arrow SVG -->
        <svg width="8" class="mx-3" height="10" viewBox="0 0 8 14" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M1 13L7 7L0.999999 1" stroke="#55be30" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </li>
    <!-- Calculator Name -->
    <li class="flex items-center  mx-1">
        <a href="#" class="text-blue-600 hover:underline lg:text-[16px] md:text-[16px] text-[10px]">{{ $brudcum_parent }}</a>
    </li>
</ol>
</nav>
@endif



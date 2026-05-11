@extends('layouts.app')
@section('title', $meta_title)
@section('meta_des', $meta_des)
@section('content')
    <div class="max-w-screen-xl mx-auto mb-7 lg:px-8 md:px-8 px-4">
        
        {{-- Category Header Ad --}}
        @include('components.ads.TimeTopHeaderCategoryAds')
        
        <div class="flex w-full lg:mt-10 md:mt-10 mt-5 ">
            <div class=" w-full lg:text-left ">
                <h1 class="lg:text-[30px] md:text-[30px] text-[26px] font-[700] leading-[46.87px]">
                    All {{ ucfirst($category) }} Calculators
                </h1>
                <p class="text-[17px] text-opacity-60  mt-2 leading-[29.83px] text-left font-[500]">
                    {{ $des }}
                </p>
            </div>
        </div>

        <!-- Search Section -->
        <div class="max-w-sm mt-6">
            <label for="calculator-search" class="block text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em] mb-1.5 ml-1">Search Tools</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="calculator-search" 
                    class="block w-full pl-9 pr-4 py-1.5 border border-gray-200 rounded-lg bg-gray-50/30 text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#55be30] focus:border-transparent transition-all duration-200" 
                    placeholder="Filter by name...">
            </div>
            <div class="mt-2 ml-1">
                <span id="calculator-count" class="text-xs font-semibold text-gray-600"></span>
            </div>
        </div>
    </div>
    <div class="max-w-screen-xl mx-auto lg:px-8 md:px-8 px-4 mb-10">
        <ul class="list-disc pl-4  marker:text-black marker:text-[22px] grid lg:grid-cols-3 grid-cols-1  gap-4">
            <?php 
                foreach ($calculators as $value) {
                    $value = (array)$value;
                    $cal_title = $value['cal_title'];
                    $cal_link = $value['cal_link'];
                    $cal_detail = $value['cal_detail'];
                    $link = explode('/', $cal_link);
                        $category = ucwords(str_replace('-', ' ', $category));
                        $category = str_replace(' ', '-', $category);
                        $isHealthCategory = $value['cal_cat'] == $category;
                    $isIndex = $value['no_index'] != 1;
                    $isLangKeySet = isset($lang_key);
                    if ($isHealthCategory && $isIndex && (($isLangKeySet && $lang_key == $link[0]) || (!$isLangKeySet && count($link) == 1))) {
                ?>
            <li class="calculator-item pl-1" data-title="{{ strtolower($cal_title) }}">
                <a href="{{ url($cal_link) }}/"
                    class="py-1 text-[18px] rounded-[12px] block hover:underline hover:text-black">
                    {{ $cal_title }}
                </a>
            </li>
            <?php  } } ?>
        </ul>
    </div>
@push('calculatorJS')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('calculator-search');
        const countDisplay = document.getElementById('calculator-count');
        
        // Function to update the count
        function updateCount() {
            const items = document.querySelectorAll('.calculator-item');
            const visibleItems = Array.from(items).filter(item => !item.classList.contains('hidden'));
            const count = visibleItems.length;
            const totalCount = items.length;
            
            if (countDisplay) {
                countDisplay.textContent = `${count} tool${count !== 1 ? 's' : ''} found`;
            }
        }
        
        // Initial count
        updateCount();
        
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                const items = document.querySelectorAll('.calculator-item');
                
                items.forEach(item => {
                    const title = item.getAttribute('data-title');
                if (title.includes(searchTerm)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
                });
                
                // Update count after filtering
                updateCount();
            });
        }
    });
</script>
@endpush
@endsection

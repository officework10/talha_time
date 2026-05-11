<style>
    .border-bb {
        border: 1px solid #D2D4D8;
    }

    .autosearch-activeclass {
        background-color: #1670a712;
    }

    .search_bars_div {
        border: 1px solid #D2D4D8 !important;
    }
</style>
{{-- search modal ============================================== --}}
<div class="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden " style="z-index:999999;">
    <!-- Modal Content -->
    <div class=" rounded-lg p-6 max-w-[45rem] w-full animate-fadeIn absolute lg:top-[120px] md:top-[120px] top-[110px]"
        style="background:transparent;">
        <!-- Close Button -->
        <button style="background-color: white;border-radius:20px;"
            class="close-modal absolute top-3 right-1 text-gray-500 hover:text-black focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <!-- Search Bar -->
        <div class="flex items-center bg-gray-100 p-1 rounded-lg search_bars_div relative"
            style="margin-bottom: -15px;">
            <input id="search-bar" name="search-bar" type="text" style="border: none !important;"
                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-4 pr-10 py-3 transition-all duration-300 ease-in-out hover:shadow-lg hover:bg-white"
                placeholder="Search Calculators..." value="" onfocus="document.onkeydown=null;">
            <img src="{{ asset('assets/images/svgs/search.svg') }}"
                class="absolute top-5 right-3 cursor-pointer searchsvgmodal" alt="search" title="search">
        </div>
        <ul id="suggestions"
            class="my-4 space-y-3 max-h-64 overflow-y-auto text-start bg-[#ffffff]  rounded-lg shadow-inner margin_two">
        </ul>
    </div>
</div>

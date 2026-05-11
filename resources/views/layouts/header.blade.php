<div class="container-fluid mx-auto container-fluid border-b-2 border-gray-200">
    <nav class="bg-white w-full mx-auto">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 relative">
            
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-3 rtl:space-x-revers">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('logo.png') }}" 
                         loading="lazy" 
                         title="Technical Calculators" 
                         alt="Technical Calculator" 
                         width="50"
                         height="50"
                         class="w-[50px] md:w-[50px] lg:w-[50px]">
                    <div class="flex flex-col leading-tight">
                        <div class="text-[20px] md:text-[25px] font-bold mb-1 text-gray-800">Time</div>
                        <div class="text-[16px] md:text-[20px] font-bold text-gray-700 -mt-1">Calculator</div>
                    </div>
                </div>
            </a>

            <!-- Navigation Menu (Desktop) -->
            <div class="items-center justify-between hidden w-full lg:flex md:w-auto menuheader relative" 
                 id="navbar-sticky">
                <ul class="flex items-center space-x-2 relative px-3 py-1 rounded-full">
                    
                    <!-- Home -->
                    <li class="rounded-full px-6 py-3 hover:underline flex items-center {{ request()->is(app()->getLocale() == 'en' ? '/' : app()->getLocale()) ? 'bg-[#000] text-white' : 'hover:bg-[#56BE30] hover:text-white' }}">
                        <a href="{{ app()->getLocale() == 'en' ? '/' : '/'.app()->getLocale().'/' }}" class="flex items-center">
                            <svg width="16" height="17" class="mr-1" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" 
                                      clip-rule="evenodd" 
                                      d="M9.45488 2.70134C8.59512 1.99878 7.40488 1.99878 6.5452 2.70134L2.23631 6.2225C1.8434 6.54359 1.6 7.05088 1.6 7.60358V13.0947C1.6 14.0969 2.36171 14.8256 3.2 14.8256H4.8V12.2541C4.8 10.471 6.18732 8.94176 8 8.94176C9.81272 8.94176 11.2 10.471 11.2 12.2541V14.8256H12.8C13.6383 14.8256 14.4 14.0969 14.4 13.0947V7.60358C14.4 7.05088 14.1566 6.54359 13.7637 6.22251L9.45488 2.70134ZM10.4744 1.48257L14.7832 5.00374C15.5595 5.63814 16 6.59999 16 7.60358V13.0947C16 14.8778 14.6127 16.407 12.8 16.407H11.2C10.3163 16.407 9.6 15.699 9.6 14.8256V12.2541C9.6 11.2519 8.83832 10.5232 8 10.5232C7.16168 10.5232 6.4 11.2519 6.4 12.2541V14.8256C6.4 15.699 5.68366 16.407 4.8 16.407H3.2C1.38732 16.407 0 14.8778 0 13.0947V7.60358C0 6.59999 0.440472 5.63814 1.21678 5.00374L5.52562 1.48257C6.97704 0.2965 9.02296 0.2965 10.4744 1.48257Z" 
                                      fill="currentColor">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>

                    <!-- Tools -->
                    <li class="rounded-full px-6 py-3 hover:underline flex items-center {{ request()->is('timedate') || request()->is('*/timedate') ? 'bg-[#000] text-white' : 'hover:bg-[#56BE30] hover:text-white' }}">
                      <a href="{{ app()->getLocale() == 'en' ? '/timedate/' : '/'.app()->getLocale().'/timedate/' }}"  class="flex items-center">
                            <svg fill="currentColor" width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <title>tools</title>
                                <path d="M27.783 7.936c0.959 2.313 0.502 5.074-1.379 6.955-2.071 2.071-5.201 2.395-7.634 1.022l-1.759 1.921 1.255 1.26 0.75-0.75c0.383-0.384 1.005-0.384 1.388 0l6.082 6.144c0.384 0.383 0.384 1.005 0 1.388l-2.776 2.776c-0.383 0.384-1.005 0.384-1.388 0l-6.082-6.144c-0.384-0.383-0.384-1.005 0-1.388l0.685-0.685-1.196-1.199-8.411 9.189c-0.767 0.767-2.010 0.767-2.776 0l-0.694-0.694c-0.767-0.767-0.767-2.010 0-2.776l9.582-8.025-6.364-6.381-2.010-0.001-2.326-3.74 1.872-1.875 3.825 2.341 0.025 1.968 6.438 6.463 1.873-1.568c-1.831-2.496-1.64-6.012 0.616-8.268 1.872-1.872 4.618-2.337 6.925-1.396l-4.124 4.067 3.471 3.471 4.132-4.075zM6.15 25.934c-0.383-0.383-1.004-0.383-1.388 0-0.384 0.384-0.384 1.005 0 1.389 0.384 0.383 1.005 0.383 1.388 0 0.384-0.385 0.384-1.006 0-1.389z">
                                </path>
                            </svg>
                            All Calculators
                        </a>
                    </li>

                    <!-- Contact Us -->
                    <li class="rounded-full px-6 py-3 hover:underline flex items-center {{ request()->is('contact-us') || request()->is('*/contact-us') ? 'bg-[#000] text-white' : 'hover:bg-[#56BE30] hover:text-white' }}">
                        <a class="flex items-center" href="{{ app()->getLocale() == 'en' ? '/contact-us/' : '/'.app()->getLocale().'/contact-us/' }}" data-discover="true">
                            <svg width="20" height="21" class="mx-1 svg-path transition-all" viewBox="0 0 20 21" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" 
                                      clip-rule="evenodd" 
                                      d="M16.8715 1.74219C17.3685 1.74219 17.8455 1.93988 18.1971 2.2915C18.5487 2.64282 18.7462 3.11987 18.7462 3.6169V6.11642C18.7462 7.15188 17.9068 7.99113 16.8715 7.99113H16.3118L15.7907 8.98312C15.5748 9.39408 15.1488 9.6517 14.6843 9.6517C14.2198 9.6517 13.7939 9.39408 13.5779 8.98312L13.0568 7.99113H12.4972C11.4619 7.99113 10.6225 7.15188 10.6225 6.11642V3.6169C10.6225 3.11987 10.82 2.64282 11.1716 2.2915C11.5232 1.93988 12.0001 1.74219 12.4972 1.74219H16.8715ZM14.6843 8.40179L15.381 7.07581C15.4888 6.87018 15.7019 6.74152 15.934 6.74152H16.8715C17.2165 6.74152 17.4962 6.46157 17.4962 6.11642V3.6169C17.4962 3.45122 17.4304 3.2923 17.3133 3.1751C17.1962 3.05789 17.0373 2.99209 16.8715 2.99209H12.4972C12.3314 2.99209 12.1725 3.05789 12.0554 3.1751C11.9383 3.2923 11.8724 3.45122 11.8724 3.6169V6.11642C11.8724 6.46157 12.1522 6.74152 12.4972 6.74152H13.4346C13.6668 6.74152 13.8798 6.87018 13.9877 7.07581L14.6843 8.40179ZM13.7471 5.49161C13.4021 5.49161 13.1221 5.21167 13.1221 4.8668C13.1221 4.52194 13.4021 4.242 13.7471 4.242H15.6215C15.9666 4.242 16.2465 4.52194 16.2465 4.8668C16.2465 5.21167 15.9666 5.49161 15.6215 5.49161H13.7471ZM11.2995 11.8202C11.6512 11.4685 12.1281 11.2711 12.6251 11.2711C13.1224 11.2711 13.5993 11.4685 13.9507 11.8202L16.1601 14.0295C16.5117 14.3811 16.7092 14.8578 16.7092 15.3551C16.7092 15.8522 16.5117 16.3289 16.1601 16.6805L14.6389 18.2019C13.4754 19.366 11.6628 19.5743 10.2653 18.7048C10.2627 18.703 10.26 18.7013 10.2574 18.6995C6.81231 16.4826 3.98588 13.6535 1.78495 10.1987C1.7839 10.1969 1.78284 10.1951 1.78152 10.1934C0.91754 8.8057 1.1219 7.00618 2.27114 5.85175C2.77821 5.3183 3.33789 4.75841 3.78812 4.30839C4.13948 3.95677 4.61641 3.75937 5.1137 3.75937C5.61072 3.75937 6.08766 3.95677 6.43928 4.30839L8.64839 6.51768C9.00001 6.8693 9.1975 7.34605 9.1975 7.84337C9.1975 8.34069 9.00001 8.81745 8.64839 9.16907L7.89122 9.92606C7.70431 10.1129 7.6554 10.3969 7.77173 10.6425C8.2513 11.5361 8.93524 12.215 9.83993 12.6732C10.0705 12.7854 10.3467 12.7393 10.5281 12.5578C10.5389 12.5469 10.55 12.5366 10.5617 12.5266C10.798 12.3228 11.0563 12.0634 11.2995 11.8202ZM12.1834 12.7038C11.9237 12.9634 11.6472 13.239 11.396 13.4572C10.8358 14.0042 9.99063 14.1399 9.28633 13.7936C9.28448 13.7927 9.28236 13.7918 9.28025 13.7906C8.13154 13.2102 7.2636 12.3489 6.65871 11.2112C6.65554 11.2053 6.65236 11.1992 6.64945 11.193C6.29678 10.473 6.44086 9.60852 7.00795 9.04217L7.76485 8.28518C7.88197 8.16797 7.9478 8.00905 7.9478 7.84337C7.9478 7.6777 7.88197 7.51878 7.76485 7.40157L5.55547 5.19228C5.43835 5.07507 5.2792 5.00927 5.1137 5.00927C4.94794 5.00927 4.78905 5.07507 4.67166 5.19228C4.22778 5.63614 3.6755 6.18809 3.1753 6.71449C3.17186 6.71831 3.16816 6.72213 3.16446 6.72595C2.41813 7.47207 2.28436 8.63415 2.84113 9.53038C4.94265 12.828 7.64086 15.5288 10.9292 17.6458C11.8325 18.206 13.0032 18.0703 13.7551 17.3183L15.2763 15.7969C15.3937 15.6797 15.4595 15.5208 15.4595 15.3551C15.4595 15.1892 15.3937 15.0303 15.2763 14.9131L13.0672 12.7038C12.95 12.5866 12.7909 12.5208 12.6251 12.5208C12.4596 12.5208 12.3005 12.5866 12.1834 12.7038Z" 
                                      fill="currentColor">
                                </path>
                            </svg>
                            CONTACT US
                        </a>
                    </li>

                    <!-- Blog -->
                    <li class="rounded-full px-6 py-3 hover:underline flex items-center {{ request()->is('blog') || request()->is('*/blog') || request()->is('blog/*') || request()->is('*/blog/*') ? 'bg-[#000] text-white' : 'hover:bg-[#56BE30] hover:text-white' }}">
                        <a class="flex items-center" href="/blog/" data-discover="true">
                            <svg width="20" height="21" class="svg-path mx-1" viewBox="0 0 20 21" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.90625 13.1275H6.25C6.68148 13.1275 7.03125 12.7778 7.03125 12.3463C7.03125 11.9148 6.68148 11.565 6.25 11.565H3.90625C3.47477 11.565 3.125 11.9148 3.125 12.3463C3.125 12.7778 3.47477 13.1275 3.90625 13.1275Z" fill="currentColor"></path>
                                <path d="M3.90625 10.0025H6.25C6.68148 10.0025 7.03125 9.65277 7.03125 9.22128C7.03125 8.7898 6.68148 8.44003 6.25 8.44003H3.90625C3.47477 8.44003 3.125 8.7898 3.125 9.22128C3.125 9.65277 3.47477 10.0025 3.90625 10.0025Z" fill="currentColor"></path>
                                <path d="M8.49377 12.3463C8.49377 12.7778 8.84354 13.1275 9.27502 13.1275C10.9087 13.1275 12.4445 12.4914 13.5997 11.3362L19.313 5.62238C20.2289 4.70648 20.229 3.22386 19.313 2.30781C18.3992 1.39398 16.9123 1.39398 15.9984 2.30781L10.2851 8.02164C9.12999 9.17683 8.49377 10.7127 8.49377 12.3463ZM17.1033 3.41269C17.4078 3.10808 17.9035 3.10808 18.2081 3.41269C18.5134 3.71792 18.5135 4.21218 18.2081 4.51753L12.4948 10.2314C11.8417 10.8845 11.0251 11.3148 10.1373 11.484C10.3065 10.5962 10.7369 9.77964 11.3899 9.12652L17.1033 3.41269Z" fill="currentColor"></path>
                                <path d="M2.34375 19.3775C2.92094 19.3775 3.4757 19.1657 3.90594 18.781L4.9859 17.815H12.9688C15.1227 17.815 16.875 16.0627 16.875 13.9088V12.1563C16.875 11.7248 16.5252 11.3751 16.0938 11.3751C15.6623 11.3751 15.3125 11.7248 15.3125 12.1563V13.9088C15.3125 15.2011 14.2611 16.2525 12.9688 16.2525H4.6875C4.49531 16.2525 4.30988 16.3234 4.16664 16.4515L2.86438 17.6164C2.72105 17.7445 2.53617 17.815 2.34375 17.815C1.91297 17.815 1.5625 17.4646 1.5625 17.0338V7.65878C1.5625 6.36644 2.61391 5.31503 3.90625 5.31503H10.4589C10.8904 5.31503 11.2402 4.96527 11.2402 4.53378C11.2402 4.1023 10.8904 3.75253 10.4589 3.75253H3.90625C1.7523 3.75253 0 5.50488 0 7.65878V17.0338C0 18.3261 1.05141 19.3775 2.34375 19.3775Z" fill="currentColor"></path>
                            </svg>
                            BLOG
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Right Side Actions -->
            <div class="flex space-x-1 md:space-x-0 rtl:space-x-reverse">
                
                <!-- Search Button -->
                <button onclick="openSearchModal()" class="bg-black text-white p-3 m-0 rounded-full cursor-pointer hover:bg-gray-800 transition-colors" aria-label="Search">
                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" 
                              clip-rule="evenodd" 
                              d="M14.9 7.70001C14.9 4.60721 12.3928 2.1 9.29999 2.1C6.20719 2.1 3.69998 4.60721 3.69998 7.70001C3.69998 10.7928 6.20719 13.3 9.29999 13.3C12.3928 13.3 14.9 10.7928 14.9 7.70001ZM9.29999 0.5C13.2764 0.5 16.5 3.72356 16.5 7.70001C16.5 11.6765 13.2764 14.9 9.29999 14.9C7.59999 14.9 6.03759 14.3108 4.80583 13.3255L1.86566 16.2657C1.55326 16.5781 1.0467 16.5781 0.734301 16.2657C0.4219 15.9533 0.4219 15.4467 0.734301 15.1343L3.67446 12.1942C2.68918 10.9624 2.09998 9.40001 2.09998 7.70001C2.09998 3.72356 5.32351 0.5 9.29999 0.5Z" 
                              class="" 
                              fill="#E8FFF1">
                        </path>
                    </svg>
                </button>

                   <!-- Mobile Menu Button -->
                    <div class="relative mx-3">
                        <button type="button" 
                                data-drawer-target="drawer-navigation"
                                data-drawer-toggle="drawer-navigation"
                                data-drawer-placement="left"
                                aria-controls="drawer-navigation"
                                class="inline-flex items-center transition duration-500 p-2 justify-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100" 
                                aria-expanded="false" 
                                aria-label="Toggle navigation menu" 
                                style="box-shadow: none; outline: none; background: rgb(86, 190, 48);">
                            <svg class="w-[26px] h-[26px] text-white" 
                                aria-hidden="true" 
                                xmlns="http://www.w3.org/2000/svg" 
                                width="24" 
                                height="24" 
                                fill="none" 
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" 
                                    stroke-linecap="round" 
                                    stroke-width="1.8" 
                                    d="M5 7h14M5 12h14M5 17h10">
                                </path>
                            </svg>
                        </button>
                    </div>

                @php
                    $switcherActions = [
                        'HomeController@index',
                        'HomeController@about',
                        'HomeController@policy',
                        'HomeController@contact',
                        'HomeController@feedback_email',
                        'HomeController@editorial_Policies',
                        'HomeController@terms',
                        'HomeController@disclaimer',
                    ];
                    $currentAction = request()->route() ? request()->route()->getActionName() : '';
                    $showHomeLanguages = false;
                    foreach ($switcherActions as $action) {
                        if (str_contains($currentAction, $action)) {
                            $showHomeLanguages = true;
                            break;
                        }
                    }
                @endphp

                 <!-- Removed Language Switcher -->


                <!-- User Dropdown (Desktop) -->
                <div class="items-center space-x-3 md:space-x-0 rtl:space-x-reverse hidden md:flex">
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm" 
                         id="user-dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white">User Name</span>
                            <span class="block text-sm text-gray-500 truncate dark:text-gray-400">Email</span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                <a href="/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            </li>
                            <li>
                                <a href="/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>

                   
                </div>


        </div>
    </nav>
</div>


<!-- Mobile Drawer Navigation -->
<div id="drawer-navigation" 
     class="fixed top-0 left-0 z-[99999] h-screen overflow-y-auto transition-transform -translate-x-full bg-white w-64" 
     tabindex="-1" 
     aria-labelledby="drawer-navigation-label" 
     aria-modal="true" 
     role="dialog">
    
    <span class="sr-only" id="drawer-navigation-label">Pages</span>
    <!-- Logo -->
    <a class="flex items-center space-x-3 rtl:space-x-revers p-4" href="/" data-discover="true">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('logo.png') }}" 
                 loading="lazy" 
                 title="Technical Calculators" 
                 alt="Technical Calculator" 
                 width="50"
                 height="50"
                 class="w-[50px] md:w-[50px] lg:w-[50px]">
            <div class="flex flex-col leading-tight">
                <div class="text-[20px] md:text-[25px] font-bold mb-1 text-gray-800">Time</div>
                <div class="text-[16px] md:text-[20px] font-bold text-gray-700 -mt-1">Calculator</div>
            </div>
        </div>
    </a>

    <!-- Close Button -->
    <button type="button" 
            data-drawer-hide="drawer-navigation" 
            aria-controls="drawer-navigation" 
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center">
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>

    <!-- Menu Items -->
    <div class="py-4 overflow-y-auto menuheader">
        <p class="bg-[#56BE30] text-white font-bold py-3 px-2">Pages</p>
        <ul class="space-y-2 font-medium mt-2">
            
            <!-- Home -->
            <li class="rounded-[15px] px-3 py-3 flex items-center {{ request()->is(app()->getLocale() == 'en' ? '/' : app()->getLocale()) ? 'bg-[#56BE30] text-white' : '' }}">
                <a class="flex items-center hover:underline hover:text-black" href="{{ app()->getLocale() == 'en' ? '/' : '/'.app()->getLocale().'/' }}" data-discover="true">
                    <svg width="16" height="17" class="mr-1" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" 
                              clip-rule="evenodd" 
                              d="M9.45488 2.70134C8.59512 1.99878 7.40488 1.99878 6.5452 2.70134L2.23631 6.2225C1.8434 6.54359 1.6 7.05088 1.6 7.60358V13.0947C1.6 14.0969 2.36171 14.8256 3.2 14.8256H4.8V12.2541C4.8 10.471 6.18732 8.94176 8 8.94176C9.81272 8.94176 11.2 10.471 11.2 12.2541V14.8256H12.8C13.6383 14.8256 14.4 14.0969 14.4 13.0947V7.60358C14.4 7.05088 14.1566 6.54359 13.7637 6.22251L9.45488 2.70134ZM10.4744 1.48257L14.7832 5.00374C15.5595 5.63814 16 6.59999 16 7.60358V13.0947C16 14.8778 14.6127 16.407 12.8 16.407H11.2C10.3163 16.407 9.6 15.699 9.6 14.8256V12.2541C9.6 11.2519 8.83832 10.5232 8 10.5232C7.16168 10.5232 6.4 11.2519 6.4 12.2541V14.8256C6.4 15.699 5.68366 16.407 4.8 16.407H3.2C1.38732 16.407 0 14.8778 0 13.0947V7.60358C0 6.59999 0.440472 5.63814 1.21678 5.00374L5.52562 1.48257C6.97704 0.2965 9.02296 0.2965 10.4744 1.48257Z" 
                              fill="currentColor">
                        </path>
                    </svg>
                    Home
                </a>
            </li>

            <!-- Blog -->
            <li class="rounded-[15px] px-3 py-2 {{ request()->is('blog') || request()->is('*/blog') || request()->is('blog/*') || request()->is('*/blog/*') ? 'bg-[#56BE30] text-white' : '' }}">
                <a class="flex hover:underline hover:text-black" href="{{ app()->getLocale() == 'en' ? '/blog/' : '/'.app()->getLocale().'/blog/' }}" data-discover="true">
                    <svg width="20" height="21" class="svg-path mx-1" viewBox="0 0 20 21" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.90625 13.1275H6.25C6.68148 13.1275 7.03125 12.7778 7.03125 12.3463C7.03125 11.9148 6.68148 11.565 6.25 11.565H3.90625C3.47477 11.565 3.125 11.9148 3.125 12.3463C3.125 12.7778 3.47477 13.1275 3.90625 13.1275Z" fill="currentColor"></path>
                        <path d="M3.90625 10.0025H6.25C6.68148 10.0025 7.03125 9.65277 7.03125 9.22128C7.03125 8.7898 6.68148 8.44003 6.25 8.44003H3.90625C3.47477 8.44003 3.125 8.7898 3.125 9.22128C3.125 9.65277 3.47477 10.0025 3.90625 10.0025Z" fill="currentColor"></path>
                        <path d="M8.49377 12.3463C8.49377 12.7778 8.84354 13.1275 9.27502 13.1275C10.9087 13.1275 12.4445 12.4914 13.5997 11.3362L19.313 5.62238C20.2289 4.70648 20.229 3.22386 19.313 2.30781C18.3992 1.39398 16.9123 1.39398 15.9984 2.30781L10.2851 8.02164C9.12999 9.17683 8.49377 10.7127 8.49377 12.3463ZM17.1033 3.41269C17.4078 3.10808 17.9035 3.10808 18.2081 3.41269C18.5134 3.71792 18.5135 4.21218 18.2081 4.51753L12.4948 10.2314C11.8417 10.8845 11.0251 11.3148 10.1373 11.484C10.3065 10.5962 10.7369 9.77964 11.3899 9.12652L17.1033 3.41269Z" fill="currentColor"></path>
                        <path d="M2.34375 19.3775C2.92094 19.3775 3.4757 19.1657 3.90594 18.781L4.9859 17.815H12.9688C15.1227 17.815 16.875 16.0627 16.875 13.9088V12.1563C16.875 11.7248 16.5252 11.3751 16.0938 11.3751C15.6623 11.3751 15.3125 11.7248 15.3125 12.1563V13.9088C15.3125 15.2011 14.2611 16.2525 12.9688 16.2525H4.6875C4.49531 16.2525 4.30988 16.3234 4.16664 16.4515L2.86438 17.6164C2.72105 17.7445 2.53617 17.815 2.34375 17.815C1.91297 17.815 1.5625 17.4646 1.5625 17.0338V7.65878C1.5625 6.36644 2.61391 5.31503 3.90625 5.31503H10.4589C10.8904 5.31503 11.2402 4.96527 11.2402 4.53378C11.2402 4.1023 10.8904 3.75253 10.4589 3.75253H3.90625C1.7523 3.75253 0 5.50488 0 7.65878V17.0338C0 18.3261 1.05141 19.3775 2.34375 19.3775Z" fill="currentColor"></path>
                    </svg>
                    BLOG
                </a>
            </li>

            <!-- Contact Us -->
            <li class="rounded-[15px] px-3 py-2 {{ request()->is('contact-us') || request()->is('*/contact-us') ? 'bg-[#56BE30] text-white' : '' }}">
                <a class="flex items-center hover:underline hover:text-black" href="{{ app()->getLocale() == 'en' ? '/contact-us/' : '/'.app()->getLocale().'/contact-us/' }}" data-discover="true">
                    <svg width="20" height="21" class="mx-1 svg-path transition-all" viewBox="0 0 20 21" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" 
                              clip-rule="evenodd" 
                              d="M16.8715 1.74219C17.3685 1.74219 17.8455 1.93988 18.1971 2.2915C18.5487 2.64282 18.7462 3.11987 18.7462 3.6169V6.11642C18.7462 7.15188 17.9068 7.99113 16.8715 7.99113H16.3118L15.7907 8.98312C15.5748 9.39408 15.1488 9.6517 14.6843 9.6517C14.2198 9.6517 13.7939 9.39408 13.5779 8.98312L13.0568 7.99113H12.4972C11.4619 7.99113 10.6225 7.15188 10.6225 6.11642V3.6169C10.6225 3.11987 10.82 2.64282 11.1716 2.2915C11.5232 1.93988 12.0001 1.74219 12.4972 1.74219H16.8715ZM14.6843 8.40179L15.381 7.07581C15.4888 6.87018 15.7019 6.74152 15.934 6.74152H16.8715C17.2165 6.74152 17.4962 6.46157 17.4962 6.11642V3.6169C17.4962 3.45122 17.4304 3.2923 17.3133 3.1751C17.1962 3.05789 17.0373 2.99209 16.8715 2.99209H12.4972C12.3314 2.99209 12.1725 3.05789 12.0554 3.1751C11.9383 3.2923 11.8724 3.45122 11.8724 3.6169V6.11642C11.8724 6.46157 12.1522 6.74152 12.4972 6.74152H13.4346C13.6668 6.74152 13.8798 6.87018 13.9877 7.07581L14.6843 8.40179ZM13.7471 5.49161C13.4021 5.49161 13.1221 5.21167 13.1221 4.8668C13.1221 4.52194 13.4021 4.242 13.7471 4.242H15.6215C15.9666 4.242 16.2465 4.52194 16.2465 4.8668C16.2465 5.21167 15.9666 5.49161 15.6215 5.49161H13.7471ZM11.2995 11.8202C11.6512 11.4685 12.1281 11.2711 12.6251 11.2711C13.1224 11.2711 13.5993 11.4685 13.9507 11.8202L16.1601 14.0295C16.5117 14.3811 16.7092 14.8578 16.7092 15.3551C16.7092 15.8522 16.5117 16.3289 16.1601 16.6805L14.6389 18.2019C13.4754 19.366 11.6628 19.5743 10.2653 18.7048C10.2627 18.703 10.26 18.7013 10.2574 18.6995C6.81231 16.4826 3.98588 13.6535 1.78495 10.1987C1.7839 10.1969 1.78284 10.1951 1.78152 10.1934C0.91754 8.8057 1.1219 7.00618 2.27114 5.85175C2.77821 5.3183 3.33789 4.75841 3.78812 4.30839C4.13948 3.95677 4.61641 3.75937 5.1137 3.75937C5.61072 3.75937 6.08766 3.95677 6.43928 4.30839L8.64839 6.51768C9.00001 6.8693 9.1975 7.34605 9.1975 7.84337C9.1975 8.34069 9.00001 8.81745 8.64839 9.16907L7.89122 9.92606C7.70431 10.1129 7.6554 10.3969 7.77173 10.6425C8.2513 11.5361 8.93524 12.215 9.83993 12.6732C10.0705 12.7854 10.3467 12.7393 10.5281 12.5578C10.5389 12.5469 10.55 12.5366 10.5617 12.5266C10.798 12.3228 11.0563 12.0634 11.2995 11.8202ZM12.1834 12.7038C11.9237 12.9634 11.6472 13.239 11.396 13.4572C10.8358 14.0042 9.99063 14.1399 9.28633 13.7936C9.28448 13.7927 9.28236 13.7918 9.28025 13.7906C8.13154 13.2102 7.2636 12.3489 6.65871 11.2112C6.65554 11.2053 6.65236 11.1992 6.64945 11.193C6.29678 10.473 6.44086 9.60852 7.00795 9.04217L7.76485 8.28518C7.88197 8.16797 7.9478 8.00905 7.9478 7.84337C7.9478 7.6777 7.88197 7.51878 7.76485 7.40157L5.55547 5.19228C5.43835 5.07507 5.2792 5.00927 5.1137 5.00927C4.94794 5.00927 4.78905 5.07507 4.67166 5.19228C4.22778 5.63614 3.6755 6.18809 3.1753 6.71449C3.17186 6.71831 3.16816 6.72213 3.16446 6.72595C2.41813 7.47207 2.28436 8.63415 2.84113 9.53038C4.94265 12.828 7.64086 15.5288 10.9292 17.6458C11.8325 18.206 13.0032 18.0703 13.7551 17.3183L15.2763 15.7969C15.3937 15.6797 15.4595 15.5208 15.4595 15.3551C15.4595 15.1892 15.3937 15.0303 15.2763 14.9131L13.0672 12.7038C12.95 12.5866 12.7909 12.5208 12.6251 12.5208C12.4596 12.5208 12.3005 12.5866 12.1834 12.7038Z" 
                              fill="currentColor">
                        </path>
                    </svg>
                    CONTACT US
                </a>
            </li>

            <!-- Privacy Policy -->
            <li class="rounded-[15px] px-3 py-3 {{ request()->is('privacy-policy') || request()->is('*/privacy-policy') ? 'bg-[#56BE30] text-white' : '' }}">
                <a class="flex items-center hover:underline hover:text-black" href="{{ app()->getLocale() == 'en' ? '/privacy-policy/' : '/'.app()->getLocale().'/privacy-policy/' }}" data-discover="true">
                    <svg fill="#000000" width="21px" height="21px" class="mr-1 svg-path" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.406,5.086l-9-4a1,1,0,0,0-.812,0l-9,4A1,1,0,0,0,2,6v.7a18.507,18.507,0,0,0,9.515,16.17,1,1,0,0,0,.97,0A18.507,18.507,0,0,0,22,6.7V6A1,1,0,0,0,21.406,5.086ZM20,6.7a16.507,16.507,0,0,1-8,14.141A16.507,16.507,0,0,1,4,6.7V6.65l8-3.556L20,6.65ZM11,10h2v8H11Zm0-4h2V8H11Z"></path>
                    </svg>
                    Privacy Policy
                </a>
            </li>

            <!-- About Us -->
            <li class="rounded-[15px] px-3 py-3 {{ request()->is('about-us') || request()->is('*/about-us') ? 'bg-[#56BE30] text-white' : '' }}">
                <a class="flex items-center hover:underline hover:text-black" href="{{ app()->getLocale() == 'en' ? '/about-us/' : '/'.app()->getLocale().'/about-us/' }}" data-discover="true">
                    <svg width="21px" height="21px" class="mr-2 svg-path" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>about</title>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="about-white" class="svg-path" fill="#000000" transform="translate(42.666667, 42.666667)">
                                <path d="M213.333333,3.55271368e-14 C95.51296,3.55271368e-14 3.55271368e-14,95.51168 3.55271368e-14,213.333333 C3.55271368e-14,331.153707 95.51296,426.666667 213.333333,426.666667 C331.154987,426.666667 426.666667,331.153707 426.666667,213.333333 C426.666667,95.51168 331.154987,3.55271368e-14 213.333333,3.55271368e-14 Z M213.333333,384 C119.227947,384 42.6666667,307.43872 42.6666667,213.333333 C42.6666667,119.227947 119.227947,42.6666667 213.333333,42.6666667 C307.44,42.6666667 384,119.227947 384,213.333333 C384,307.43872 307.44,384 213.333333,384 Z M240.04672,128 C240.04672,143.46752 228.785067,154.666667 213.55008,154.666667 C197.698773,154.666667 186.713387,143.46752 186.713387,127.704107 C186.713387,112.5536 197.99616,101.333333 213.55008,101.333333 C228.785067,101.333333 240.04672,112.5536 240.04672,128 Z M192.04672,192 L234.713387,192 L234.713387,320 L192.04672,320 L192.04672,192 Z"></path>
                            </g>
                        </g>
                    </svg>
                    About Us
                </a>
            </li>

        </ul>
    </div>
</div>

<!-- Search Modal -->
<div id="searchModal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-[9999] flex items-start justify-center pt-20 px-4" role="dialog" aria-modal="true" aria-labelledby="search-modal-title">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden">
        <h2 id="search-modal-title" class="sr-only">Search Calculators</h2>
        @livewire('search.search-two')
    </div>
</div>

<script>
    function openSearchModal() {
        document.getElementById('searchModal').classList.remove('hidden');
        setTimeout(() => {
            const searchInput = document.querySelector('#searchModal input[type="text"]');
            if (searchInput) {
                searchInput.focus();
            }
        }, 100);
    }

    function closeSearchModal() {
        document.getElementById('searchModal').classList.add('hidden');
        if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('closeSearchModal');
        }
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('searchModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeSearchModal();
            }
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('searchModal');
        if (e.target === modal) {
            closeSearchModal();
        }
    });
</script>

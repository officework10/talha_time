@extends('layouts.app')
@section('content')
    <div class="flex justify-center items-center relative"
        style="background-image: url('{{ asset('assets/images/auth-bg-img.png') }}');background-size: cover;background-position: center;">
        <!-- The backdrop overlay -->
        <div class="absolute inset-0 bg-[#1A1A1A] opacity-70 z-0"></div>
        <!-- Your content here -->
        <div class="z-10 flex 2xl:w-[65%] xl:w-[70%] lg:w-[75%] my-10 w-[90%] bg-white rounded-[25px]">
            <div class="lg:w-[50%] flex  lg:rounded-[0px] rounded-[25px] w-[100%] 2xl:my-10 xl:my-7 lg:my-4 2xl:py-[20px] xl:py-[15px] lg:py-[8px] py-7 2xl:px-[50px] xl:px-[40px] lg:px-[35px] px-6"
                style="background-image: url('{{ asset('images/login-bg-img.png') }}');background-size: cover;">
                <div class="w-full">

                    <a href="{{ url('/') }}"
                        class="flex my-3 items-center text-left  space-x-3 rtl:space-x-reverse mr-auto">
                        <img src="{{ asset('assets/images/logo.png') }}" class="h-8" alt="Header-Logo"
                            title="Header-Logo" />
                        <div class="lg:pl-1 md:pl-1 text-center">
                            <span class="self-center lg:text-[19px] text-[14px] font-semibold whitespace-nowrap">Calculator
                            </span>
                            <p class="self-center lg:text-[15px] text-[12px] font-semibold whitespace-nowrap ">Online</p>
                        </div>
                    </a>
                    <h1
                        class="2xl:text-[30px] text-center lg:text-[24px] lg:pt-10 md:pt-10 pt-3 text-[21px] font-[700] leading-[15.17px] text-black">
                        Forgotten Password
                    </h1>
                    <div class="flex justify-center 2xl:my-8 xl:my-6 my-6">
                        <p
                            class="2xl:text-[16px] xl:text-[14px] font-[600] lg:text-[12px] text-center text-opacity-80 text-black xl:leading-[20.83px] lg:leading-[16.83px]">
                            Enter your registered email address below to receive a verification link
                            for resetting your password.
                        </p>
                    </div>
                    @if (Session::has('message'))
                        <div class="alert text-[green] text-bold" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <form action="{{ route('forget.password.post') }}" method="POST">
                        @csrf
                        <div>
                            <label for="email_address"
                                class="block my-2 pl-5 xl:text-[14px] lg:text-[12px] text-[14px] font-medium text-[#A3A3A3] dark:text-white">Email
                                Address</label>
                            <input type="email" id="email_address" name="email"
                                class="bg-white border-[#F0F0F0] rounded-[36.5px] border-2 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full 2xl:p-5 xl:p-4 lg:p-3 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter your Email" required autofocus />
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif

                        </div>
                        <div class="flex justify-center xl:my-6 my-3">
                            <button type="submit"
                                class="bg-[#000] text-white 2xl:text-[18px] xl:text-[16px] text-[14px] rounded-[36.69px] w-full 2xl:py-5 xl:py-4 lg:py-3 py-3 font-[600]">
                                Get Verification Link
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            <div
                class="w-[50%] lg:block hidden bg-black rounded-[25px] 2xl:py-[63px] xl:py-[40px] lg:py-[35px] 2xl:px-[50px] xl:px-[40px] lg:px-[35px]">
                <div class="flex justify-center">
                    <div class="flex gap-x-4 items-center">
                        <div class="w-[13px] h-[13px] bg-[#21EE00] rounded-full"></div>
                        <div class="">
                            <h1 class="2xl:text-[30px] lg:text-[24px] font-[600] leading-[15.17px] text-white">
                                Sign In
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center 2xl:mt-[50px] xl:mt-[30px] lg:mt-[15px] 2xl:mb-10 xl:mb-7 lg:mb-5">
                    <img src="{{ asset('assets/images/auth-laptop.png') }}" alt="" />
                </div>
                <div class="flex justify-center">
                    <h1 class="2xl:text-[30px] lg:text-[24px] font-[600] leading-[15.17px] text-white">
                        Calculate Live
                    </h1>
                </div>
                <div class="flex justify-center 2xl:my-4 xl:my-3 my-3">
                    <p
                        class="2xl:text-[16px] xl:text-[14px] lg:text-[12px] text-center text-opacity-80 text-white xl:leading-[20.83px] lg:leading-[16.83px]">
                        Join our community and start calculating with ease!
                    </p>
                </div>
                <div class="flex justify-center my-10">
                    <a href="{{ url('login') }}"
                        class="bg-[#F7BB0D] text-center 2xl:text-[18px] xl:text-[16px] text-[14px] rounded-[36.69px] w-full 2xl:py-5 xl:py-4 lg:py-3 py-3 font-[600]">
                        Back to Sign In Page
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
<div class="flex justify-center items-center lg:h-auto md:h-auto h-[100vh] 2xl:h-[100vh] relative"
style="background-image: url('{{ asset('assets/images/auth-bg-img.png') }}'); background-size: cover;background-position: center;">
<!-- The backdrop overlay -->
<div class="absolute inset-0 bg-[#1A1A1A] opacity-70 z-0"></div>
<!-- Your content here -->  
<div
    class="z-10 flex 2xl:w-[65%] xl:w-[70%] lg:w-[75%] w-[90%] my-10 bg-white rounded-[25px]">
    <div class="lg:w-[50%] flex  lg:rounded-[0px] rounded-[25px] w-[100%] 2xl:my-10 xl:my-7 lg:my-4 2xl:py-[20px] xl:py-[15px] lg:py-[8px] py-7 2xl:px-[50px] xl:px-[40px] lg:px-[35px] px-6"
        style="background-image: url('{{ asset('assets/images/login-bg-img.png') }}');background-size: cover;">
        <div class="w-full">

            <a href="{{ url('/') }}" class="flex my-3 items-center text-left  space-x-3 rtl:space-x-reverse mr-auto">
                <img src="{{ asset('assets/images/logo.png') }}" class="h-8" alt="Header-Logo" title="Header-Logo" />
                <div class="lg:pl-1 md:pl-1 text-center">
                    <span class="self-center lg:text-[19px] text-[14px] font-semibold whitespace-nowrap">Calculator
                    </span>
                    <p class="self-center lg:text-[15px] text-[12px] font-semibold whitespace-nowrap ">Logical</p>
                </div>
            </a>

            <h1
                class="2xl:text-[30px] text-center lg:text-[24px] lg:pt-[80px] md:pt-[80px] pt-3 text-[21px] font-[700] leading-[15.17px] text-black">
                Email Confirmation
            </h1>
            <div class="flex justify-center 2xl:my-8 xl:my-6 my-6">
                <p
                    class="2xl:text-[16px] xl:text-[14px] lg:text-[12px] font-[600] text-center text-opacity-80 text-black xl:leading-[20.83px] lg:leading-[16.83px]">
                    We have sent you a verification link on your registered email address!
                </p>
            </div>
            <form class="" action="">
                <div class="flex justify-center xl:my-6 my-3">
                    <button onclick="openemailapp()"
                        class="bg-[#000] text-white 2xl:text-[18px] xl:text-[16px] text-[14px] rounded-[36.69px] w-full 2xl:py-5 xl:py-4 lg:py-3 py-3 font-[600]">
                        Open Email Application
                    </button>
                </div>
            </form>
          

            <div class="flex justify-center 2xl:my-5 xl:my-4 my-3">
                <p
                    class="2xl:text-[16px] text-[#1A1A1A] xl:text-[14px] font-[600] lg:text-[12px] text-center text-opacity-80 text-black xl:leading-[20.83px] lg:leading-[16.83px]">
                    Didn’t receive the email?
                    <span class="text-[#4177EB]"> <a href="{{ route('forget.password.get') }}" class="font-[600]">Click here to Resend</a> </span>
                </p>
            </div>
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
            <img 
                src="{{ asset('assets/images/auth-laptop.png') }}" alt="" />
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

<script>
    function openemailapp() {
        // Open Gmail inbox in a new tab
        window.open('https://mail.google.com/mail/u/0/#inbox', '_blank');
    }
</script>

@endsection
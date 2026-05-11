@extends('layouts.app')
@section('title', $meta_title)
@section('meta_des', $meta_des)

@section('content')

<div class="lg:max-w-[60%] md:max-w-[60%] max-w-[100%] mx-auto lg:mt-[60px] md:mt-[60px] mt-[40px] mb-10 px-5">
    <h2 class="text-3xl font-bold text-center">Frequently Asked Questions</h2>
    <p class="text-center text-gray-600 mt-4">Have Any Question? You Got Answer Here.</p>
    <div class="mt-4 space-y-4">
        <!-- FAQ Item -->
        <div class="border-b">
            <button class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">What is a Time Calculator and how does it work?</span>
                <span class="text-2xl w-[25px] h-[25px] flex justify-center items-center text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</span>
            </button>
            <div class="faq-content hidden text-gray-600 pb-4 max-w-[95%] w-[100%]">
                A Time Calculator is a tool designed to add or subtract time values (hours, minutes, seconds) and calculate the duration between two points in time. It works by converting all time inputs into a common unit, performing the math, and then formatting the result back into a readable time format.
            </div>
        </div>
        <!-- FAQ Item -->
        <div class="border-b">
            <button class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">Can I calculate a time that was hours ago?</span>
                <span class="text-2xl w-[25px] h-[25px] flex justify-center items-center text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</span>
            </button>
            <div class="faq-content hidden text-gray-600 pb-4 max-w-[95%] w-[100%]">
                Yes! Our calculator allows you to subtract hours, minutes, or days from the current time to find out exactly what time it was in the past. This is useful for tracking historical data or calculating elapsed intervals.
            </div>
        </div>
        <!-- FAQ Item -->
        <div class="border-b">
            <button class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">Is it possible to calculate time into the future?</span>
                <span class="text-2xl w-[25px] h-[25px] flex justify-center items-center text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</span>
            </button>
            <div class="faq-content hidden text-gray-600 pb-4 max-w-[95%] w-[100%]">
                Absolutely. You can add specific amounts of time to any date or the current time to determine future points in time. This is ideal for project planning, deadline management, or simple scheduling.
            </div>
        </div>
        <!-- FAQ Item -->
        <div class="border-b">
            <button class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">Does this calculator adjust for different time zones?</span>
                <span class="text-2xl w-[25px] h-[25px] flex justify-center items-center text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</span>
            </button>
            <div class="faq-content hidden text-gray-600 pb-4 max-w-[95%] w-[100%]">
                Most of our standard duration calculators use local time, but we also provide specialized tools for time zone conversion. These tools handle UTC offsets and Daylight Saving Time (DST) automatically to ensure accuracy across the globe.
            </div>
        </div>
        <!-- FAQ Item -->
        <div class="border-b">
            <button class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">Is this tool free to use?</span>
                <span class="text-2xl w-[25px] h-[25px] flex justify-center items-center text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</span>
            </button>
            <div class="faq-content hidden text-gray-600 pb-4 max-w-[95%] w-[100%]">
                Yes, TheTime-Calculator.com is 100% free for everyone. We support our site through subtle advertisements so that we can keep providing high-precision tools at no cost to our users.
            </div>
        </div>
    </div>
</div>

<script>
    let activeFAQ = null;

    document.querySelectorAll('.faq-toggle').forEach((button) => {
        button.addEventListener('click', () => {
            const currentFaqContent = button.nextElementSibling;
            const currentFaqIcon = button.querySelector('.faq-icon');

            if (activeFAQ && activeFAQ !== currentFaqContent) {
                activeFAQ.classList.add('hidden');
                activeFAQ.previousElementSibling.querySelector('.faq-icon').classList.remove('rotate-45');
                activeFAQ.previousElementSibling.querySelector('.faq-icon').textContent = '+';
            }

            if (currentFaqContent.classList.contains('hidden')) {
                currentFaqContent.classList.remove('hidden');
                currentFaqIcon.classList.add('rotate-45');
                currentFaqIcon.textContent = '×';
                activeFAQ = currentFaqContent;
            } else {
                currentFaqContent.classList.add('hidden');
                currentFaqIcon.classList.remove('rotate-45');
                currentFaqIcon.textContent = '+';
                activeFAQ = null;
            }
        });
    });
</script>

@endsection

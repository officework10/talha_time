@extends('layouts.app')
@section('title', $meta_title)
@section('meta_des', $meta_des)

@section('content')
<section class="bg-white">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
        
        <!-- Header -->
        <div class="w-full mx-auto rounded-lg text-center mb-8">
            <h1 class="text-2xl lg:text-4xl md:text-4xl font-semibold">Contact Us</h1>
            <p class="text-gray-600 mt-4">
                Got a technical issue? Want to send feedback? Need details about our Business plan? Let us know.
            </p>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg text-center">
                {{ session('error') }}
            </div>
        @endif
         <livewire:contact.contact-us />
      

    </div>
</section>
@endsection

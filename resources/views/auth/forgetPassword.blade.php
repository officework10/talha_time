@extends('layouts.app')
@section('content')
<div class="bg-white dark:bg-gray-900">
    <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6 my-10">
        <div class="flex-1">
            <div class="text-center">
                <div class="flex justify-center mx-auto">
                    <img  src="{{ asset('images/ogview/logo.png')}}" width="50px" alt="forget password">
                </div>
                <p class="mt-3 text-gray-500">Sign in to access your account</p>
            </div>
            @if(isset($error))
            <p class="text-lg text-center"><strong class="text-red-500">{{ $error }}</strong></p>
            @endif
            @if(isset($done))
                <p class="text-lg text-center"><strong class="text-blue-500">{{ $done }}</strong></p>
            @endif

            <div class="mt-8">
                <form action="{{ url()->current() }}/" method="post">
                    @csrf
                    <div>
                        <label for="email_address" class="block mb-2 text-sm text-gray-600 ">E-Mail Address</label>
                        <input type="email" name="email" id="email_address" value="{{ old('email') }}"  placeholder="Enter Your Email" class=" @error('email') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg  focus:outline-none focus:ring focus:ring-opacity-40" />
                        @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-300 transform bg-[#095e28] rounded-lg hover:bg-[#095e28] focus:outline-none  focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

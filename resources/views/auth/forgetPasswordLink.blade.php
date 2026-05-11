@extends('layouts.app')
@section('content')

<div class="bg-white">
    <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6 my-10">
        <div class="flex-1">
            <div class="text-center">
                <div class="flex justify-center mx-auto">
                    <img  src="{{ asset('images/ogview/logo.png')}}" width="50px" alt="forget password">
                </div>
                <p class="mt-3 text-gray-500 ">Reset Password</p>
            </div>
            @if(isset($error))
            <p class="text-lg text-center"><strong class="text-red-500">{{ $error }}</strong></p>
            @endif
            @if(isset($done))
            <p class="text-lg text-center">
                <strong class="text-green-500">{{ $done }}</strong>
            </p>
            @endif
            @if($errors->any())
            <div class="alert alert-warning">
                    @foreach($errors->all() as $error)
                    <p class="text-lg text-center"><strong class="text-red-500">{{ $error }}</strong></p>
                    @endforeach
                </div>
            @endif
            <div class="mt-8">
                <form action="{{ url()->current() }}/" method="post">
                        <input type="hidden" name="token" value="{{ $token }}">
                    @csrf
                    <div>
                        <label for="email_address" class="block mb-2 text-sm text-gray-600 ">Email Address</label>
                        <input type="email" name="email" id="email_address" value="{{ old('email') }}"  placeholder="Enter Your Email" class=" @error('email') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg  focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40"  required autofocus/>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="mt-6">
                        <div class="flex justify-between mb-2">
                            <label for="password" class="text-sm text-gray-600 ">New Password</label>
                        </div>

                        <input type="password" name="password" id="password" placeholder="Your Password" class="@error('password') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg  focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    
                    <div class="mt-6">
                        <div class="flex justify-between mb-2">
                            <label for="password-confirm" class="text-sm text-gray-600 ">Confirm  Password</label>
                        </div>

                        <input type="password" name="password_confirmation" id="password-confirm" placeholder="Your Password" class="@error('password') is-invalid @enderror block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-lg  focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                        @if ($errors->has('password_confirmation'))
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-300 transform bg-[#095e28] rounded-lg hover:bg-[#095e28]  focus:ring-opacity-50">
                            Reset Password
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
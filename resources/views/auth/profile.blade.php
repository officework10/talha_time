@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    <div class="max-w-[1140px] mx-auto lg:px-0 px-5 my-10">
        <div class="max-w-[1660px]">
            <div class="absolute z-10 top-[120px] left-[0px] sm:w-[60%] sm:left-[20px] sm:top-[200px] md:w-[70%] md:left-[0px] md:top-[500px] lg:w-[80%] lg:left-[100px]"
                style=" max-width: 351px;height: 351px;flex-shrink: 0;border-radius: 351px;opacity: 0.12;background: #55be30;filter: blur(75px);z-index:-1;">
            </div>
            <div class="absolute z-10 bottom-[100px] right-[0px] sm:w-[60%] sm:right-[0px] sm:top-[200px] md:w-[70%] md:right-[0px] md:top-[350px] lg:w-[80%] lg:right-[50px]"
                style="max-width: 351px;height: 351px;flex-shrink: 0;border-radius: 351px;opacity: 0.12;background: #55be30;filter: blur(75px);z-index:-1;">
            </div>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="flex flex-col items-center justify-center">
            <div id="upload-button" class="relative">
                <img src="{{ asset(Auth::user()->image ? 'avatars/' . Auth::user()->image : 'assets/images/profile_img.png') }}"
                    width="100px" class="profile-image rounded-full h-[100px] object-cover" id="profile-image" alt="User Avatar">
                    <input type="file" hidden id="avatar" name="avatar" accept="image/*" onchange="previewImage(event)">
                <!-- Overlay image, hidden by default -->
                <label for="avatar" class="overlay-img flex items-center justify-center opacity-0 cursor-pointer">
                    <img src="{{ asset('assets/images/Editprofile.svg') }}" width="25" height="25" alt="Edit Profile Icon">
                </label>
            </div>
        
            <h1 class="text-[20px] text-center mt-5 font-bold leading-[26.04px] text-[#1A1A1A]">
                {{ Auth::user()->name ?? '' }}
            </h1>
            <p class="text-[14px] text-center mt-1 text-[#A3A3A3] leading-[18.23px] font-semibold">
                {{ Auth::user()->email ?? '' }}
            </p>
        </div>
        

        <div class="max-w-screen-lg mx-auto mt-14">
         
                <div class="flex lg:flex-row flex-col xl:my-8 lg:my-6 my-4 gap-x-5 gap-y-4">
                    <div class="lg:w-[50%] w-full">
                        <div>
                            <label for="name"
                                class="block mb-2 xl:text-[16px] lg:text-[14px] text-[14px] font-medium text-[#000] pl-5">
                                Name:</label>
                            <input type="text" id="name" name="name" value="{{ Auth::user()->name ?? '' }}"
                                class="bg-white border-[#F0F0F0] rounded-[30.5px] border-2 text-gray-900 text-sm  block w-full 2xl:p-5 xl:p-4 lg:p-3 p-3 "
                                placeholder="Enter your First Name" />
                                @if ($errors->has('name'))
                                <span class="text-[red]">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="lg:w-[50%] w-full">
                        <div>
                            <label for="email"
                                class="block mb-2 xl:text-[16px] lg:text-[14px] text-[14px] font-medium text-[#000] pl-5">
                                Email:</label>
                            <input type="text" id="email" name="email" value="{{ Auth::user()->email ?? '' }}"
                                class="bg-white border-[#F0F0F0] rounded-[30.5px] border-2 text-gray-900 text-sm  block w-full 2xl:p-5 xl:p-4 lg:p-3 p-3 "
                                placeholder="Enter your Last Name" />
                                @if ($errors->has('email'))
                                <span class="text-[red]">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="max-w-[100%] mx-auto flex justify-center">
                    <button
                        class="bg-[#000] lg:max-w-[370px] md:max-w-[370px] w-full py-5 shadow-2xl mb-8 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 mx-auto"
                        onclick="toggleDiv()">
                        Update Changes
                    </button>
                </div>


          
        </div>
    </form>
    </div>


@endsection

<script>
    function previewImage(event) {
        const input = event.target;
        const profileImage = document.querySelector('.profile-image'); // Select image using class

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                profileImage.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]); // Convert to Base64
        }
    }
</script>



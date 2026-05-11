<div>

    <div x-data="{ show: false, message: '' }"
        x-on:toast.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 3000);"
        x-show="show" x-transition
        class="fixed top-6 right-6 bg-green-600 text-white font-medium px-6 py-3 rounded-xl shadow-lg z-50"
        style="display: none;">
        <span x-text="message"></span>
    </div>

    <form wire:submit.prevent="send">
        <div>
            <label for="name"
                class="block mb-2 xl:text-[14px] lg:text-[12px] text-[14px] font-medium text-[#A3A3A3] pl-5">Full Name</label>
            <input type="name" id="name" wire:model.defer="name"
                class="input_border bg-white border-[#F0F0F0] rounded-[20.5px] border-2 text-gray-900 text-sm block w-full p-4"
                placeholder="Enter Full Name" required />
            @error('name')
                <span class="text-red-500">{{ $message }}</span>
            @enderror

        </div>
        <div class="my-4">
            <label for="email"
                class="block mb-2 xl:text-[14px] lg:text-[12px] text-[14px] font-medium text-[#A3A3A3] pl-5 ">Email Address</label>
            <input type="email" id="email" wire:model.defer="email"
                class="input_border bg-white border-[#F0F0F0] rounded-[20.5px] border-2 text-gray-900 text-sm  block w-full 2xl:p-5 xl:p-4 lg:p-3 p-3 "
                placeholder="Enter Email Address" required />
            @error('email')
                <span class="text-red-500">{{ $message }}</span>
            @enderror

        </div>
        <div>
            <label for="subject"
                class="block mb-2 xl:text-[14px] lg:text-[12px] text-[14px] font-medium text-[#A3A3A3] pl-5">Subject</label>
            <input type="text" id="subject" wire:model.defer="subject"
                class="input_border bg-white border-[#F0F0F0] rounded-[20.5px] border-2 text-gray-900 text-sm block w-full p-4"
                placeholder="Enter Subject" required />
            @error('subject')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="msg"
                class="block my-2 xl:text-[14px] lg:text-[12px] text-[14px] font-medium text-[#A3A3A3] pl-5">Message</label>
            <textarea type="text" rows="10" id="msg" wire:model.defer="msg"
                class="input_border bg-white border-[#F0F0F0] rounded-[20.5px] border-2 text-gray-900 text-sm block w-full p-4"
                placeholder="Enter Message" required></textarea>
            @error('msg')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
            <div class="flex justify-center mt-8">
                <button type="submit"
                    class="bg-[#000] min-w-full py-5 shadow-2xl mb-8 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 flex items-center justify-center gap-2 disabled:opacity-60"
                    wire:loading.attr="disabled">

                    <span>SEND MESSAGE</span>

                    <!-- Loader -->
                    <svg wire:loading wire:target="send" class="animate-spin h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </button>
            </div>

        </div>
    </form>


</div>

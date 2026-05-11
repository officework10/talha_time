<div>
    <div x-data="{ show: false, message: '' }"
        x-on:toast.window="
        message = $event.detail.message;
        show = true;
        setTimeout(() => show = false, 3000);
    "
        x-show="show" x-transition
        class="fixed top-6 right-6 bg-green-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg z-[99999]"
        style="display: none;">
        <span x-text="message"></span>
    </div>



    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <input wire:model.defer="name" type="text" name="name"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#55be30] focus:border-[#55be30] shadow-sm"
                placeholder="Enter Full Name" autocomplete="off">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <input wire:model.defer="email" type="email" name="email"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#55be30] focus:border-[#55be30] shadow-sm"
                placeholder="Enter Email Address" autocomplete="off">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <textarea wire:model.defer="message" rows="5" name="message"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#55be30] focus:border-[#55be30] shadow-sm"
                placeholder="Enter Message"></textarea>
            @error('message')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex justify-center mt-8">
            <button type="submit"
                class="bg-[#55be30] min-w-full py-2 shadow-2xl mb-2 text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[16px] rounded-[44px] px-5 flex items-center justify-center gap-2 disabled:opacity-60"
                wire:loading.attr="disabled">
                <span>SUBMIT FEEDBACK</span>
                <!-- Loader -->
                <svg wire:loading wire:target="submit" class="animate-spin h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

{{-- Other Locales (cs, tr, de, id, es etc.) --}}
<div class="lg:w-[50%] md:w-[90%] w-full mx-auto">
    <div class="col-12 col-lg-9 mx-auto mt-2 w-full">
        <div class="flex flex-wrap items-center bg-green-100 border border-green-500 text-center rounded-lg px-1">
            <div class="lg:w-1/2 w-full px-2 py-1">
                <div wire:click="changeTimeType('2')"
                    class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white pacetab {{ $time_type === '2' ? 'tagsUnit' : '' }}">
                    {{ $lang['50'] ?? 'Time Difference' }}
                </div>
            </div>
            <div class="lg:w-1/2 w-full px-2 py-1">
                <div wire:click="changeTimeType('4')"
                    class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white pacetab {{ $time_type === '4' ? 'tagsUnit' : '' }}">
                    {{ $lang['53'] ?? 'Duration Between Two Dates' }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="lg:w-[50%] md:w-[90%] w-full mx-auto mt-5">
    <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
        @if ($time_type == '2')
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-6">
                        <div class="flex justify-between items-center">
                            <label class="label">{{ $lang['s_time'] ?? 'Start Time' }}</label>
                            <span class="text-blue underline cursor-pointer text-sm" wire:click="setNowTime('s_time')">Now</span>
                        </div>
                        <input type="time" wire:model="s_time" class="input my-2">
                    </div>
                    <div class="col-span-6">
                        <div class="flex justify-between items-center">
                            <label class="label">{{ $lang['e_time'] ?? 'End Time' }}</label>
                            <span class="text-blue underline cursor-pointer text-sm" wire:click="setNowTime('e_time')">Now</span>
                        </div>
                        <input type="time" wire:model="e_time" class="input my-2">
                    </div>
                </div>
            </div>
        @elseif ($time_type == '4')
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-6">
                        <label class="label">{{ $lang['51'] ?? 'Start Date' }}</label>
                        <input type="date" wire:model="fs_date" class="input my-2">
                    </div>
                    <div class="col-span-6">
                        <div class="flex justify-end">
                            <span class="text-blue underline cursor-pointer text-sm" wire:click="setNowTime('ft_time')">{{ $lang['46'] ?? 'Now' }}</span>
                        </div>
                        <input type="time" wire:model="ft_time" class="input my-2">
                    </div>
                    <div class="col-span-6">
                        <label class="label">{{ $lang['52'] ?? 'End Date' }}</label>
                        <input type="date" wire:model="fe_date" class="input my-2">
                    </div>
                    <div class="col-span-6">
                        <div class="flex justify-end">
                            <span class="text-blue underline cursor-pointer text-sm" wire:click="setNowTime('fe_time')">{{ $lang['46'] ?? 'Now' }}</span>
                        </div>
                        <input type="time" wire:model="fe_time" class="input my-2">
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

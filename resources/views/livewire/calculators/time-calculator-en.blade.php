{{-- English Locale --}}
<div class="lg:w-[50%] md:w-[90%] w-full mx-auto">
    <div class="col-12 col-lg-9 mx-auto mt-2 w-full">
        <div class="flex flex-wrap items-center bg-green-100 border border-green-500 text-center rounded-lg px-1">
            <div class="lg:w-1/2 w-full px-2 py-1">
                <div wire:click="changeOperation('time_first')"
                    class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white pacetab {{ $submit === 'time_first' ? 'tagsUnit' : '' }}">
                    {{ $lang['tool_title'] ?? 'Time Calculator' }}
                </div>
            </div>
            <div class="lg:w-1/2 w-full px-2 py-1">
                <div wire:click="changeOperation('time_second')"
                    class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white pacetab {{ $submit === 'time_second' ? 'tagsUnit' : '' }}">
                    {{ $lang['add_sub_title'] ?? 'add or subtract time from a date' }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="lg:w-[70%] md:w-[100%] w-full mx-auto">
    <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
        @if ($submit == 'time_first')
            <div class="col-span-12">
                <p class="text-[14px] mt-2 lg:px-2 text-gray-600 text-center mb-6">{{ $lang['tool_desc'] ?? 'Calculate the difference between two times.' }}</p>
            </div>
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-6 md:col-span-3 lg:col-span-3">
                        <label class="label">{{ $lang['days'] ?? 'Days' }}:</label>
                        <input type="number" step="any" wire:model="t_days" class="input my-2" placeholder="_ _">
                    </div>
                    <div class="col-span-6 md:col-span-3 lg:col-span-3">
                        <label class="label">{{ $lang['hours'] ?? 'Hours' }}:</label>
                        <input type="number" step="any" wire:model="t_hours" class="input my-2" placeholder="_ _">
                    </div>
                    <div class="col-span-6 md:col-span-3 lg:col-span-3">
                        <label class="label">{{ $lang['min'] ?? 'Minutes' }}:</label>
                        <input type="number" step="any" wire:model="t_min" class="input my-2" placeholder="_ _">
                    </div>
                    <div class="col-span-6 md:col-span-3 lg:col-span-3">
                        <label class="label">{{ $lang['sec'] ?? 'Seconds' }}:</label>
                        <input type="number" step="any" wire:model="t_sec" class="input my-2" placeholder="_ _">
                    </div>
                </div>
            </div>
            <div class="col-span-12 oprations flex text-center justify-center my-1">
                <label class="pe-2 flex items-center">
                    <input type="radio" wire:model="t_method" value="plus" class="mr-2">
                    <span>+ {{ $lang['add'] ?? 'Add' }}</span>
                </label>
                <label class="pe-2 flex items-center">
                    <input type="radio" wire:model="t_method" value="minus" class="mr-2">
                    <span>- {{ $lang['sub'] ?? 'Subtract' }}</span>
                </label>
            </div>
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-6 md:col-span-3 lg:col-span-3">
                        <label class="label">{{ $lang['days'] ?? 'Days' }}:</label>
                        <input type="number" step="any" wire:model="te_days" class="input my-2" placeholder="_ _">
                    </div>
                    <div class="col-span-6 md:col-span-3 lg:col-span-3">
                        <label class="label">{{ $lang['hours'] ?? 'Hours' }}:</label>
                        <input type="number" step="any" wire:model="te_hours" class="input my-2" placeholder="_ _">
                    </div>
                    <div class="col-span-6 md:col-span-3 lg:col-span-3">
                        <label class="label">{{ $lang['min'] ?? 'Minutes' }}:</label>
                        <input type="number" step="any" wire:model="te_min" class="input my-2" placeholder="_ _">
                    </div>
                    <div class="col-span-6 md:col-span-3 lg:col-span-3">
                        <label class="label">{{ $lang['sec'] ?? 'Seconds' }}:</label>
                        <input type="number" step="any" wire:model="te_sec" class="input my-2" placeholder="_ _">
                    </div>
                </div>
            </div>
        @elseif ($submit == 'time_second')
            <div class="col-span-12">
                <p class="text-[14px] mt-2 lg:px-2 text-gray-600 text-center mb-6">{{ $lang['add_sub_title_des'] ?? 'Add or subtract duration from a specific date and time.' }}</p>
            </div>
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-12 md:col-span-2 lg:col-span-2 flex items-center justify-center">
                        <div class="fw-semibold text-center">{{ $lang['15'] ?? 'Start Time' }}</div>
                    </div>
                    <div class="col-span-12 md:col-span-2 lg:col-span-2">
                        <label class="label">{{ $lang['13'] ?? 'Start Date' }}:</label>
                        <input type="date" wire:model="td_date" class="input my-2">
                    </div>
                    <div class="col-span-4 md:col-span-2 lg:col-span-2">
                        <label class="label">{{ $lang['hours'] ?? 'Hours' }}:</label>
                        <input type="number" step="any" wire:model="ts_hours" class="input my-2" placeholder="00">
                    </div>
                    <div class="col-span-4 md:col-span-2 lg:col-span-2">
                        <label class="label">{{ $lang['min'] ?? 'Minutes' }}:</label>
                        <input type="number" step="any" wire:model="ts_min" class="input my-2" placeholder="00">
                    </div>
                    <div class="col-span-4 md:col-span-2 lg:col-span-2">
                        <label class="label">{{ $lang['sec'] ?? 'Seconds' }}:</label>
                        <input type="number" step="any" wire:model="ts_sec" class="input my-2" placeholder="00">
                    </div>
                    <div class="col-span-12 md:col-span-2 lg:col-span-2 flex justify-center items-center">
                        <div class="time bg_time px-1 m-0 mx-2 flex space-x-2 bg-gray-200 rounded-md p-1 mt-6">
                            <button type="button" wire:click="$set('am_pm', 'am')" class="px-4 py-1 rounded-md {{ $am_pm === 'am' ? 'bg-green-600 text-white' : 'bg-white' }}">AM</button>
                            <button type="button" wire:click="$set('am_pm', 'pm')" class="px-4 py-1 rounded-md {{ $am_pm === 'pm' ? 'bg-green-600 text-white' : 'bg-white' }}">PM</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 flex justify-center oprations my-3">
                <label class="pe-2 flex items-center">
                    <input type="radio" wire:model="td_method" value="plus" class="mr-2">
                    <span>+ {{ $lang['add'] ?? 'Add' }}</span>
                </label>
                <label class="pe-2 flex items-center">
                    <input type="radio" wire:model="td_method" value="minus" class="mr-2">
                    <span>- {{ $lang['sub'] ?? 'Subtract' }}</span>
                </label>
            </div>
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="hidden md:block col-span-2"></div>
                    <div class="col-span-6 md:col-span-2 lg:col-span-2">
                        <label class="label">{{ $lang['days'] ?? 'Days' }}:</label>
                        <input type="number" step="any" wire:model="td_days" class="input my-2" placeholder="0">
                    </div>
                    <div class="col-span-6 md:col-span-2 lg:col-span-2">
                        <label class="label">{{ $lang['hours'] ?? 'Hours' }}:</label>
                        <input type="number" step="any" wire:model="td_hours" class="input my-2" placeholder="0">
                    </div>
                    <div class="col-span-6 md:col-span-2 lg:col-span-2">
                        <label class="label">{{ $lang['min'] ?? 'Minutes' }}:</label>
                        <input type="number" step="any" wire:model="td_min" class="input my-2" placeholder="0">
                    </div>
                    <div class="col-span-6 md:col-span-2 lg:col-span-2">
                        <label class="label">{{ $lang['sec'] ?? 'Seconds' }}:</label>
                        <input type="number" step="any" wire:model="td_sec" class="input my-2" placeholder="0">
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

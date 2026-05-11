{{-- Arabic Locale --}}
<div class="lg:w-[50%] md:w-[90%] w-full mx-auto">
    <div class="col-12 col-lg-9 mx-auto mt-2 w-full">
        <div class="flex flex-wrap items-center bg-green-100 border border-green-500 text-center rounded-lg px-1">
            <div class="lg:w-1/2 w-full px-2 py-1">
                <div wire:click="changeTimeType('2')"
                    class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white pacetab {{ $time_type === '2' ? 'tagsUnit' : '' }}">
                    مدة من الزمن
                </div>
            </div>
            <div class="lg:w-1/2 w-full px-2 py-1">
                <div wire:click="changeTimeType('4')"
                    class="bg-white px-3 py-2 cursor-pointer rounded-md transition-colors duration-300 hover_tags hover:text-white pacetab {{ $time_type === '4' ? 'tagsUnit' : '' }}">
                    الوقت بين تاريخين
                </div>
            </div>
        </div>
    </div>
</div>

<div class="lg:w-[60%] md:w-[100%] w-full mx-auto" dir="rtl">
    <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
        @if ($time_type == '2')
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-2 md:gap-4 lg:gap-4">
                    <div class="col-span-12 md:col-span-6">
                        <label class="label">وقت البدء</label>
                        <input type="time" wire:model="s_time" class="input my-2">
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <label class="label">وقت النهاية</label>
                        <input type="time" wire:model="e_time" class="input my-2">
                    </div>
                </div>
            </div>
        @elseif ($time_type == '4')
            <div class="col-span-12">
                <p class="text-center font-bold mb-4">وقت وتاريخ البداية</p>
                <div class="grid grid-cols-4 md:grid-cols-7 gap-2">
                    <div>
                        <label class="label">الفترة</label>
                        <select wire:model="am_pm" class="input">
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">الثانية</label>
                        <input type="number" wire:model="sec" min="0" max="59" class="input">
                    </div>
                    <div>
                        <label class="label">الدقيقة</label>
                        <input type="number" wire:model="min" min="0" max="59" class="input">
                    </div>
                    <div>
                        <label class="label">الساعة</label>
                        <input type="number" wire:model="hur" min="1" max="12" class="input">
                    </div>
                    <div>
                        <label class="label">اليوم</label>
                        <input type="number" wire:model="day" min="1" max="31" class="input">
                    </div>
                    <div>
                        <label class="label">الشهر</label>
                        <input type="number" wire:model="mon" min="1" max="12" class="input">
                    </div>
                    <div>
                        <label class="label">السنة</label>
                        <input type="number" wire:model="year" class="input">
                    </div>
                </div>

                <p class="text-center font-bold my-4">وقت وتاريخ النهاية</p>
                <div class="grid grid-cols-4 md:grid-cols-7 gap-2">
                    <div>
                        <label class="label">الفترة</label>
                        <select wire:model="ampm" class="input">
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">الثانية</label>
                        <input type="number" wire:model="sec_s" min="0" max="59" class="input">
                    </div>
                    <div>
                        <label class="label">الدقيقة</label>
                        <input type="number" wire:model="min_s" min="0" max="59" class="input">
                    </div>
                    <div>
                        <label class="label">الساعة</label>
                        <input type="number" wire:model="hur_s" min="1" max="12" class="input">
                    </div>
                    <div>
                        <label class="label">اليوم</label>
                        <input type="number" wire:model="day_s" min="1" max="31" class="input">
                    </div>
                    <div>
                        <label class="label">الشهر</label>
                        <input type="number" wire:model="mon_s" min="1" max="12" class="input">
                    </div>
                    <div>
                        <label class="label">السنة</label>
                        <input type="number" wire:model="year_s" class="input">
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

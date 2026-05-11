<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 font-sans">
    <div class="grid grid-cols-12 gap-6">
        <!-- Main Result Card -->
        <div class="col-span-12">
            <div class="bg-slate-50 rounded-3xl p-6 sm:p-12 text-center border ">
                <div class="inline-flex bg-white p-5 rounded-2xl shadow-md border  ">
                    <img src="{{ asset('images/r_days.png') }}" alt="Calendar" class="w-12 h-12 object-contain">
                </div>
                <h2 class="text-[18px] md:text-[20px] mt-3">Date in {{ $weeks }} {{ Str::plural('week', (int)$weeks) }}</h2>
                <h1 class="text-[20px] md:text-[25px] mt-3 font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $targetDate->format('l,') }} 
                    <span class="text-emerald-600">{{ $targetDate->format('M j, Y') }}</span>
                </h1>
            </div>
        </div>

        <!-- Input Section -->
        <div class="col-span-12 ">
        <div class=" flex justify-center">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                <div class="col-span-12">
                    <label class="label"> Number of weeks: </label>
                    <div class="relative flex items-center">
                        <input type="number" wire:model.live="weeks"  class="input"placeholder="0">
                    </div>
                </div>
                </div>
              
            </div>
        </div>
    </div>
</div>

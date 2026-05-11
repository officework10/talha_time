<div>
    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg space-y-6 my-3">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif
            <div class="lg:w-[50%] md:w-[80%] w-full mx-auto">
                <div class="grid grid-cols-1 gap-4">
                    <p class="px-2 label">
                        {{ $lang['bday'] ?? '' }}
                    </p>

                    <div class="grid grid-cols-12 gap-4">
                        <!-- Month -->
                        <div class="col-span-4 relative">
                            <label for="month" class="label">{{ $lang['1'] ?? 'Month' }}</label>
                            <select wire:model="month" id="month" class="input">
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}">
                                        {{ Carbon\Carbon::create()->month($m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Day -->
                        <div class="col-span-4 relative">
                            <label for="day" class="label">{{ $lang['2'] ?? 'Day' }}</label>
                            <select wire:model="day" id="day" class="input">
                                @foreach (range(1, 31) as $d)
                                    <option value="{{ $d }}">{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Year -->
                        <div class="col-span-4 relative">
                            <label for="year" class="label">{{ $lang['3'] ?? 'Year' }}</label>
                            <select wire:model="year" id="year" class="input">
                                @foreach (range(1950, 2050) as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-6 md:col-span-4 relative">
                            <label for="name" class="label">{{ $lang['4'] ?? 'Name' }}</label>
                            <input type="text" id="name" class="input" wire:model="name"
                                placeholder="Optional">
                        </div>
                    </div>
                </div>
            </div>

            @if ($type == 'calculator')
                @include('inc.button')
            @endif
            @if ($type == 'widget')
                @include('inc.widget-button')
            @endif
        </div>

        @isset($detail)
            <div id="result-section" wire:loading.remove wire:target="calculate"
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg space-y-6 result">
                <div class="">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="rounded-lg flex items-center justify-center">
                        <div class="w-full p-3 rounded-lg mt-3 overflow-auto">
                            <div class="flex flex-col items-center overflow-auto">
                                <div class=" md:w-[40%] mb-2 text-center ">
                                    <p class="text-lg my-2">There are only</p>
                                    <div class="flex justify-between gap-5 text-center items-center">
                                        <div class="bg-blue-100 rounded-md p-2 px-5">
                                            <strong class="text-blue-700 block text-2xl">{{ $countdownDays }}</strong>
                                            <strong class="text-sm">Days</strong>
                                        </div>
                                        <strong class="text-2xl text-blue-700">:</strong>
                                        <div class="bg-blue-100 rounded-md p-2 px-5">
                                            <strong class="text-blue-700 block text-2xl">{{ $countdownHours }}</strong>
                                            <strong class="text-sm">Hours</strong>
                                        </div>
                                        <strong class="text-2xl text-blue-700">:</strong>
                                        <div class="bg-blue-100 rounded-md p-2 px-5">
                                            <strong class="text-blue-700 block text-2xl">{{ $countdownMinutes }}</strong>
                                            <strong class="text-sm">Minutes</strong>
                                        </div>
                                        <strong class="text-2xl text-blue-700">:</strong>
                                        <div class="bg-blue-100 rounded-md p-2 px-5">
                                            <strong class="text-blue-700 block text-2xl">{{ $countdownSeconds }}</strong>
                                            <strong class="text-sm">Seconds</strong>
                                        </div>
                                    </div>
                                    <p class="text-lg mt-2">until
                                        {{ $name ? $name . "'s" : 'Your' }}
                                        Birthday!</p>
                                </div>
                                <table class="w-full lg:w-2/3 border-collapse border-spacing-0">
                                    <tr>
                                        <td class="border-b border-gray-300 py-2">🎂 Your Age</td>
                                        <td class="border-b border-gray-300 py-2 text-right">
                                            <strong>{{ $detail['age'] }} Years</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-b border-gray-300 py-2">📅 Months remaining until your birthday
                                        </td>
                                        <td class="border-b border-gray-300 py-2 text-right">
                                            <strong>
                                                {{ $detail['diffInMonths'] }}
                                                @if ($detail['diffInMonths'] == 1)
                                                    Month
                                                @else
                                                    Months
                                                @endif
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-b border-gray-300 py-2">🌞 Hours remaining until your birthday
                                        </td>
                                        <td class="border-b border-gray-300 py-2 text-right">
                                            <strong>
                                                {{ $detail['diffInHours'] }}
                                                @if ($detail['diffInHours'] == 1)
                                                    Hour
                                                @else
                                                    Hours
                                                @endif
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-b border-gray-300 py-2">🕑 Minutes remaining until your birthday
                                        </td>
                                        <td class="border-b border-gray-300 py-2 text-right">
                                            <strong>
                                                {{ $detail['diffInMinutes'] }}
                                                @if ($detail['diffInMinutes'] == 1)
                                                    Minute
                                                @else
                                                    Minutes
                                                @endif
                                            </strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @script
                <script>
                    document.addEventListener('livewire:initialized', () => {
                        // Start countdown when component is initialized
                        @this.updateCountdown();

                        // Listen for update events
                        Livewire.on('schedule-countdown-update', () => {
                            setTimeout(() => {
                                @this.updateCountdown();
                            }, 1000);
                        });
                    });
                </script>
            @endscript
        @endisset
    </form>
</div>

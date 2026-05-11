<div>
    <style>
        .clock-container {
            position: relative;
            width: 260px;
            height: 260px;
            background: #f8fafc;
            border-radius: 50%;
            border: 8px solid #cbd5e1;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 2rem auto;
        }

        .clock-face {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .clock-mark {
            position: absolute;
            width: 2px;
            height: 8px;
            background-color: #94a3b8;
            left: 50%;
            transform-origin: 50% 122px;
            top: 4px;
        }

        .clock-mark.major {
            width: 4px;
            height: 12px;
            background-color: #38A169;
        }

        .hand {
            position: absolute;
            bottom: 50%;
            left: 50%;
            transform-origin: bottom;
            border-radius: 10px;
            z-index: 10;
            transition: transform 0.5s cubic-bezier(0.4, 2.08, 0.55, 0.44);
        }

        .hour-hand {
            width: 6px;
            height: 60px;
            background: #2d3748;
            margin-left: -3px;
        }

        .minute-hand {
            width: 4px;
            height: 85px;
            background: #4a5568;
            margin-left: -2px;
        }

        .second-hand {
            width: 2px;
            height: 95px;
            background: #f6ad55;
            margin-left: -1px;
            transition: transform 0.2s linear;
        }

        .clock-center {
            position: absolute;
            width: 14px;
            height: 14px;
            background: #cbd5e1;
            border: 2px solid #fff;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 20;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .number {
            position: absolute;
            width: 100%;
            height: 100%;
            text-align: center;
            font-weight: 700;
            font-size: 1.2rem;
            color: #4a5568;
            padding: 20px;
        }

        /* Number positioning */
        .n12 { transform: rotate(0deg); } .n12 div { transform: rotate(0deg); }
        .n3  { transform: rotate(90deg); } .n3 div { transform: rotate(-90deg); }
        .n6  { transform: rotate(180deg); } .n6 div { transform: rotate(-180deg); }
        .n9  { transform: rotate(270deg); } .n9 div { transform: rotate(-270deg); }

        .input_glow:focus {
            box-shadow: 0 0 0 3px rgba(56, 161, 105, 0.2);
            border-color: #38A169 !important;
        }

        .digital-time-display {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1a202c;
            letter-spacing: -1px;
        }
    </style>

    <div class="w-full mx-auto p-6 lg:p-10 bg-white rounded-3xl shadow-xl space-y-8 my-6 border border-gray-100">
        <div class="max-w-4xl mx-auto text-center">
            
            <div id="future-display" class="space-y-2 mb-8">
                <h1 id="digital-time" class="digital-time-display">00:00:00 AM</h1>
                <p id="full-date" class="text-xl font-semibold text-gray-600">Wednesday, February 11, 2026</p>
            </div>

            <div class="clock-container">
                <div class="clock-face" id="clock-face">
                    <!-- Marks -->
                    @for ($i = 0; $i < 60; $i++)
                        <div class="clock-mark {{ $i % 5 == 0 ? 'major' : '' }}" style="transform: rotate({{ $i * 6 }}deg)"></div>
                    @endfor
                    
                    <!-- Numbers -->
                    <div class="number n12"><div>12</div></div>
                    <div class="number n3"><div>3</div></div>
                    <div class="number n6"><div>6</div></div>
                    <div class="number n9"><div>9</div></div>

                    <!-- Hands -->
                    <div id="hour-hand" class="hand hour-hand"></div>
                    <div id="minute-hand" class="hand minute-hand"></div>
                    <div id="second-hand" class="hand second-hand"></div>
                    <div class="clock-center"></div>
                </div>
            </div>

            <div class="max-w-md mx-auto mt-10">
                <label for="hours-input" class="block text-sm font-bold text-gray-500 uppercase tracking-wider mb-2 text-left">
                    Number of hours from now:
                </label>
                <input type="number" id="hours-input" value="3" min="0" 
                    class=" input"
                    placeholder="Enter hours...">
            </div>
        </div>

        <div class="max-w-4xl mx-auto pt-8 border-t border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-600">
                <div class="bg-gray-50 p-6 rounded-2xl">
                    <p class="text-sm font-semibold text-gray-400 uppercase mb-2">Current Date Info</p>
                    <p class="text-lg">Today is <span class="font-bold text-green-600">{{ $currentDate->format('F jS') }}</span></p>
                    <p>Day number: <span class="font-bold text-green-600">{{ $currentDate->dayOfYear }}</span> / {{ $currentDate->isLeapYear() ? '366' : '365' }}</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-2xl">
                    <p class="text-sm font-semibold text-gray-400 uppercase mb-2">Calendar Info</p>
                    <p>Year: <span class="font-bold text-green-600">{{ $currentDate->year }}</span></p>
                    <p>Week Number: <span class="font-bold text-green-600">{{ $this->dateInfo['weekNumber'] }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const hoursInput = document.getElementById('hours-input');
            const hourHand = document.getElementById('hour-hand');
            const minuteHand = document.getElementById('minute-hand');
            const secondHand = document.getElementById('second-hand');
            const digitalTime = document.getElementById('digital-time');
            const fullDate = document.getElementById('full-date');

            function tick() {
                const now = new Date();
                const offsetHours = parseFloat(hoursInput.value) || 0;
                
                // Calculate future time
                const futureTime = new Date(now.getTime() + (offsetHours * 60 * 60 * 1000));
                
                const seconds = futureTime.getSeconds();
                const minutes = futureTime.getMinutes();
                const hours = futureTime.getHours();

                // Rotate hands
                const secondDeg = (seconds / 60) * 360;
                const minuteDeg = (minutes / 60) * 360 + (seconds / 60) * 6;
                const hourDeg = (hours / 12) * 360 + (minutes / 60) * 30;

                secondHand.style.transform = `rotate(${secondDeg}deg)`;
                minuteHand.style.transform = `rotate(${minuteDeg}deg)`;
                hourHand.style.transform = `rotate(${hourDeg}deg)`;

                // Update digital display
                digitalTime.textContent = futureTime.toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit', 
                    hour12: true 
                });

                // Update date display
                fullDate.textContent = futureTime.toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
            }

            hoursInput.addEventListener('input', tick);
            setInterval(tick, 1000);
            tick();
        }

        // Initialize on load and on Livewire updates
        document.addEventListener('DOMContentLoaded', updateClock);
        document.addEventListener('livewire:navigated', updateClock);
    </script>
</div>


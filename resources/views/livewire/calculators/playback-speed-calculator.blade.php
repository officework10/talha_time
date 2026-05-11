<div>

    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif


            <div class="lg:w-[50%] md:w-[60%] w-full mx-auto">
                <div class="grid grid-cols-12 gap-1 md:gap-4">
                    <div class="col-span-4 relative">
                        <label for="hours" class="label">
                            {{ $lang['1'] ?? 'Hours' }}:
                        </label>
                        <input type="number" step="any" wire:model="hours" id="hours" class="input my-2"
                            aria-label="input" />
                    </div>
                    <div class="col-span-4 relative">
                        <label for="minutes" class="label">
                            {{ $lang['2'] ?? 'Minutes' }}:
                        </label>
                        <input type="number" step="any" wire:model="minutes" id="minutes" class="input my-2"
                            aria-label="input" />
                    </div>
                    <div class="col-span-4 relative">
                        <label for="seconds" class="label">
                            {{ $lang['3'] ?? 'Seconds' }}:
                        </label>
                        <input type="number" step="any" wire:model="seconds" id="seconds" class="input my-2"
                            aria-label="input" />
                    </div>
                    <div class="col-span-4  relative">
                        <label for="speed" class="label">
                            {{ $lang['4'] ?? 'Playback Speed' }}:
                        </label>
                        <input type="number" step="any" wire:model="speed" id="speed" class="input my-2"
                            aria-label="input" />
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
                class="w-full mx-auto p-4 lg:p-8 md:p-8 result_calculator rounded-lg  space-y-6 result">
                <div class="w-full">
                    @if ($type == 'calculator')
                        @include('inc.copy-pdf')
                    @endif
                    <div class="w-full bg-light-blue p-3 rounded-lg mt-3">
                        <div class="w-full text-center text-base">
                            <div class="rounded-lg">
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div class="shadow p-4 rounded-lg bg-gray-100">
                                        <p class="text-gray-500">Total Listening Time</p>
                                        <p class="text-3xl font-bold text-green-400 mt-2">
                                            {{ $detail['totalListeningTime'] }}
                                        </p>
                                    </div>

                                    <div class="shadow p-4 rounded-lg bg-gray-100">
                                        <p class="text-gray-500">Time Saved</p>
                                        <p class="text-3xl font-bold text-green-400 mt-2">
                                            {{ $detail['timeSaved'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="bg-white shadow mt-6 rounded-lg overflow-hidden result_table">
                                    <div class="bg-green-600 text-white text-center p-2 font-semibold">
                                        Speed Comparison (Audiobook Playback)
                                    </div>
                                    <table class="w-full text-center border-collapse">
                                        <thead class="bg-gray-200">
                                            <tr>
                                                <th class="p-2 border">Speed</th>
                                                <th class="p-2 border">Listening Time</th>
                                                <th class="p-2 border">Time Saved</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detail['speedComparison'] as $item)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="p-2 border">{{ $item['speed'] }}</td>
                                                    <td class="p-2 border">{{ $item['listeningTime'] }}</td>
                                                    <td class="p-2 border text-green-400 font-medium">
                                                        {{ $item['timeSaved'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <p class="text-center mt-4 text-gray-600 italic">
                                    {{ $detail['message'] }}
                                </p>

                                @if (isset($detail['chart']) && count($detail['chart']) > 0)
                                    <div class="mt-8 space-y-6">
                                        <div class="bg-white rounded-lg shadow-lg p-6">
                                            <h2 class="text-xl font-semibold text-gray-700 mb-4 text-center">
                                                Listening Time vs Playback Speed
                                            </h2>
                                            <div class="relative" style="height: 350px;">
                                                <canvas id="playbackChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </form>
</div>

@push('calculatorJS')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            let chart = null;

            function renderChart(data) {
                const ctx = document.getElementById('playbackChart');
                if (!ctx) return;

                if (chart) {
                    chart.destroy();
                }

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(item => item.speed + 'x'),
                        datasets: [{
                            label: 'Listening Time (Hours)',
                            data: data.map(item => item.timeInHours),
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: 'Hours'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Playback Speed'
                                }
                            }
                        }
                    }
                });
            }

            @if (isset($detail['chart']))
                renderChart(@json($detail['chart']));
            @endif

            Livewire.on('calculator_result_updated', (event) => {
                if (event.detail && event.detail.chart) {
                    renderChart(event.detail.chart);
                }
            });
        });
    </script>
@endpush

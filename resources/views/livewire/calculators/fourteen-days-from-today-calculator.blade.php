
<div>

    <form wire:submit.prevent="calculate">
        <div class="w-full mx-auto p-4 lg:p-8 md:p-8 input_form rounded-lg  space-y-6 my-3 bg-gray-100">
            @if (isset($error))
                <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
            @endif

            <div class="lg:w-[50%] md:w-[60%] w-full mx-auto space-y-4">
                <div class="space-y-2 relative">
                    <label for="days" class="label">
                        {{ $lang['1'] ?? 'Number of Days' }}:
                    </label>
                    <input type="number" step="any" wire:model="days" id="days" class="input my-2"
                        aria-label="input" />
                </div>

                <div class="space-y-2">
                    <label class="label text-center block">
                        {{ $lang['quick_presets'] ?? 'Quick Presets' }}:
                    </label>
                    <div class="grid grid-cols-2 lg:grid-cols-4 md:grid-cols-4 gap-2">
                        <button type="button" wire:click="setDays(45)"
                            class="px-4 py-2 cursor-pointer bg-white hover:bg-blue-50 rounded-lg font-medium transition-colors duration-200 border border-blue-300">
                            45 Days
                        </button>
                        <button type="button" wire:click="setDays(60)"
                            class="px-4 py-2 cursor-pointer bg-white hover:bg-green-50 rounded-lg font-medium transition-colors duration-200 border border-green-300">
                            2 Month
                        </button>
                        <button type="button" wire:click="setDays(150)"
                            class="px-4 py-2 cursor-pointer bg-white hover:bg-purple-50 rounded-lg font-medium transition-colors duration-200 border border-purple-300">
                            150 Days
                        </button>
                        <button type="button" wire:click="setDays(270)"
                            class="px-4 py-2 cursor-pointer bg-white hover:bg-orange-50 rounded-lg font-medium transition-colors duration-200 border border-orange-300">
                            9 Month
                        </button>
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
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="shadow-lg p-6 rounded-lg bg-gray-100">
                                        <p class="text-gray-600 text-sm font-medium mb-2">Today's Date</p>
                                        <p class="text-2xl font-bold text-blue-700">
                                            {{ $detail['today'] }}
                                        </p>
                                    </div>

                                    <div class="shadow-lg p-6 rounded-lg bg-gray-100">
                                        <p class="text-gray-600 text-sm font-medium mb-2">Future Date</p>
                                        <p class="text-2xl font-bold text-green-400">
                                            {{ $detail['resultDate'] }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            ({{ $detail['weekDay'] }})
                                        </p>
                                    </div>
                                </div>

                                <div class="p-6 rounded-lg">
                                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center justify-center gap-2">
                                        <span>⏱</span> Time Difference
                                    </h3>
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="text-center bg-gray-100 p-4 rounded-lg shadow">
                                            <p class="text-3xl font-bold text-purple-600">
                                                {{ $detail['difference']['days'] }}
                                            </p>
                                            <p class="text-gray-600 text-sm mt-1">Days</p>
                                        </div>
                                        <div class="text-center bg-gray-100 p-4 rounded-lg shadow">
                                            <p class="text-3xl font-bold text-pink-600">
                                                {{ $detail['difference']['weeks'] }}
                                            </p>
                                            <p class="text-gray-600 text-sm mt-1">Weeks</p>
                                        </div>
                                        <div class="text-center bg-gray-100 p-4 rounded-lg shadow">
                                            <p class="text-3xl font-bold text-indigo-600">
                                                {{ $detail['difference']['months'] }}
                                            </p>
                                            <p class="text-gray-600 text-sm mt-1">Months</p>
                                        </div>
                                    </div>
                                </div>

                                @if (isset($detail['chart']) && count($detail['chart']) > 0)
                                    <div class="mt-8">
                                        <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200">
                                            <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">
                                                Date Progression Timeline
                                            </h2>
                                            <div class="relative w-full" style="height: 400px;">
                                                <canvas id="progressionChart"></canvas>
                                            </div>
                                            <p class="text-center mt-4 text-sm text-gray-500 italic">
                                                Visual representation of days from today to future date
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <div class="bg-gray-100 p-4 rounded mt-6">
                                    <p class="text-gray-700 text-center italic">
                                        {{ $detail['message'] }}
                                    </p>
                                </div>
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
                const ctx = document.getElementById('progressionChart');
                if (!ctx) return;

                if (chart) {
                    chart.destroy();
                }

                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(item => item.label),
                        datasets: [{
                            label: 'Days from Today',
                            data: data.map(item => item.dayCount),
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            fill: true,
                            tension: 0.1,
                            pointRadius: 4,
                            pointBackgroundColor: '#4f46e5'
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
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Days Count'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
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

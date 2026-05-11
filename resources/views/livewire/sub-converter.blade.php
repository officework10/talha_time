<div class="grid grid-cols-12 gap-4 p-3 rounded-lg input_form">

    <!-- Wrapper to center content -->
    <div class="col-span-12 flex flex-col items-center justify-center w-full">

        <div class="grid grid-cols-12 md:w-8/12 w-full gap-4">
            <!-- From Input -->
            <div class="md:col-span-6 col-span-12 px-2">
                <label for="from" class="label">{{ $lang['from'] }}:</label>
                <div class="w-full pt-2 relative">
                    <input type="number" wire:model.live="from" wire:input="calculate" id="from" class="input"
                        placeholder="00" />
                    <span class="input_unit top-8 absolute right-3 text-gray-600">{{ $lang['unit1'] }}</span>
                </div>
            </div>
            <!-- To Input -->
            <div class="md:col-span-6 col-span-12 px-2">
                <label for="to" class="label">{{ $lang['to'] }}:</label>
                <div class="w-full pt-2 relative">
                    <input type="number" wire:model.live="to" wire:input="revCal" id="to" class="input"
                        placeholder="00" />
                    <span class="input_unit top-8 absolute right-3 text-gray-600">{{ $lang['unit2'] }}</span>
                </div>
            </div>
            <!-- Clear Button Full Width on Small, Centered on Large -->
            <div class="col-span-12 flex justify-left px-2">
                <button wire:click="resetAll"
                    class="text-[16px] bg-black text-white border px-5 py-2 rounded-lg cursor-pointer">
                    {{ $lang['clear'] }}
                </button>
            </div>
        </div>
    </div>
    @if ($showResult)
        <div class="col-span-12 mt-4 mx-auto">
            <div class="flex items-center {{ $device === 'desktop' ? '' : 'flex-wrap' }}">
                <strong class="text-blue-600 text-lg font-bold me-2">Result:</strong>
                <div class="flex items-center bg-white border border-gray-300 rounded-lg px-3 py-2 w-fit">
                    <div class="result text-[20px] font-bold" id="resultcopyInput1">{!! $result !!}</div>
                    <button wire:click="copyResult" class="ml-3 text-gray-500 hover:text-gray-700">
                        <img src="{{ url('assets/icons/copy.png') }}" alt="Copy Result" title="Copy Result"
                            class="w-[20px]">
                    </button>
                </div>
            </div>
        </div>
    @endif
    <div x-data="{ show: false, message: '' }" x-show="show" x-init="window.addEventListener('copy-to-clipboard', e => {
        message = e.detail.message || 'Result copied to clipboard!';
        show = true;
        setTimeout(() => show = false, 2000);
    })" x-transition
        class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50" x-text="message"
        style="display: none;"></div>
</div>

@push('calculatorJS')
    <script>
        window.addEventListener('copy-to-clipboard', event => {
            const resultUnit1 = document.getElementById('resultcopyInput1')?.innerText ?? '';
            const valueToCopy = resultUnit1;
            if (!valueToCopy.trim()) return;
            // Create temporary input to copy the value
            const tempInput = document.createElement('input');
            tempInput.value = valueToCopy;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

        });
    </script>
@endpush

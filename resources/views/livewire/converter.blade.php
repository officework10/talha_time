<div class="grid grid-cols-12 gap-4 p-5 bg-[#F4F4F4] shadow-md">
    <input type="hidden" id="check" value="{{ $page }}">
    <div class="md:col-span-6 col-span-12 ">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <label for="from" class="label">{{ $lang['from'] }}:</label>
                <div class="w-100 pt-2 converter_input">
                    <input type="number" wire:model.live="fromValue" wire:change="calculate" id="from"
                        class="input" aria-label="input" placeholder="00" />
                </div>
            </div>

            <div class="col-span-12">
                <label for="calFrom" class="font-s-14">&nbsp;</label>
                <div class="w-full bg-white rounded p-2 ">
                    <select wire:model="fromUnit" wire:change="calculate" id="calFrom"
                        size="{{ $device == 'desktop' ? 7 : 4 }}" class="unit-select-add custom-scroll">
                        @foreach ($options as $option)
                            <option value="{{ $option['value'] }}" @if (isset($option['selected'])) selected @endif>
                                {{ $option['text'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="md:col-span-6 col-span-12">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <label for="to" class="label">{{ $lang['to'] }}:</label>
                <div class="w-100 pt-2 converter_input">
                    <input type="number" wire:model.live="toValue" wire:change="revCalculate" id="to"
                        class="input" aria-label="input" placeholder="00" />
                </div>
            </div>
            <div class="col-span-12">
                <label for="calto" class="font-s-14">&nbsp;</label>
                <div class="w-full bg-white rounded p-2">
                    <select wire:model="toUnit" wire:change="calculate" id="calto"
                        size="{{ $device == 'desktop' ? 7 : 4 }}" class="unit-select-add custom-scroll">
                        @foreach ($toOptions as $option)
                            <option value="{{ $option['value'] }}" @if (isset($option['selected'])) selected @endif>
                                {{ $option['text'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 md:col-span-12 mt-4 mx-auto res_ans @if (!$showResult) hidden @endif">
        <div class="flex items-center {{ $device == 'desktop' ? '' : 'flex-wrap' }}">
            <strong
                class="text-blue-600 text-lg font-bold me-2 {{ $device == 'desktop' ? '' : 'mb-2' }}">Result:</strong>
            <div class="flex items-center bg-white border border-gray-300 rounded-lg px-3 py-2 w-fit">
                <div class="result font-bold text-xl text-gray-900" id="resultcopyInput1">{!! $resultText !!}</div>
                <button wire:click="copyResult" class="ml-3 text-gray-500 hover:text-gray-700">
                    <img src="{{ url('assets/icons/copy.png') }}" alt="Copy Result" title="Copy Result" width="20"
                        height="20">
                </button>
            </div>
        </div>
    </div>
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

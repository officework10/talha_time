   <div class="col-span-12 bg-[#F4F4F4] shadow-md p-3">
       <div class="col-span-12">
           <div class="col-lg-11 pacetabs">
               <div class="grid grid-cols-12 align-center bg-white font-s-12 text-center border radius-10 p-1">
                   @php
                       $types = ['length', 'temperature', 'area', 'volume', 'weight', 'time'];
                   @endphp

                   @foreach ($types as $type)
                       <div class="col-span-4 md:col-span-2 col-4 py-2 cursor-pointer radius-5 pacetab 
                        {{ $calculatorName === $type ? 'bg-blue-500 text-white' : '' }}"
                           wire:click="setCalculatorName('{{ $type }}')">
                           {{ ucfirst($type) }}
                       </div>
                   @endforeach
               </div>
           </div>
       </div>

       <div class="col-span-12 mt-4">
           <div class="grid grid-cols-12 gap-3">
               <div class="md:col-span-6 col-span-12">
                   <div class="grid grid-cols-12">
                       <div class="col-span-12 converter_input">
                           <label for="from" class="text-blue label">From:</label>
                           <div class="w-full pt-2">
                               <input type="number" wire:model.live="fromValue" id="from" class="input"
                                   aria-label="input" placeholder="00" />
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'length' ? '' : 'hidden' }}">
                           <label for="calFrom" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="fromUnit" wire:change="onFromUnitChange($event.target.value)"
                                   id="calFrom" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll">
                                   @foreach ($unitTypes['length'] as $value => $label)
                                       <option  value="{{ $value }}">{{ $label }}</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'temperature' ? '' : 'hidden' }}">
                           <label for="tcalFrom" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="fromUnit" wire:change="onFromUnitChange($event.target.value)"
                                   id="tcalFrom" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll">
                                   @foreach ($unitTypes['temperature'] as $value => $label)
                                       <option  value="{{ $value }}">{{ $label }}</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'area' ? '' : 'hidden' }}">
                           <label for="acalFrom" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="fromUnit" wire:change="onFromUnitChange($event.target.value)"
                                   id="acalFrom" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll ">
                                   @foreach ($unitTypes['area'] as $value => $label)
                                       <option  value="{{ $value }}">{{ $label }}</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'volume' ? '' : 'hidden' }}">
                           <label for="vcalFrom" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="fromUnit" wire:change="onFromUnitChange($event.target.value)"
                                   id="vcalFrom" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll">
                                   @foreach ($unitTypes['volume'] as $value => $label)
                                       <option  value="{{ $value }}">{{ $label }}</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'weight' ? '' : 'hidden' }}">
                           <label for="wcalFrom" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="fromUnit" wire:change="onFromUnitChange($event.target.value)"
                                   id="wcalFrom" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll">
                                   @foreach ($unitTypes['weight'] as $value => $label)
                                       <option  value="{{ $value }}">{{ $label }}</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'time' ? '' : 'hidden' }}">
                           <label for="tmcalFrom" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="fromUnit" wire:change="onFromUnitChange($event.target.value)"
                                   id="tmcalFrom" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll">
                                   @foreach ($unitTypes['time'] as $value => $label)
                                       <option value="{{ $value }}">{{ $label }}</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="md:col-span-6 col-span-12">
                   <div class="grid grid-cols-12">
                       <div class="col-span-12 converter_input">
                           <label for="to" class="text-blue label">To:</label>
                           <div class="w-full pt-2">
                               <input type="number" wire:model.live="toValue" id="to" class="input"
                                   aria-label="input" placeholder="00" />
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'length' ? '' : 'hidden' }}">
                           <label for="calto" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="toUnit" wire:change="onToUnitChange($event.target.value)"
                                   id="calto" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll ">
                                   @foreach ($unitTypes['length'] as $value => $label)
                                       <option  value="{{ $value }}">{{ $label }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div
                           class="col-span-12 unit_converters {{ $calculatorName === 'temperature' ? '' : 'hidden' }}">
                           <label for="tcalto" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="toUnit" wire:change="onToUnitChange($event.target.value)"
                                   id="tcalto" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll">
                                   @foreach ($unitTypes['temperature'] as $value => $label)
                                       <option  value="{{ $value }}">{{ $label }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'area' ? '' : 'hidden' }}">
                           <label for="acalto" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="toUnit" wire:change="onToUnitChange($event.target.value)"
                                   id="acalto" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll">
                                   @foreach ($unitTypes['area'] as $value => $label)
                                       <option  value="{{ $value }}">{{ $label }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'volume' ? '' : 'hidden' }}">
                           <label for="vcalto" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="toUnit" wire:change="onToUnitChange($event.target.value)"
                                   id="vcalto" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll">
                                   @foreach ($unitTypes['volume'] as $value => $label)
                                       <option value="{{ $value }}">{{ $label }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'weight' ? '' : 'hidden' }}">
                           <label for="wcalto" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="toUnit" wire:change="onToUnitChange($event.target.value)"
                                   id="wcalto" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll ">
                                   @foreach ($unitTypes['weight'] as $value => $label)
                                       <option value="{{ $value }}">{{ $label }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col-span-12 unit_converters {{ $calculatorName === 'time' ? '' : 'hidden' }}">
                           <label for="tmcalto" class="label">&nbsp;</label>
                           <div class="w-full bg-white rounded p-2 border">
                               <select wire:model="toUnit" wire:change="onToUnitChange($event.target.value)"
                                   id="tmcalto" size="{{ $device == 'desktop' ? 7 : 4 }}"
                                   class="unit-select-add custom-scroll ">
                                   @foreach ($unitTypes['time'] as $value => $label)
                                       <option value="{{ $value }}">{{ $label }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                   </div>
               </div>
            </div>
            <div class="col-span-12 md:col-span-12  mt-4 mx-auto whitespace-nowrap {{ $showResult ? '' : 'hidden' }}">
                <div class="flex items-center overflow-auto {{ $device == 'desktop' ? '' : 'flex-wrap' }}">
                    <strong
                        class="text-blue-600 text-lg font-bold me-2 {{ $device == 'desktop' ? '' : 'mb-2' }}">Result:</strong>
                    <div class="flex items-center bg-white border border-gray-300 rounded-lg px-3 py-2 w-fit">
                        <div class="result font-bold text-xl text-gray-900" id="resultcopyInput1">
                            {{ $result }}</div>
                        <span class="ml-2 text-gray-600" id="resultcopyInput2">{{ $resultUnit }}</span>
                        <button wire:click="copyResult" class="ml-3 text-gray-500 hover:text-gray-700">
                            <img src="{{ url('assets/icons/copy.png') }}" alt="Copy Result" title="Copy Result" class="w-[20px]">
                        </button>
                    </div>
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
               const resultUnit2 = document.getElementById('resultcopyInput2')?.innerText ?? '';

               const valueToCopy = resultUnit1 + ' - ' + resultUnit2;
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

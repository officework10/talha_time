<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;

class HoursCalculator extends Component
{
    public $type = 'calculator';
    public $error = null;
    public $detail = null;
    public $lang = [];

    // Start time
    public $hh;
    public $mm;
    public $ss;
    public $method = 'AM';

    // End time
    public $hhe;
    public $mme;
    public $sse;
    public $methode = 'PM';

    // Format
    public $outputformate = 'hr12';

    // Breaks
    public $breaks = [];

      public function mount($type = 'calculator', $lang = [])
    {
        // Set default values to current time
        $now = Carbon::now();

            $this->type = $type;
        $this->lang = $lang;
        
        // Previous result
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        // Persist form inputs if available
        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->hh = $oldInputs->hh ?? $now->format('h');
            $this->mm = $oldInputs->mm ?? $now->format('i');
            $this->ss = $oldInputs->ss ?? $now->format('s');
            $this->method = $oldInputs->method ?? $now->format('A');
            $this->hhe = $oldInputs->hhe ?? $now->format('h');
            $this->mme = $oldInputs->mme ?? $now->format('i');
            $this->sse = $oldInputs->sse ?? $now->format('s');
            $this->methode = $oldInputs->methode ?? $now->format('A');
            $this->outputformate = $oldInputs->outputformate ?? 'hr12';
            $this->breaks = $oldInputs->breaks ?? [];
        } else {
            $this->hh = $now->format('h');
            $this->mm = $now->format('i');
            $this->ss = $now->format('s');
            $this->method = $now->format('A');
            $this->hhe = $now->format('h');
            $this->mme = $now->format('i');
            $this->sse = $now->format('s');
            $this->methode = $now->format('A');
        }
      
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        
        // Reset inputs to default
        $now = Carbon::now();
        $this->hh = $now->format('h');
        $this->mm = $now->format('i');
        $this->ss = $now->format('s');
        $this->method = $now->format('A');
        $this->hhe = $now->format('h');
        $this->mme = $now->format('i');
        $this->sse = $now->format('s');
        $this->methode = $now->format('A');
        $this->outputformate = 'hr12';
        $this->breaks = [];

        // Clear outputs and errors
        $this->error = null;
        $this->detail = null;

        // Clear session
        session()->forget([
            'calculator_back_inputs',
            'calculator_result',
            'validation_error',
            'scroll_to_result'
        ]);
        
        return redirect()->to(url()->previous() ?? '/');
    }

    public function calculate()
    {
        $request = (object)[
            'hh' => $this->hh,
            'mm' => $this->mm,
            'ss' => $this->ss,
            'method' => $this->method,
            'hhe' => $this->hhe,
            'mme' => $this->mme,
            'sse' => $this->sse,
            'methode' => $this->methode,
            'outputformate' => $this->outputformate,
            'breaks' => $this->breaks,
        ];

        $model = new \App\Models\Timedate();
        $result = $model->hours($request);

        if (!empty($result['RESULT']) && $result['RESULT'] == 1) {
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', $request);
            $this->error = null;

            return redirect()->to(url()->previous() ?? '/');
        }

        // Handle error case
        $this->error = $result['error'] ?? 'Something went wrong.';
        $this->detail = null; // Clear any previous results
        session()->flash('validation_error', $this->error);
        session()->forget('calculator_result'); // Clear previous results from session
        session()->flash('calculator_back_inputs', $request);
        
        return redirect()->to(url()->previous() ?? '/');
    }

    public function render()
    {
        if (session('scroll_to_result')) {
            $this->js(<<<'JS'
                const el = document.getElementById('result-section');
                if (el) {
                    const offset = el.getBoundingClientRect().top + window.pageYOffset - 100;
                    window.scrollTo({ top: offset, behavior: 'smooth' });
                }
            JS);
        }

        // Add hour format and breaks functionality
        $this->js(<<<'JS'
            this.HourSelector = document.querySelectorAll('#hh, #hhe');
            this.MmPmSelect = document.querySelectorAll('.am_pm');
            this.fixLayoutCol = document.querySelectorAll('.fixLayoutCol');

            // Function to toggle 24-hour mode
            function toggle24HourMode(value) {
                const hourSelectors = document.querySelectorAll('#hh, #hhe');
                const amPmSelects = document.querySelectorAll('.am_pm');
                const layoutCols = document.querySelectorAll('.fixLayoutCol');
                
                if(value == "hr24"){
                    amPmSelects.forEach(element => {
                        element.style.display = 'none'
                    });
                    hourSelectors.forEach(element => {
                        element.setAttribute('max', 24);
                    });
                    layoutCols.forEach(element => {
                        element.classList.remove('col-span-3');
                        element.classList.add('col-span-4');
                    });
                }else{
                    amPmSelects.forEach(element => {
                        element.style.display = 'block'
                    });
                    layoutCols.forEach(element => {
                        element.classList.add('col-span-3');
                        element.classList.remove('col-span-4');
                    });
                    hourSelectors.forEach(element => {
                        element.setAttribute('max', 12);
                    });
                }
            }

            // Check initial state on page load
            const checkedRadio = document.querySelector('input[name="outputformate"]:checked');
            if(checkedRadio) {
                toggle24HourMode(checkedRadio.value);
            }

            // Listen for radio button changes
            document.querySelectorAll('input[name="outputformate"]').forEach((radio) => {
                radio.addEventListener('change', (event) => {
                    toggle24HourMode(event.target.value);
                });
            });

            // Listen for Livewire updates
            if (!window.hoursCalculatorListenerAdded) {
                document.addEventListener('livewire:update', function() {
                    const checkedRadio = document.querySelector('input[name="outputformate"]:checked');
                    if(checkedRadio) {
                        toggle24HourMode(checkedRadio.value);
                    }
                });
                window.hoursCalculatorListenerAdded = true;
            }

            class Breaks{
                constructor(){
                    const self = this
                    // Check if there are existing breaks to maintain count
                    const existingBreaks = document.querySelectorAll('.jsdivs');
                    this.count = existingBreaks.length > 0 ? existingBreaks.length : 0;
                    this.selector = document.querySelector('#breaks')
                    this.addBreak = document.querySelector('#addBreaks')
                    this.jsAddedDivs = document.querySelector('label.font-s-14.text-blue')

                    if(this.addBreak) {
                        this.addBreak.addEventListener('click', function(){
                            if(self.count < 5){
                                self.count++
                                self.selector.appendChild(self.appendDivs())
                            }
                        })
                    }
                }

                appendDivs() {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <div class="col-span-4 md:col-span-3 lg:col-span-3 mb-2 mt-2 p-1 p-lg-2 jsdivs">
                            <label for="months" class="text-[14px] text-blue flex relative w-full justify-between items-center" onclick="breaksInstance.removeDiv(this)">
                                <div>Break ${this.count}:</div>
                                <div class=""><img src="/images/assets/images/icons/delete_btn.png" width="15px" /></div>
                            </label>
                            <div class="w-full py-2 flex gap-3 items-center">
                                <input type="number" wire:model="breaks.${this.count - 1}" required max="1000" name="breaks_${this.count}" class="input input remove_shadow d" aria-label="input" />
                                Min
                            </div>
                        </div>`;
                    return div.firstElementChild;
                }

                removeDiv(element) {
                    element.parentElement.remove();
                    this.count--
                    this.updateNumbering();
                }

                updateNumbering() {
                    let divs = document.querySelectorAll('.jsdivs');
                    divs.forEach((div, index) => {
                        let label = div.querySelector('label');
                        if (label) {
                            label.innerHTML = `<div>Break ${index + 1}:</div><div class=""><img src="/images/assets/images/icons/delete_btn.png" width="15px" /></div>`;
                        }
                        let input = div.querySelector('input[name^="breaks_"]');
                        if (input) {
                            input.name = `breaks_${index + 1}`;
                        }
                        div.id = `break_${index + 1}`;
                    });
                    this.count = divs.length;
                }
            }
            
            if(!window.breaksInstance) {
                window.breaksInstance = new Breaks();
            }
        JS);

        return view('livewire.calculators.hours-calculator');
    }
}

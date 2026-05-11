<?php

namespace App\Livewire\Calculators;


use Livewire\Component;
use Illuminate\Http\Request;

class TimeToDecimal extends Component
{
    public $type = 'calculator';
    public $error = null;
    public $detail = null;
    public $lang = [];

    public $hh = 12;
    public $mm = 0;
    public $ss = 0;

      public function mount($type = 'calculator', $lang = [])
    {

         $this->type = $type;
        $this->lang = is_array($lang) ? $lang : [];
        // Previous result
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        // Persist form inputs if available
        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->hh = $oldInputs->hh ?? 12;
            $this->mm = $oldInputs->mm ?? 0;
            $this->ss = $oldInputs->ss ?? 0;
        } else {
             $this->hh = 12;
             $this->mm = 0;
             $this->ss = 0;
        }
    }

    public function calculate()
    {
        // Manual validation since we're using a model method that expects a Request object or array
        if (!is_numeric($this->hh) && !is_numeric($this->mm) && !is_numeric($this->ss)) {
            $this->error = 'Please enter a valid time.';
            return;
        }

        $request = new Request([
            'hh' => $this->hh,
            'mm' => $this->mm,
            'ss' => $this->ss,
            'submit' => true
        ]);

        $model = new \App\Models\Timedate();
        // The model method expects a Request object based on the snippet provided earlier
        $result = $model->time_to_decimal($request);

        if (!isset($result['error'])) {
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', (object)[
                'hh' => $this->hh,
                'mm' => $this->mm,
                'ss' => $this->ss
            ]);
            $this->error = null;

            return redirect()->to(url()->previous() ?? '/');
        }

        // Handle error case
        $this->error = $result['error'];
        $this->detail = null;
        session()->flash('validation_error', $this->error);
        session()->forget('calculator_result');
        session()->flash('calculator_back_inputs', (object)[
            'hh' => $this->hh,
            'mm' => $this->mm,
            'ss' => $this->ss
        ]);
        
        return redirect()->to(url()->previous() ?? '/');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        
        $this->hh = 12;
        $this->mm = 0;
        $this->ss = 0;
        $this->error = null;
        $this->detail = null;

        session()->forget([
            'calculator_back_inputs',
            'calculator_result',
            'validation_error',
            'scroll_to_result'
        ]);
        
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

        return view('livewire.calculators.time-to-decimal');
    }
}

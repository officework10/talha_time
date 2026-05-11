<?php

namespace App\Livewire\Calculators;

use Livewire\Component;

class TimeOfFlightCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $lang = [];

    // Inputs
    public $a = '45';
    public $a_unit = 'deg';
    public $h = '0';
    public $h_unit = 'm';
    public $v = '5';
    public $v_unit = 'ms';
    public $g = '9.81';
    public $g_unit = 'ms2';

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->a = $oldInputs->a ?? '45';
            $this->a_unit = $oldInputs->a_unit ?? 'deg';
            $this->h = $oldInputs->h ?? '0';
            $this->h_unit = $oldInputs->h_unit ?? 'm';
            $this->v = $oldInputs->v ?? '5';
            $this->v_unit = $oldInputs->v_unit ?? 'ms';
            $this->g = $oldInputs->g ?? '9.81';
            $this->g_unit = $oldInputs->g_unit ?? 'ms2';
        }
    }

    public function calculate()
    {
        $request = (object)[
            'a' => $this->a,
            'a_unit' => $this->a_unit,
            'h' => $this->h,
            'h_unit' => $this->h_unit,
            'v' => $this->v,
            'v_unit' => $this->v_unit,
            'g' => $this->g,
            'g_unit' => $this->g_unit,
        ];

        $model = new \App\Models\Timedate();
        $result = $model->time_flight($request);

        if (!empty($result['RESULT']) && $result['RESULT'] == 1) {
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', $request);
            $this->error = null;

            return redirect()->to(url()->previous() ?? '/');
        }

        $this->error = $result['error'] ?? 'Something went wrong.';
        session()->flash('validation_error', $this->error);
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        
        $this->a = '45';
        $this->a_unit = 'deg';
        $this->h = '0';
        $this->h_unit = 'm';
        $this->v = '5';
        $this->v_unit = 'ms';
        $this->g = '9.81';
        $this->g_unit = 'ms2';

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
        return view('livewire.calculators.time-of-flight-calculator');
    }
}

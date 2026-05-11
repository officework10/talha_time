<?php

namespace App\Livewire\Calculators;

use Livewire\Component;

use App\Models\Timedate;

class TimeDilationCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $lang = [];

    // Inputs
    public $interval = '1';
    public $interval_sec = '0';
    public $interval_unit = 'yrs';
    public $velocity = '0.8';
    public $velocity_unit = 'c';

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->interval = $oldInputs->interval ?? '1';
            $this->interval_sec = $oldInputs->interval_sec ?? '0';
            $this->interval_unit = $oldInputs->interval_unit ?? 'yrs';
            $this->velocity = $oldInputs->velocity ?? '0.8';
            $this->velocity_unit = $oldInputs->velocity_unit ?? 'c';
        }
    }

    public function calculate()
    {
        $request = (object)[
            'interval' => $this->interval,
            'interval_sec' => $this->interval_sec,
            'interval_unit' => $this->interval_unit,
            'velocity' => $this->velocity,
            'velocity_unit' => $this->velocity_unit,
        ];

        $model = new \App\Models\Timedate();
        $result = $model->dilation($request);

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
        
        $this->interval = '1';
        $this->interval_sec = '0';
        $this->interval_unit = 'yrs';
        $this->velocity = '0.8';
        $this->velocity_unit = 'c';

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
        return view('livewire.calculators.time-dilation-calculator');
    }
}

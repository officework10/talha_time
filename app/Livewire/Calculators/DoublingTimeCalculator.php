<?php

namespace App\Livewire\Calculators;

use Livewire\Component;

class DoublingTimeCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $lang = [];
    
    // Inputs
    public $want = '1';
    public $x = '5';

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->want = $oldInputs->want ?? '1';
            $this->x = $oldInputs->x ?? '5';
        }
    }

    public function calculate()
    {
        $request = (object)[
            'want' => $this->want,
            'x' => $this->x,
        ];

        $model = new \App\Models\Timedate();
        $result = $model->doubling($request);

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
        
        $this->want = '1';
        $this->x = '5';
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
        return view('livewire.calculators.doubling-time-calculator');
    }
}

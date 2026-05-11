<?php

namespace App\Livewire\Calculators;

use Livewire\Component;

class WorkingDaysCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $lang = [];
    public $start_date;
    public $end_date;
    public $working_days = 'Exclude only sunday';
    public $include_end_date = 'Yes';

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');
        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');
            // New values you're adding
            $this->start_date = $inputs->start_date ?? $this->start_date;
            $this->end_date = $inputs->end_date ?? $this->end_date;
            $this->working_days = $inputs->working_days ?? $this->working_days;
            $this->include_end_date = $inputs->include_end_date ?? $this->include_end_date;
        }
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();

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
    public function calculate()
    {
        $request = (object)[
            'start_date'  => $this->start_date,
            'end_date' => $this->end_date,
            'working_days' => $this->working_days,
            'include_end_date' => $this->include_end_date,
        ];

        $result = app(\App\Repositories\Interfaces\CalculatorRepositoryInterface::class)->working(new \Illuminate\Http\Request((array)$request));
        if (!empty($result['RESULT']) && $result['RESULT'] == 1) {
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', $request);
            $this->error = null;

            return redirect()->to(url()->previous() ?? '/');
        }

        $this->error = $result['error'] ?? 'Something went wrong.';
        session()->flash('validation_error', $this->error);
        $this->detail = null;
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
        return view('livewire.calculators.working-days-calculator');
    }
}

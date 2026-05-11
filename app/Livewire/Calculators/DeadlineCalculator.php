<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;

class DeadlineCalculator extends Component
{

    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $lang = [];
    public $date;
    public $period = 'Days';
    public $Number = 40;
    public $before_after = 'After';


    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->date = Carbon::now()->format('Y-m-d');
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');
        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');
            // New values you're adding
            $this->date = $inputs->date ?? $this->date;
            $this->period = $inputs->period ?? $this->period;
            $this->Number = $inputs->Number ?? $this->Number;
            $this->before_after = $inputs->before_after ?? $this->before_after;
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
            'date'  => $this->date,
            'period' => $this->period,
            'Number' => $this->Number,
            'before_after' => $this->before_after,
        ];


        $model =  new \App\Models\Timedate();
        $result = $model->deadline($request);
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
        return view('livewire.calculators.deadline-calculator');
    }
}

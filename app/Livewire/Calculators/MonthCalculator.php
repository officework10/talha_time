<?php

namespace App\Livewire\Calculators;

use Carbon\Carbon;
use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class MonthCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $lang = [];
    public $start_date;
    public $end_date;

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');

            $this->start_date = $inputs->start_date ?? Carbon::now()->format('Y-m-d');
            $this->end_date = $inputs->end_date ?? Carbon::now()->addYear()->addMonth()->format('Y-m-d');
        } else {
            $this->start_date = Carbon::now()->format('Y-m-d');
            $this->end_date = Carbon::now()->addYear()->addMonth()->format('Y-m-d');
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
        try {
            $this->validate([
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
        } catch (ValidationException $e) {
            $this->error = 'Please! Check your input.';
            session()->flash('validation_error', $this->error);
            $this->detail = null;
            return;
        }
        $request = (object)[
            'start_date'  => $this->start_date,
            'end_date' => $this->end_date,
        ];


        $result = app(CalculatorRepositoryInterface::class)->month(new Request((array)$request));
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
        return view('livewire.calculators.month-calculator');
    }
}

<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class OvertimeCalculator extends Component
{
    public $type = 'calculator';
    public $lang = [];
    public $currencySymbol = '$';

    public $pay = '10';
    public $per = 'hour';
    public $time = '5';
    public $timeper = 'h_m';
    public $overtime = 'half';
    public $multi = '1.5';
    public $over = '10';

    public $error = null;
    public $detail = null;
    public $overPayPerHour = null;

    public function mount($type = 'calculator', $lang = [], $currencySymbol = '$')
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->currencySymbol = $currencySymbol;

        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        // Preserve inputs if they exist in session
        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->pay = $oldInputs->pay ?? $this->pay;
            $this->per = $oldInputs->per ?? $this->per;
            $this->time = $oldInputs->time ?? $this->time;
            $this->timeper = $oldInputs->timeper ?? $this->timeper;
            $this->overtime = $oldInputs->overtime ?? $this->overtime;
            $this->multi = $oldInputs->multi ?? $this->multi;
            $this->over = $oldInputs->over ?? $this->over;
        }

        if ($this->detail) {
            $this->overPayPerHour = $this->detail['overPayPerHour'] ?? null;
        }
    }

    public function updatedOvertime($value)
    {
        if ($value == 'half') {
            $this->multi = '1.5';
        } elseif ($value == 'double') {
            $this->multi = '2';
        } elseif ($value == 'triple') {
            $this->multi = '3';
        } else {
            $this->multi = '';
        }
    }

    public function calculate()
    {
        $requestData = [
            'pay' => $this->pay,
            'per' => $this->per,
            'time' => $this->time,
            'timeper' => $this->timeper,
            'multi' => $this->multi,
            'over' => $this->over,
            'overtime' => $this->overtime, // Passing this even if model doesn't strictly use it yet
        ];

        $pseudoRequest = request();
        $pseudoRequest->merge($requestData);

        $result = app(CalculatorRepositoryInterface::class)->overtime($pseudoRequest);

        if (isset($result['RESULT']) && $result['RESULT'] == 1) {
            $result['currencySymbol'] = $this->currencySymbol;
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', (object)$requestData);
            $this->error = null;

            return redirect()->to(url()->previous() ?? '/');
        }

        $this->error = $result['error'] ?? 'Something went wrong.';
        session()->flash('validation_error', $this->error);
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
        return view('livewire.calculators.overtime-calculator');
    }
}

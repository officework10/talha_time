<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class YearsFromToday extends Component
{
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';

    public $number = null;        // selected day from buttons or custom input
    public $customNumber = null;  // user-entered custom number

    public $days = [4, 8, 12, 16, 20, 24];
    public $current;

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');
        $this->current = Carbon::today()->format('Y-m-d');

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');
            $this->current = $inputs->current ?? $this->current;
            $this->number = $inputs->number ?? $this->number ?? null;

            // If number is not in days array, treat it as customNumber
            if ($this->number !== null && !in_array($this->number, $this->days)) {
                $this->customNumber = $this->number;
            }
        }
    }
    public function setNow()
    {
        $this->current = Carbon::today()->format('Y-m-d');
    }

    // User clicks a day button
    public function selectDay($day)
    {
        $this->number = $day;
        $this->customNumber = null; // clear custom input if button selected
    }

    // User types in custom number input
    public function updatedCustomNumber($value)
    {
        if (is_numeric($value) && (int)$value > 0) {
            $this->number = (int)$value;
        } else {
            $this->number = null;
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
            'current' => $this->current ?? null,
            'number' => $this->number ?? null,
            'type' => $this->type ?? null,
        ];
        // dd($request);
        $result = app(CalculatorRepositoryInterface::class)->years_from(new Request((array)$request));
        // dd($result);
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
            const offset = 30;
            const top = el.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top: top, behavior: 'smooth' });
        }
       JS);
        }
        return view('livewire.calculators.years-from-today');
    }
}

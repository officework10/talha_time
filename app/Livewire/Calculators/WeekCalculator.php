<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class WeekCalculator extends Component
{

    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';
    public $stype = 's_date'; // default selected
    public $current;
    public $next;
    public $number;
    

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        // Set default values first
        $this->current = now()->toDateString();
        $this->next = now()->addMonth()->toDateString();
        $this->stype = 's_date';
        $this->number = null;

        // If previous inputs exist in session, restore them
        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');

            $this->stype = $inputs->stype ?? $this->stype;
            $this->current = $inputs->current ?? $this->current;
            $this->next = $inputs->next ?? $this->next;
            $this->number = $inputs->number ?? $this->number;
        }
    }

    public function changeOperation($value)
    {
        $this->stype = $value;
        // Reset or modify inputs if needed when stype changes
        if ($value === 'date') {
            $this->number = null;
        } else {
            $this->next = now()->addMonth()->toDateString();
        }
    }

    public function getSymbolProperty()
    {
        return match ($this->stype) {
            's_date' => '➕',
            'e_date' => '➖',
            'date'   => '⇢',
            default  => '',
        };
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
            'stype'   => $this->stype,
            'current' => $this->current,
            'next'    => $this->next,
            'number'  => $this->number,
            'type'    => $this->type,
        ];


        $result = app(CalculatorRepositoryInterface::class)->week_calc(new Request((array)$request));
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
        return view('livewire.calculators.week-calculator');
    }
}

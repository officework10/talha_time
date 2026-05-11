<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BirthYearCalculator extends Component
{

    public $error;
    public $type = 'calculator';
    public $lang = [];
    public $detail = null;
    public $date;
    public $age = 25;
    public $age_unit = 'years'; // default
    public $choose = 'after';


    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        if (!$this->date) {
            $this->date = Carbon::now()->format('Y-m-d');
        }
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');
        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');
            // New values you're adding
            $this->date = $inputs->date ?? $this->date;
            $this->age = $inputs->age ?? $this->age;
            $this->age_unit = $inputs->age_unit ?? $this->age_unit;
            $this->choose = $inputs->choose ?? $this->choose;
        }
    }

    public function setPreUnit($unit)
    {
        $this->age_unit = $unit;
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
            'date' => $this->date,
            'age' => $this->age,
            'age_unit' => $this->age_unit,
            'choose' => $this->choose,

        ];
        $result = app(CalculatorRepositoryInterface::class)->birthyear(new Request((array)$request));
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
        return view('livewire.calculators.birth-year-calculator');
    }
}

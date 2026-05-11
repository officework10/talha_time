<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class DaysSinceDateCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';
    public $month, $day, $year;
    public $month1, $day1, $year1;
    public $currentYear;
    public $daysLeft = null;
    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        $today = Carbon::today();

        // First date defaults
        $this->month = $today->month;
        $this->day = $today->day;
        $this->year = $today->copy()->subYear(25)->year;

        // Second date defaults
        $this->month1 = $today->month;
        $this->day1 = $today->day;
        $this->year1 = $today->year;

        $this->currentYear = now()->year;

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');

            $this->month = $inputs->month ?? $this->month;
            $this->day = $inputs->day ?? $this->day;
            $this->year = $inputs->year ?? $this->year;
            $this->month1 = $inputs->month1 ?? $this->month1;
            $this->day1 = $inputs->day1 ?? $this->day1;
            $this->year1 = $inputs->year1 ?? $this->year1;
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
            'month' => $this->month ?? null,
            'day' => $this->day ?? null,
            'year' => $this->year ?? null,
            'month1' => $this->month1 ?? null,
            'day1' => $this->day1 ?? null,
            'year1' => $this->year1 ?? null,
        ];
        $result = app(CalculatorRepositoryInterface::class)->days_since(new Request((array)$request));
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
        return view('livewire.calculators.days-since-date-calculator');
    }
}

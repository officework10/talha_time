<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class TimeDurationCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';
    public $calculator_time = 'date_cal'; // Default to date calculator

    // Date calculator fields
    public $start_date;
    public $d_start_h = 8;
    public $d_start_m = 30;
    public $d_start_s = 0;
    public $d_start_ampm = 'am';
    
    public $end_date;
    public $d_end_h = 5;
    public $d_end_m = 30;
    public $d_end_s = 0;
    public $d_end_ampm = 'pm';

    // Time calculator fields
    public $t_start_h = 8;
    public $t_start_m = 30;
    public $t_start_s = 0;
    public $t_start_ampm = 'am';
    
    public $t_end_h = 5;
    public $t_end_m = 30;
    public $t_end_s = 0;
    public $t_end_ampm = 'pm';

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = is_array($lang) ? $lang : [];
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        // Set default dates to today
        $this->start_date = now()->format('Y-m-d');
        $this->end_date = now()->format('Y-m-d');

        // Restore previous inputs if available
        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');

            $this->calculator_time = $inputs->calculator_time ?? $this->calculator_time;

            // Date calculator fields
            $this->start_date = $inputs->start_date ?? $this->start_date;
            $this->d_start_h = $inputs->d_start_h ?? $this->d_start_h;
            $this->d_start_m = $inputs->d_start_m ?? $this->d_start_m;
            $this->d_start_s = $inputs->d_start_s ?? $this->d_start_s;
            $this->d_start_ampm = $inputs->d_start_ampm ?? $this->d_start_ampm;
            
            $this->end_date = $inputs->end_date ?? $this->end_date;
            $this->d_end_h = $inputs->d_end_h ?? $this->d_end_h;
            $this->d_end_m = $inputs->d_end_m ?? $this->d_end_m;
            $this->d_end_s = $inputs->d_end_s ?? $this->d_end_s;
            $this->d_end_ampm = $inputs->d_end_ampm ?? $this->d_end_ampm;

            // Time calculator fields
            $this->t_start_h = $inputs->t_start_h ?? $this->t_start_h;
            $this->t_start_m = $inputs->t_start_m ?? $this->t_start_m;
            $this->t_start_s = $inputs->t_start_s ?? $this->t_start_s;
            $this->t_start_ampm = $inputs->t_start_ampm ?? $this->t_start_ampm;
            
            $this->t_end_h = $inputs->t_end_h ?? $this->t_end_h;
            $this->t_end_m = $inputs->t_end_m ?? $this->t_end_m;
            $this->t_end_s = $inputs->t_end_s ?? $this->t_end_s;
            $this->t_end_ampm = $inputs->t_end_ampm ?? $this->t_end_ampm;
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
            'calculator_time' => $this->calculator_time,
            
            // Date calculator fields
            'start_date' => $this->start_date,
            'd_start_h' => $this->d_start_h,
            'd_start_m' => $this->d_start_m,
            'd_start_s' => $this->d_start_s,
            'd_start_ampm' => $this->d_start_ampm,
            
            'end_date' => $this->end_date,
            'd_end_h' => $this->d_end_h,
            'd_end_m' => $this->d_end_m,
            'd_end_s' => $this->d_end_s,
            'd_end_ampm' => $this->d_end_ampm,
            
            // Time calculator fields
            't_start_h' => $this->t_start_h,
            't_start_m' => $this->t_start_m,
            't_start_s' => $this->t_start_s,
            't_start_ampm' => $this->t_start_ampm,
            
            't_end_h' => $this->t_end_h,
            't_end_m' => $this->t_end_m,
            't_end_s' => $this->t_end_s,
            't_end_ampm' => $this->t_end_ampm,
        ];

        $result = app(CalculatorRepositoryInterface::class)->time_duration(new Request((array)$request));

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

    public function changeOperation($value)
    {
        $this->calculator_time = $value;
    }

    public function render()
    {
        // Scroll to results if needed
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
        
        return view('livewire.calculators.time-duration-calculator');
    }
}
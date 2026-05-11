<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TimeSpanCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $lang = [];
    public $clock_format = '12';

    public $s_hour = 7;
    public $s_min = 30;
    public $s_sec = 0;
    public $s_ampm = 'pm';

    public $e_hour = 1;
    public $e_min = 30;
    public $e_sec = 0;
    public $e_ampm = 'am';



    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = is_array($lang) ? $lang : [];
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        // Restore old inputs if any
        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');

            $this->clock_format = $inputs->clock_format ?? $this->clock_format;

            $this->s_hour = $inputs->s_hour ?? $this->s_hour;
            $this->s_min = $inputs->s_min ?? $this->s_min;
            $this->s_sec = $inputs->s_sec ?? $this->s_sec;
            $this->s_ampm = $inputs->s_ampm ?? $this->s_ampm;

            $this->e_hour = $inputs->e_hour ?? $this->e_hour;
            $this->e_min = $inputs->e_min ?? $this->e_min;
            $this->e_sec = $inputs->e_sec ?? $this->e_sec;
            $this->e_ampm = $inputs->e_ampm ?? $this->e_ampm;
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

    public function changeOperation($value)
    {
        $this->clock_format = $value;
    }


    public function calculate()
    {
        try {
            // Conditional validation rules based on clock format
            $rules = [
                's_min' => 'required|integer|min:0|max:59',
                's_sec' => 'required|integer|min:0|max:59',
                'e_min' => 'required|integer|min:0|max:59',
                'e_sec' => 'required|integer|min:0|max:59',
            ];

            if ($this->clock_format == '12') {
                $rules['s_hour'] = 'required|integer|min:1|max:12';
                $rules['e_hour'] = 'required|integer|min:1|max:12';
            } else {
                $rules['s_hour'] = 'required|integer|min:0|max:23';
                $rules['e_hour'] = 'required|integer|min:0|max:23';
            }

            $this->validate($rules);
        } catch (ValidationException $e) {
            $this->error = 'Please check your time inputs (hours, minutes, seconds).';
            session()->flash('validation_error', $this->error);
            $this->detail = null;
            return;
        }
        $request = (object)[
            'clock_format' => $this->clock_format,
            's_hour' => $this->s_hour,
            's_min' => $this->s_min,
            's_sec' => $this->s_sec,
            's_ampm' => $this->s_ampm,
            'e_hour' => $this->e_hour,
            'e_min' => $this->e_min,
            'e_sec' => $this->e_sec,
            'e_ampm' => $this->e_ampm,


        ];
        $result = app(CalculatorRepositoryInterface::class)->timespan(new Request((array)$request));
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
        return view('livewire.calculators.time-span-calculator');
    }
}

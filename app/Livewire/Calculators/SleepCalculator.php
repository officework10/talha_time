<?php

namespace App\Livewire\Calculators;

use Livewire\Component;

class SleepCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $lang = [];

    // Inputs
    public $time_type = 'sleep'; // 'sleep' or 'sleep_length'
    public $stype = 'wkup'; // 'wkup' or 'bedtime'
    public $h = '06:00'; // Target time for SimpleSleep
    public $sleep_type = 'sleep_wkup'; // 'sleep_wkup' or 'sleep_bedtime'
    public $h1 = '06:00'; // Target time for SleepLength
    public $sleephour = '8';
    public $sleep_minutes = '30';

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->time_type = $oldInputs->time_type ?? 'sleep';
            $this->stype = $oldInputs->stype ?? 'wkup';
            $this->h = $oldInputs->h ?? '06:00';
            $this->sleep_type = $oldInputs->sleep_type ?? 'sleep_wkup';
            $this->h1 = $oldInputs->h1 ?? '06:00';
            $this->sleephour = $oldInputs->sleephour ?? '8';
            $this->sleep_minutes = $oldInputs->sleep_minutes ?? '30';
        }
    }

    public function setTime($field, $value)
    {
        $now = now();
        if ($value === 'now') {
            $this->$field = $now->format('H:i');
        } elseif ($value === '30m') {
            $this->$field = $now->addMinutes(30)->format('H:i');
        } elseif ($value === '1h') {
            $this->$field = $now->addHour()->format('H:i');
        }
    }

    public function calculate($submitType = null)
    {
        if (!$submitType) {
            $submitType = ($this->time_type === 'sleep') ? 'SimpleSleep' : 'SleepLength';
        }

        $request = (object)[
            'submit' => $submitType, // 'SimpleSleep' or 'SleepLength'
            'stype' => $this->stype,
            'h' => $this->h,
            'sleep_type' => $this->sleep_type,
            'h1' => $this->h1,
            'sleephour' => $this->sleephour,
            'sleep_minutes' => $this->sleep_minutes,
            'time_type' => $this->time_type,
        ];

        $model = new \App\Models\Timedate();
        $result = $model->SleepCalculator($request);

        if (!empty($result)) {
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', $request);
            $this->error = null;

            return redirect()->to(url()->previous() ?? '/');
        }

        $this->error = 'Something went wrong.';
        session()->flash('validation_error', $this->error);
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        
        $this->time_type = 'sleep';
        $this->stype = 'wkup';
        $this->h = '06:00';
        $this->sleep_type = 'sleep_wkup';
        $this->h1 = '06:00';
        $this->sleephour = '8';
        $this->sleep_minutes = '30';

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
        return view('livewire.calculators.sleep-calculator');
    }
}

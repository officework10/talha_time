<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class HoursAgoCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';
    public $outputFormat = 'twhr';

    // Time inputs
    public $timeType = 'stat';
    public $hours = '';
    public $minutes = '';
    public $seconds = '';

    // Time to add
    public $hrs = '';
    public $min = '';

    public $isLive = true;

    protected $listeners = ['refreshTime' => 'updateTime'];

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');
            $this->hours = $inputs['hours'] ?? $this->hours;
            $this->minutes = $inputs['minuts'] ?? $this->minutes;
            $this->seconds = $inputs['sec'] ?? $this->seconds;
            $this->hrs = $inputs['hrs'] ?? $this->hrs;
            $this->min = $inputs['min'] ?? $this->min;
            $this->outputFormat = $inputs['outputFormat'] ?? $this->outputFormat;
            $this->timeType = $inputs['timeType'] ?? $this->timeType;
            $this->isLive = $inputs['isLive'] ?? $this->isLive;
        }

        $this->updateTime();
    }

    public function toggleLive()
    {
        $this->isLive = !$this->isLive;
        $this->timeType = $this->isLive ? 'stat' : 'dyna';
    }

    public function updateTime()
    {
        if ($this->timeType === 'stat' && $this->isLive) {
            $now = Carbon::now();
            $this->hours = str_pad($now->hour, 2, '0', STR_PAD_LEFT);
            $this->minutes = str_pad($now->minute, 2, '0', STR_PAD_LEFT);
            $this->seconds = str_pad($now->second, 2, '0', STR_PAD_LEFT);
        }
    }

    public function updatedTimeType($value)
    {
        $this->isLive = ($value === 'stat');
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
        $request = [
            'hours' => $this->hours ?? null,
            'minuts' => $this->minutes ?? null,
            'sec' => $this->seconds ?? null,
            'hrs' => $this->hrs ?? null,
            'min' => $this->min ?? null,
            'outputFormat' => $this->outputFormat,
            'timeType' => $this->timeType,
            'isLive' => $this->isLive
        ];
        $result = app(CalculatorRepositoryInterface::class)->time_ago(new Request($request));

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
        return view('livewire.calculators.hours-ago-calculator');
    }
}

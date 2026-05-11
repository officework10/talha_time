<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class PlaybackSpeedCalculator extends Component
{
    public $hours = 1;
    public $minutes = 0;
    public $seconds = 0;
    public $speed = 1.5;

    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');
            $this->hours = $inputs['hours'] ?? $this->hours;
            $this->minutes = $inputs['minutes'] ?? $this->minutes;
            $this->seconds = $inputs['seconds'] ?? $this->seconds;
            $this->speed = $inputs['speed'] ?? $this->speed;
        }
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->error = null;
        $this->detail = null;
        $this->hours = 1;
        $this->minutes = 0;
        $this->seconds = 0;
        $this->speed = 1.5;

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
            'hours' => $this->hours,
            'minutes' => $this->minutes,
            'seconds' => $this->seconds,
            'speed' => $this->speed,
        ];

        $result = app(CalculatorRepositoryInterface::class)->playback_speed_calculator(new Request((array)$request));

        if (!empty($result['RESULT']) && $result['RESULT'] == 1) {
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', [
                'hours' => $this->hours,
                'minutes' => $this->minutes,
                'seconds' => $this->seconds,
                'speed' => $this->speed,
            ]);
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
        return view('livewire.calculators.playback-speed-calculator');
    }
}

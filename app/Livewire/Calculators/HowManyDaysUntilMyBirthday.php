<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class HowManyDaysUntilMyBirthday extends Component
{
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';

    public $month;
    public $day;
    public $year;
    public $name;
    public $currentYear;
    public $nextBirthday;
    
    // Countdown properties
    public $countdownDays = '000';
    public $countdownHours = '00';
    public $countdownMinutes = '00';
    public $countdownSeconds = '00';
    public $countdownActive = false;

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;

        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        $today = Carbon::today();

        // Defaults
        $this->month = $today->month;
        $this->day = $today->day;
        $this->year = $today->year;
        $this->currentYear = $today->year;

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');

            $this->month = $inputs->month ?? $this->month;
            $this->day = $inputs->day ?? $this->day;
            $this->year = $inputs->year ?? $this->year;
            $this->name = $inputs->name ?? $this->name;
        }

        // Restart countdown if we have a result
        if ($this->detail && isset($this->detail['nextBirthday'])) {
            $this->nextBirthday = $this->detail['nextBirthday'];
            $this->startCountdown($this->nextBirthday);
        }
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $this->error = null;
        $this->detail = null;
        $this->countdownActive = false;

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
        $request = (object) [
            'month' => $this->month,
            'day'   => $this->day,
            'year'  => $this->year,
            'name'  => $this->name,
        ];

        $result = app(CalculatorRepositoryInterface::class)->birthday_days(new Request((array)$request));

        if (!empty($result['RESULT']) && $result['RESULT'] == 1) {
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', $request);

            $this->error = null;
            $this->detail = $result;
            $this->nextBirthday = $result['nextBirthday'];
            
            // Start the countdown
            $this->startCountdown($this->nextBirthday);

            return redirect()->to(url()->previous() ?? '/');
        }

        $this->error = $result['error'] ?? 'Something went wrong.';
        session()->flash('validation_error', $this->error);
        $this->detail = null;
    }

    public function startCountdown($targetDate)
    {
        $this->countdownActive = true;
        $this->updateCountdown($targetDate);
    }

   public function updateCountdown()
    {
        if (!$this->countdownActive || !$this->nextBirthday) {
            return;
        }

        $target = Carbon::parse($this->nextBirthday);
        $now = Carbon::now();
        
        if ($now >= $target) {
            $this->countdownActive = false;
            $this->countdownDays = '000';
            $this->countdownHours = '00';
            $this->countdownMinutes = '00';
            $this->countdownSeconds = '00';
            return;
        }

        $diff = $now->diff($target);
        
        $this->countdownDays = str_pad($diff->days, 3, '0', STR_PAD_LEFT);
        $this->countdownHours = str_pad($diff->h, 2, '0', STR_PAD_LEFT);
        $this->countdownMinutes = str_pad($diff->i, 2, '0', STR_PAD_LEFT);
        $this->countdownSeconds = str_pad($diff->s, 2, '0', STR_PAD_LEFT);

        // Schedule next update
        $this->dispatch('schedule-countdown-update');
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

        return view('livewire.calculators.how-many-days-until-my-birthday');
    }
}
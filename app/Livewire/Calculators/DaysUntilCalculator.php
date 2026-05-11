<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class DaysUntilCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';
    public $startEvent = 'empty';
    public $device;
    public $next;
    public $current;
    public $inc_all = true;   // default checked hai jab $detail nahi hoga
    public $inc_day = false;
    public array $weekDay = ['Mon', 'Tue'];

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');
        $this->current = now()->toDateString();
        $this->next = now()->addMonth()->toDateString();

        $this->inc_all = request()->has('inc_all') && request('inc_all') == 'on' ? true : true; // default true
        $this->inc_day = request()->has('inc_day') && request('inc_day') == 'on' ? true : false;

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');
            $this->startEvent = $inputs->startEvent ?? $this->startEvent;
            $this->next = $inputs->next ?? $this->next;
            $this->current = $inputs->current ?? $this->current;
            $this->inc_all = $inputs->inc_all ?? $this->inc_all;
            $this->inc_day = $inputs->inc_day ?? $this->inc_day;
            $this->weekDay = $inputs->weekDay ?? $this->weekDay;
        }
    }


    public function changeinc_all() {}
    public function changestartEvent()
    {
        $value = $this->startEvent;
        $currentDate = now();
        $currentYear = $currentDate->year;

        switch ($value) {
            case 'Thanksgiving (Canada)':
                $eventDate = now()->setYear($currentYear)->setMonth(10)->setDay(14);
                break;
            case 'Halloween':
                $eventDate = now()->setYear($currentYear)->setMonth(10)->setDay(31);
                break;
            case 'Thanksgiving (US)':
                $eventDate = now()->setYear($currentYear)->setMonth(11)->setDay(28);
                break;
            case 'Christmas':
                $eventDate = now()->setYear($currentYear)->setMonth(12)->setDay(25);
                break;
            case "New Year's Eve":
                $eventDate = now()->setYear($currentYear + 1)->setMonth(1)->setDay(1);
                break;
            case 'Easter (Easter Sunday)':
                $eventDate = now()->setYear($currentYear + 1)->setMonth(4)->setDay(20);
                break;
            default:
                $eventDate = now()->setYear($currentYear + 1)->setMonth(1)->setDay(1);
                break;
        }

        if ($eventDate->lessThan($currentDate)) {
            $eventDate = $eventDate->addYear();
        }

        $this->next = $eventDate->toDateString();
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
            'startEvent' => $this->startEvent,
            'next'       => $this->next,
            'current'    => $this->current,
            'inc_all'    => $this->inc_all,
            'inc_day'    => $this->inc_day,
            'weekDay'    => $this->weekDay,
        ];


        $result = app(CalculatorRepositoryInterface::class)->days_until(new Request((array)$request));
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
        return view('livewire.calculators.days-until-calculator');
    }
}

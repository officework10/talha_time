<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class MilitaryTimeConverter extends Component
{
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';

    public $conversion = '1';
    public $military_time = '1234';
    public $hur = '7';
    public $min = '17';
    public $am_pm = 'pm';
    public $hours = '12h';
    public string $amPm = 'pm';   // For AM/PM
    public string $hourFormat = '12h'; // For 12/24 hour toggle
    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = is_array($lang) ? $lang : [];
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');

            $this->conversion = $inputs->conversion ?? $this->conversion;
            $this->military_time = $inputs->military_time ?? $this->military_time;
            $this->hur = $inputs->hur ?? $this->hur;
            $this->min = $inputs->min ?? $this->min;
            $this->am_pm = $inputs->am_pm ?? $this->am_pm;
            $this->hours = $inputs->hours ?? $this->hours;

            // These two just reflect same values for internal use
            $this->amPm = $this->am_pm;
            $this->hourFormat = $this->hours;
        }
    }


    public function setAmPm($value)
    {
        $this->amPm = $value;
    }

    public function setHourFormat($value)
    {
        $this->hourFormat = $value;
        $this->hours = $value;
    }


    public function changeconversion()
    {

        //dd($this->conversion); // Will show '1' or '2'
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
            'conversion'         => $this->conversion,
            'military_time'     => $this->military_time,
            'hur'    => $this->hur,
            'min'       => $this->min,
            'am_pm'      => $this->am_pm,
            'hours'    => $this->hours,
            // 'amPm'   => $this->amPm,
        ];


        $result = app(CalculatorRepositoryInterface::class)->military_time(new Request((array)$request));
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
        return view('livewire.calculators.military-time-converter');
    }
}

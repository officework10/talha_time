<?php

namespace App\Livewire\Calculators;
use Livewire\Component;

use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class DateCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $language = 'en';
    public $lang = [];

    // Input fields
    public $method = 'add';
    public $years;
    public $months;
    public $weeks = '';
    public $days = '';
    public $add_hrs_f;
    public $add_min_f;
    public $add_sec_f;
    public $add_hrs_s = '';
    public $add_min_s = '';
    public $add_sec_s = '';
    public $add_date;
    public $checkbox = false;
    public $repeat = null;
    public string $inctime = 'time_in';
    public $calName;
    public $calLink;
    public function mount($type = 'calculator', $lang = [], $calName = null, $calLink = null)
    {
        $this->calName = $calName;
        $this->calLink = $calLink;
        $this->type = $type;
        $this->lang = $lang;
        // Previous result
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        // Persist form inputs if available
        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->method = $oldInputs->method ?? 'add';
            $this->years = $oldInputs->years ?? '';
            $this->months = $oldInputs->months ?? '';
            $this->weeks = $oldInputs->weeks ?? '';
            $this->days = $oldInputs->days ?? '';
            $this->add_hrs_f = $oldInputs->add_hrs_f ?? '';
            $this->add_min_f = $oldInputs->add_min_f ?? '';
            $this->add_sec_f = $oldInputs->add_sec_f ?? '';
            $this->add_hrs_s = $oldInputs->add_hrs_s ?? '';
            $this->add_min_s = $oldInputs->add_min_s ?? '';
            $this->add_sec_s = $oldInputs->add_sec_s ?? '';
            $this->add_date = $oldInputs->add_date ?? date('Y-m-d');
            $this->inctime = $oldInputs->inctime ?? 'time_in';
            $this->repeat = $oldInputs->repeat ?? null;
            $this->checkbox = $oldInputs->repeat !== null;
        } else {
            $this->add_date = date('Y-m-d');
        }
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        // Reset inputs to default
        $this->method = 'add';
        $this->add_date = date('Y-m-d');
        $this->years = '';
        $this->months = '';
        $this->weeks = '';
        $this->days = '';
        $this->add_hrs_f = '';
        $this->add_min_f = '';
        $this->add_sec_f = '';
        $this->add_hrs_s = '';
        $this->add_min_s = '';
        $this->add_sec_s = '';
        $this->checkbox = false;
        $this->repeat = null;
        $this->inctime = 'time_in';

        // Clear outputs and errors
        $this->error = null;
        $this->detail = null;

        // Optionally clear session
        session()->forget([
            'calculator_back_inputs',
            'calculator_result',
            'validation_error',
            'scroll_to_result'
        ]);
         return redirect()->to(url()->previous() ?? '/');
    }




    public function changeOperation()
    {
        $this->inctime = $this->inctime === 'time_in' ? 'time_out' : 'time_in';
    }

    public function changeMethod()
    {
        $this->detail = null;
    }


    public function calculate()
    {
        $request = (object)[
            'method' => $this->method,
            'years' => $this->years,
            'months' => $this->months,
            'weeks' => $this->weeks,
            'days' => $this->days,
            'add_hrs_f' => $this->add_hrs_f,
            'add_min_f' => $this->add_min_f,
            'add_sec_f' => $this->add_sec_f,
            'add_hrs_s' => $this->add_hrs_s,
            'add_min_s' => $this->add_min_s,
            'add_sec_s' => $this->add_sec_s,
            'add_date' => $this->add_date,
            'repeat' => $this->checkbox ? $this->repeat : null,
            'inctime' => $this->inctime,
            'language' => $this->language,
        ];

        $result = app(CalculatorRepositoryInterface::class)->date(new Request((array)$request));

        if (!empty($result['RESULT']) && $result['RESULT'] == 1) {
            // Add formatted date and time for the new layout
            $fromDateTime = \Illuminate\Support\Carbon::parse($result['from']);
            $result['formatted_date'] = $fromDateTime->format('M d, Y');
            $result['formatted_time'] = $fromDateTime->format('h:i:s A');
            $result['add_hrs_s'] = $this->add_hrs_s ?: 0;
            $result['add_min_s'] = $this->add_min_s ?: 0;
            $result['add_sec_s'] = $this->add_sec_s ?: 0;

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

        return view('livewire.calculators.date-calculator');
    }
}

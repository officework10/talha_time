<?php
namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeAndAHalfCalculator extends Component
{
    public $daily_rate = 15;
    public $working_hour = 8;
    public $normal_pay;
    public $normal_time;
    public $selected_currency = '$';
    public $selected_value; // Standard pay choice (null for Hourly, value for others)
    public $pay_rate_label = 'Standard hourly pay rate:';
    
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
        
        // Load translations if not provided
        if (empty($this->lang)) {
            $cal_data = DB::table('calculators')->where('cal_link', 'time-and-a-half-calculator')->first();
            $this->lang = $cal_data ? json_decode($cal_data->lang_keys, true) : [];
        }

        // Restore previous inputs if available in session
        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');
            $this->daily_rate = $inputs->daily_rate ?? $this->daily_rate;
            $this->working_hour = $inputs->working_hour ?? $this->working_hour;
            $this->normal_pay = $inputs->normal_pay ?? $this->normal_pay;
            $this->normal_time = $inputs->normal_time ?? $this->normal_time;
            $this->selected_currency = $inputs->selected_currency ?? $this->selected_currency;
            $this->selected_value = $inputs->selected_value ?? $this->selected_value;
            $this->pay_rate_label = $inputs->pay_rate_label ?? $this->pay_rate_label;
        }
    }

    public function setPayRateType($label, $value = null)
    {
        $this->pay_rate_label = $label;
        $this->selected_value = $value;
        
        if ($value) {
            $this->working_hour = $value;
        }
    }

    public function setCurrency($currency)
    {
        $this->selected_currency = $currency;
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->daily_rate = 15;
        $this->working_hour = 8;
        $this->normal_pay = null;
        $this->normal_time = null;
        $this->selected_currency = '$';
        $this->selected_value = null;
        $this->pay_rate_label = 'Standard hourly pay rate:';
        $this->error = null;
        $this->detail = null;
        session()->forget(['calculator_result', 'calculator_back_inputs', 'validation_error', 'scroll_to_result']);

        return redirect()->to(url()->previous() ?? '/');
    }

    public function calculate()
    {
        $this->error = null;
        $this->detail = null;

        $request = (object)[
            'daily_rate' => $this->daily_rate,
            'working_hour' => $this->working_hour,
            'normal_pay' => $this->normal_pay,
            'normal_time' => $this->normal_time,
            'selected_value' => $this->selected_value,
        ];

        $result = app(CalculatorRepositoryInterface::class)->time_and_half(new Request((array)$request));

        if (isset($result['error'])) {
            $this->error = $result['error'];
            session()->flash('validation_error', $this->error);
        } else {
            $this->detail = $result;
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', (object)[
                'daily_rate' => $this->daily_rate,
                'working_hour' => $this->working_hour,
                'normal_pay' => $this->normal_pay,
                'normal_time' => $this->normal_time,
                'selected_currency' => $this->selected_currency,
                'selected_value' => $this->selected_value,
                'pay_rate_label' => $this->pay_rate_label,
            ]);
        }

        return redirect()->to(url()->previous() ?? '/');
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

        return view('livewire.calculators.time-and-a-half-calculator');
    }
}

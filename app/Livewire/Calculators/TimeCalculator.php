<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimeCalculator extends Component
{
    // General properties
    public $language = 'en';
    public $submit = 'time_first'; // Used for English tabs
    public $time_type = '2'; // Used for other languages
    public $form_number = '0';
    public $lang = [];
    public $error = null;
    public $detail = null;

    // English fields (time_first)
    public $t_days = '';
    public $t_hours = '';
    public $t_min = '';
    public $t_sec = '';
    public $t_method = 'minus';
    public $te_days = '';
    public $te_hours = '';
    public $te_min = '';
    public $te_sec = '';

    // English fields (time_second)
    public $am_pm = 'am';
    public $td_date = '2025-06-26';
    public $td_method = 'plus';
    public $td_days = '';
    public $td_hours = '';
    public $td_min = '';
    public $td_sec = '';
    public $ts_hours = '';
    public $ts_min = '';
    public $ts_sec = '';

    // Arabic fields
    public $s_time = '';
    public $e_time = '';
    public $sec = '';
    public $min = '';
    public $hur = '';
    public $day = '';
    public $mon = '';
    public $year = '';
    public $ampm = 'pm';
    public $sec_s = '';
    public $min_s = '';
    public $hur_s = '';
    public $day_s = '';
    public $mon_s = '';
    public $year_s = '';

    // Other locales fields (cs, tr, de, id, es)
    public $fs_date = '2025-06-26';
    public $ft_time = '';
    public $fe_date = '2025-06-26';
    public $fe_time = '';

    // Expression calculator (time_third)
    public $input = '';

     public function mount($type = 'calculator', $lang = [])
    {
        $this->language = app()->getLocale();
        $this->lang = $lang;
           $this->type = $type;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        if (empty($this->lang)) {
            $cal_data = DB::table('calculators')->where('cal_link', 'time-calculator')->first();
            $this->lang = $cal_data ? json_decode($cal_data->lang_keys, true) : [];
        }

        // Restore previous inputs if available in session
        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');
            foreach ($inputs as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        } else {
            // Default dates
            $this->td_date = date('Y-m-d');
            $this->fs_date = date('Y-m-d');
            $this->fe_date = date('Y-m-d');
        }
    }

    public function changeOperation($op)
    {
        $this->submit = $op;
        $this->detail = null;
        $this->error = null;
    }

    public function changeTimeType($type)
    {
        $this->time_type = $type;
        $this->detail = null;
        $this->error = null;
    }

    public function setNowTime($field)
    {
        if (property_exists($this, $field)) {
            $this->$field = date('H:i');
        }
    }

    public function resetForm()
    {
        session()->forget(['calculator_result', 'calculator_back_inputs', 'validation_error', 'scroll_to_result']);
        return redirect()->to(request()->header('Referer'));
    }

    public function calculate()
    {
        $this->error = null;
        $this->detail = null;

        // Determine effective language based on view existence
        $viewName = 'livewire.calculators.time-calculator-' . $this->language;
        $effectiveLanguage = \Illuminate\Support\Facades\View::exists($viewName) ? $this->language : 'en';

        // Map component properties to what Timedate::time() expects
        $data = [
            'sim_adv' => $this->submit,
            'language' => $effectiveLanguage,
            't_days' => $this->t_days,
            't_hours' => $this->t_hours,
            't_min' => $this->t_min,
            't_sec' => $this->t_sec,
            't_method' => $this->t_method,
            'te_days' => $this->te_days,
            'te_hours' => $this->te_hours,
            'te_min' => $this->te_min,
            'te_sec' => $this->te_sec,
            'am_pm' => $this->am_pm,
            'td_date' => $this->td_date,
            'td_method' => $this->td_method,
            'td_days' => $this->td_days,
            'td_hours' => $this->td_hours,
            'td_min' => $this->td_min,
            'td_sec' => $this->td_sec,
            'ts_hours' => $this->ts_hours,
            'ts_min' => $this->ts_min,
            'ts_sec' => $this->ts_sec,
            'time_type' => $this->time_type,
            's_time' => $this->s_time,
            'e_time' => $this->e_time,
            'input' => $this->input,
            'form_number' => $this->form_number,
        ];

        // Handle Arabic specific mapping if time_type is 4
        if ($effectiveLanguage == 'ar' && $this->time_type == '4') {
            $data['fs_date'] = sprintf('%04d-%02d-%02d', $this->year, $this->mon, $this->day);
            $data['ft_time'] = sprintf('%02d:%02d:%02d %s', $this->hur, $this->min, $this->sec, $this->am_pm);
            $data['fe_date'] = sprintf('%04d-%02d-%02d', $this->year_s, $this->mon_s, $this->day_s);
            $data['fe_time'] = sprintf('%02d:%02d:%02d %s', $this->hur_s, $this->min_s, $this->sec_s, $this->ampm);
        } else {
            // For other locales using time_type 4
            $data['fs_date'] = $this->fs_date;
            $data['ft_time'] = $this->ft_time;
            $data['fe_date'] = $this->fe_date;
            $data['fe_time'] = $this->fe_time;
        }

        $request = (object)$data;

        $result = app(CalculatorRepositoryInterface::class)->time(new Request((array)$request));

        if (isset($result['error'])) {
            $this->error = $result['error'];
            session()->flash('validation_error', $this->error);
        } else {
            $this->detail = $result;
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
        }

        $backInputs = [];
        foreach (get_object_vars($this) as $key => $value) {
            if (!in_array($key, ['lang', 'error', 'detail', 'results'])) {
                $backInputs[$key] = $value;
            }
        }
        session()->flash('calculator_back_inputs', $backInputs);

        return redirect()->to(request()->header('Referer'));
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

        return view('livewire.calculators.time-calculator');
    }
}

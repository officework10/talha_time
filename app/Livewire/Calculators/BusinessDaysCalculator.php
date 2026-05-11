<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BusinessDaysCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';
    public $mode = 'simple';
    public $s_date;
    public $e_date;
    public $end_inc = false;
    public $sat_inc = false;
    public $holiday_c = 'no'; // default value

    public $nyd = true;
    public $mlkd = true;
    public $psd = true;
    public $memd = false;
    public $ind = true;
    public $labd = false;
    public $cold = true;

    public $vetd = true;
    public $thankd = true;
    public $blkf = false;
    public $cheve = true;
    public $chirs = false;
    public $nye = true;

    public $ex_in = 1;     // default
    public $satting = 2;   // default
    public $showSelectDays = false;

    public $sun = false;
    public $mon = false;
    public $tue = false;
    public $wed = false;
    public $thu = false;
    public $fri = false;
    public $sat = false;
    public $holidays = [];
    public $totalHolidays = 0;
    public $totalHolidays_two = 0;
    public $add_date;
    public $method = '+';
    public $cal_bus = false;

    public $weekend_c = '';

    public $holidays_two = [];
    public $total_j = 0;
    public $years;
    public $months;
    public $weeks;
    public $days;

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        // First set default values
        $this->s_date = date('Y-m-d');
        $this->e_date = date('Y-m-d');
        $this->add_date = date('Y-m-d');

        // Then override with request values if they exist
        $this->s_date = request()->s_date ?? $this->s_date;
        $this->e_date = request()->e_date ?? $this->e_date;
        $this->add_date = request()->add_date ?? $this->add_date;
        $this->end_inc = request()->end_inc ?? $this->end_inc;
        $this->sat_inc = request()->sat_inc ?? $this->sat_inc;

        if (empty($this->holidays)) {
            $this->addHoliday();
        }

        // $this->holidays_two = [
        //     ['name' => '', 'month' => '', 'day' => '']
        // ];

        if (empty($this->holidays_two)) {
            $this->holidays_two = [
                ['name' => '', 'month' => '', 'day' => '']
            ];
        }

        if (request()->has('weekend_c')) {
            $this->weekend_c = request()->weekend_c;
        }

        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            // Restore all form fields from session
            $this->mode = $oldInputs->sim_adv ?? $this->mode;
            $this->s_date = $oldInputs->s_date ?? $this->s_date;
            $this->e_date = $oldInputs->e_date ?? $this->e_date;
            $this->end_inc = $oldInputs->end_inc ?? $this->end_inc;
            $this->sat_inc = $oldInputs->sat_inc ?? $this->sat_inc;
            $this->holiday_c = $oldInputs->holiday_c ?? $this->holiday_c;

            // Standard holidays
            $this->nyd = $oldInputs->nyd ?? $this->nyd;
            $this->mlkd = $oldInputs->mlkd ?? $this->mlkd;
            $this->psd = $oldInputs->psd ?? $this->psd;
            $this->memd = $oldInputs->memd ?? $this->memd;
            $this->ind = $oldInputs->ind ?? $this->ind;
            $this->labd = $oldInputs->labd ?? $this->labd;
            $this->cold = $oldInputs->cold ?? $this->cold;
            $this->vetd = $oldInputs->vetd ?? $this->vetd;
            $this->thankd = $oldInputs->thankd ?? $this->thankd;
            $this->blkf = $oldInputs->blkf ?? $this->blkf;
            $this->cheve = $oldInputs->cheve ?? $this->cheve;
            $this->chirs = $oldInputs->chirs ?? $this->chirs;
            $this->nye = $oldInputs->nye ?? $this->nye;

            // Weekdays
            $this->sun = $oldInputs->sun ?? $this->sun;
            $this->mon = $oldInputs->mon ?? $this->mon;
            $this->tue = $oldInputs->tue ?? $this->tue;
            $this->wed = $oldInputs->wed ?? $this->wed;
            $this->thu = $oldInputs->thu ?? $this->thu;
            $this->fri = $oldInputs->fri ?? $this->fri;
            $this->sat = $oldInputs->sat ?? $this->sat;

            $this->satting = $oldInputs->satting ?? $this->satting;
            $this->ex_in = $oldInputs->ex_in ?? $this->ex_in;
            $this->showSelectDays = $oldInputs->showSelectDays ?? $this->showSelectDays;

            // Holidays array
            if (!empty($oldInputs->holidays)) {
                $this->holidays = $oldInputs->holidays;
                $this->totalHolidays = count($this->holidays);
            }

            if (!empty($oldInputs->holidays_two)) {
                $this->holidays_two = $oldInputs->holidays_two;
                $this->totalHolidays_two = count($this->holidays_two);
            }


            $this->add_date = $oldInputs->add_date ?? $this->add_date;
            $this->method = $oldInputs->method ?? $this->method;
            $this->cal_bus = $oldInputs->cal_bus ?? $this->cal_bus;
            $this->weekend_c = $oldInputs->weekend_c ?? $this->weekend_c;

            // Other fields
            $this->years = $oldInputs->days ?? $this->years;
            $this->months = $oldInputs->days ?? $this->months;
            $this->weeks = $oldInputs->days ?? $this->weeks;
            $this->days = $oldInputs->days ?? $this->days;
        }
    }



    public function addHoliday_two()
    {
        $this->holidays_two[] = ['name' => '', 'month' => '', 'day' => ''];
        $this->totalHolidays_two = count($this->holidays_two);
    }

    public function removeHoliday_two($index)
    {
        unset($this->holidays_two[$index]);
        $this->holidays_two = array_values($this->holidays_two); // Reindex array
        $this->totalHolidays_two = count($this->holidays_two);
    }

    public function changeweekendC($value)
    {
        $this->weekend_c = $value;
    }

    public function addHoliday()
    {
        $this->holidays[] = [
            'name' => '',
            'month' => '',
            'day' => ''
        ];
        $this->totalHolidays = count($this->holidays);
    }
    public function removeHoliday($index)
    {
        unset($this->holidays[$index]);
        $this->holidays = array_values($this->holidays); // Reindex array
        $this->totalHolidays = count($this->holidays);
    }
    public function changeOperation($mode)
    {
        $this->mode = $mode;
    }

    public function changeHolidayC($value)
    {
        $this->holiday_c = $value;
    }

    public function changesatting()
    {
        // Agar satting ka value '6' hai to div show karo
        $this->showSelectDays = ($this->satting == 6);
    }

    public function calculate()
    {
        try {
            if ($this->mode !== 'simple') {
                $this->validate([
                    'add_date' => 'required',
                ]);
            } else {
                $this->validate([
                    's_date' => 'required',
                ]);
            }
        } catch (ValidationException $e) {
            $this->error = 'Please! Check your input.';
            session()->flash('validation_error', $this->error);
            $this->detail = null;
            return;
        }


        $request = (object)[
            'sim_adv'     => $this->mode,
            's_date'     => $this->s_date,
            'e_date'     => $this->e_date,
            'end_inc'    => $this->end_inc,
            'sat_inc'    => $this->sat_inc,
            'holiday_c'  => $this->holiday_c,
            // Standard holidays
            'nyd'        => $this->nyd,
            'mlkd'       => $this->mlkd,
            'psd'        => $this->psd,
            'memd'       => $this->memd,
            'ind'        => $this->ind,
            'labd'       => $this->labd,
            'cold'       => $this->cold,
            'vetd'       => $this->vetd,
            'thankd'     => $this->thankd,
            'blkf'       => $this->blkf,
            'cheve'      => $this->cheve,
            'chirs'      => $this->chirs,
            'nye'        => $this->nye,
            'sun'        => $this->sun,
            'mon'        => $this->mon,
            'tue'        => $this->tue,
            'wed'        => $this->wed,
            'thu'        => $this->thu,
            'fri'        => $this->fri,
            'sat'        => $this->sat,
            'satting'    => $this->satting,
            'ex_in'      => $this->ex_in,
            'showSelectDays' => $this->showSelectDays,
            // Keep the structured holidays array
            'holidays'   => $this->holidays,
            'totalHolidays' => $this->totalHolidays,
            'total_i'    => $this->totalHolidays,
            'add_date'    => $this->add_date,
            'method'    => $this->method,
            'cal_bus'    => $this->cal_bus,
            'weekend_c'    => $this->weekend_c,
            'total_j'    => $this->total_j,
            'years'    => $this->years,
            'months'    => $this->months,
            'weeks'    => $this->weeks,
            'days'    => $this->days,
            'holidays_two' => $this->holidays_two,
            'totalHolidays_two' => $this->totalHolidays_two,
            // other language 

        ];

        // Add the individual fields (n0, m0, d0, etc.)
        foreach ($this->holidays as $index => $holiday) {
            $request->{"n{$index}"} = $holiday['name'] ?? '';
            $request->{"m{$index}"} = $holiday['month'] ?? '';
            $request->{"d{$index}"} = $holiday['day'] ?? '';
        }

        // dd($request);
        $result = app(CalculatorRepositoryInterface::class)->business(new Request((array)$request));
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
        return view('livewire.calculators.business-days-calculator');
    }
}

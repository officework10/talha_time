<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class ElapsedTimeCalculator extends Component
{

    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';
    public  $main_units = 'elapsed';
    public  $clock_format = '12';
    public  $clock_start_unit = 'AM';

    public  $clock_end_unit = 'AM';

    public  $clock_secs = 8;
    public  $clock_mints = 9;
    public  $clock_hur = 10;


    public  $clock_second = 6;
    public  $clock_minute = 5;
    public  $clock_hour = 9;

    public $total_time = null;
    public $elapsed_end_unit = 'hrs/mins/sec';
    public $elapsed_end = 11;
    public $elapsed_end_one = 11;
    public $elapsed_end_sec = 40;
    public $elapsed_end_three = 55;

    public $elapsed_start_unit = 'hrs/mins/sec';
    public $elapsed_start = 9;
    public $elapsed_start_one = 9;
    public $elapsed_start_sec = 30;
    public $elapsed_start_three = 50;

    // Toggle states for fields
    public $showElapsedStart = false;
    public $showElapsedStartOne = false;
    public $showElapsedStartSec = false;
    public $showElapsedStartThree = false;
    // Toggle states for fields
    public $showElapsedEnd = false;
    public $showElapsedEndOne = false;
    public $showElapsedEndSec = false;
    public $showElapsedEndThree = false;

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        $this->main_units = request()->get('main_units', 'elapsed');
        $this->clock_format = request()->get('clock_format', '12');
        $this->clock_start_unit = request()->get('clock_start_unit', 'AM');

        // Agar previous values hain to wapas set karo
        if (session()->has('calculator_back_inputs')) {
            $saved = session('calculator_back_inputs');

            foreach ($saved as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }

        $this->updateElapsedFields();
        $this->updatestartFields();
    }


    public function setMainUnits(string $unit)
    {
        $this->main_units = $unit;
    }

    public function setClockFormat(string $format)
    {
        $this->clock_format = $format;

        // If switching to 24 hours, no AM/PM needed
        if ($format == '24') {
            $this->clock_start_unit = '';
        } elseif ($format == '12' && $this->clock_start_unit == '') {
            $this->clock_start_unit = 'AM';
        }
    }

    public function changeelapsed_start_unit()
    {
        $this->updatestartFields();
    }
    public function changeelapsed_end_unit()
    {
        $this->updateElapsedFields();
    }

    private function updateElapsedFields()
    {
        // Reset all
        $this->showElapsedEnd = false;
        $this->showElapsedEndOne = false;
        $this->showElapsedEndSec = false;
        $this->showElapsedEndThree = false;
        // dd($this->showElapsedStart);
        switch ($this->elapsed_end_unit) {
            case 'hrs/mins/sec':
                $this->showElapsedEndOne = true;  // hrs
                $this->showElapsedEndSec = true;  // mins
                $this->showElapsedEndThree = true; // sec
                break;

            case 'hrs/mins':
                $this->showElapsedEndOne = true; // hrs
                $this->showElapsedEndSec = true; // mins
                break;

            case 'mins/sec':
                $this->showElapsedEndSec = true;  // mins
                $this->showElapsedEndThree = true; // sec
                break;

            case 'hrs':
            case 'mins':
            case 'sec':
                $this->showElapsedEnd = true;
                break;
        }
    }
    private function updatestartFields()
    {
        // Reset all
        $this->showElapsedStart = false;
        $this->showElapsedStartOne = false;
        $this->showElapsedStartSec = false;
        $this->showElapsedStartThree = false;
        // dd($this->showElapsedStart);
        switch ($this->elapsed_start_unit) {
            case 'hrs/mins/sec':
                $this->showElapsedStartOne = true;  // hrs
                $this->showElapsedStartSec = true;  // mins
                $this->showElapsedStartThree = true; // sec
                break;

            case 'hrs/mins':
                $this->showElapsedStartOne = true; // hrs
                $this->showElapsedStartSec = true; // mins
                break;

            case 'mins/sec':
                $this->showElapsedStartSec = true;  // mins
                $this->showElapsedStartThree = true; // sec
                break;

            case 'hrs':
            case 'mins':
            case 'sec':
                $this->showElapsedStart = true;
                break;
        }
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
            'main_units'          => $this->main_units,
            'clock_format'        => $this->clock_format,
            'clock_start_unit'    => $this->clock_start_unit,

            'elapsed_start_unit'  => $this->elapsed_start_unit,
            'elapsed_start'       => $this->elapsed_start,
            'elapsed_start_one'   => $this->elapsed_start_one,
            'elapsed_start_sec'   => $this->elapsed_start_sec,
            'elapsed_start_three' => $this->elapsed_start_three,

            'elapsed_end_unit'    => $this->elapsed_end_unit,
            'elapsed_end'         => $this->elapsed_end,
            'elapsed_end_one'     => $this->elapsed_end_one,
            'elapsed_end_sec'     => $this->elapsed_end_sec,
            'elapsed_end_three'   => $this->elapsed_end_three,

            'clock_end_unit'   => $this->clock_end_unit,
            'clock_secs'   => $this->clock_secs,
            'clock_mints'   => $this->clock_mints,
            'clock_hur'   => $this->clock_hur,
            'clock_second'   => $this->clock_second,
            'clock_minute'   => $this->clock_minute,
            'clock_hour'   => $this->clock_hour,
        ];

        $result = app(CalculatorRepositoryInterface::class)->elapsed(new Request((array)$request));
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
        return view('livewire.calculators.elapsed-time-calculator');
    }
}

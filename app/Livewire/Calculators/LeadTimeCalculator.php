<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class LeadTimeCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $lang = [];
    public $types = 'manufac';

    public $pre_time = 10;
    public $pre_units = 'days';
    public $p_time = 20;
    public $p_units = 'days';
    public $post_time = 25;
    public $post_units = 'days';

    public $r_delay = 25;
    public $r_units = 'days';
    public $s_delay = 25;
    public $supply_units = 'days';
    public $receive_time;
    public $place_time;

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');

            $this->types         = $inputs->type ?? $this->types;

            $this->pre_time      = $inputs->pre_time ?? $this->pre_time;
            $this->pre_units     = $inputs->pre_units ?? $this->pre_units;

            $this->p_time        = $inputs->p_time ?? $this->p_time;
            $this->p_units       = $inputs->p_units ?? $this->p_units;

            $this->post_time     = $inputs->post_time ?? $this->post_time;
            $this->post_units    = $inputs->post_units ?? $this->post_units;

            $this->r_delay       = $inputs->r_delay ?? $this->r_delay;
            $this->r_units       = $inputs->r_units ?? $this->r_units;

            $this->s_delay       = $inputs->s_delay ?? $this->s_delay;
            $this->supply_units  = $inputs->supply_units ?? $this->supply_units;
            $this->receive_time  = $inputs->receive_time ?? $this->receive_time;
            $this->place_time  = $inputs->place_time ?? $this->place_time;
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


    public function changetype()
    {
        
        // Optional type switching logic
    }

    public function setUnit($field, $value)
    {
        $this->$field = $value;
    }
    public function setPreUnit($unit)
    {
        $this->pre_units = $unit;
    }


    public function calculate()
    {
        $request = (object)[
            'type'         => $this->types,
            'pre_time'     => $this->pre_time,
            'pre_units'    => $this->pre_units,
            'p_time'       => $this->p_time,
            'p_units'      => $this->p_units,
            'post_time'    => $this->post_time,
            'post_units'   => $this->post_units,
            'r_delay'      => $this->r_delay,
            'r_units'      => $this->r_units,
            's_delay'      => $this->s_delay,
            'supply_units' => $this->supply_units,
            'receive_time' => $this->receive_time,
            'place_time' => $this->place_time,
        ];


        $result = app(CalculatorRepositoryInterface::class)->lead(new Request((array)$request));
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
                    const offset = el.getBoundingClientRect().top + window.pageYOffset - 100;
                    window.scrollTo({ top: offset, behavior: 'smooth' });
                }
            JS);
        }

        return view('livewire.calculators.lead-time-calculator');
    }
}

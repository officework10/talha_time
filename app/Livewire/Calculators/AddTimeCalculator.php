<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class AddTimeCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';

    public $rows = [];
    public $maxRows = 18;
    public $count_val = 2; // number of rows
    public $hours_check = true;
    public $min_check = true;
    public $sec_check = true;
    public $milli_check = true;

    public $total_time = null;

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        if (session()->has('calculator_back_inputs')) {
            $saved = session('calculator_back_inputs');
            $this->rows = $saved->rows;
            $this->hours_check = $saved->hours_check;
            $this->min_check = $saved->min_check;
            $this->sec_check = $saved->sec_check;
            $this->milli_check = $saved->milli_check;
            $this->count_val = $saved->count_val;
        } else {
            $this->rows = [
                ['inhour' => null, 'inminutes' => null, 'inseconds' => null, 'inmiliseconds' => null],
                ['inhour' => null, 'inminutes' => null, 'inseconds' => null, 'inmiliseconds' => null],
            ];
            $this->count_val = count($this->rows);
        }
    }


    public function addRow()
    {
        if (count($this->rows) < $this->maxRows) {
            $this->rows[] = [
                'inhour' => null,
                'inminutes' => null,
                'inseconds' => null,
                'inmiliseconds' => null
            ];
            $this->count_val = count($this->rows); // update count
        } else {
            $this->dispatch('alert', message: 'Max Limit Reached');
        }
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
        $this->count_val = count($this->rows); // update count
    }

    /**
     * Handle checkbox toggle (no value clearing)
     */
    public function toggleColumn($column)
    {
        // UI only disabling — no resetting of values
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
        // Prepare request object with all data
        $request = (object) [
            'rows'         => $this->rows,
            'hours_check'  => $this->hours_check,
            'min_check'    => $this->min_check,
            'sec_check'    => $this->sec_check,
            'milli_check'  => $this->milli_check,
            'count_val'    => $this->count_val,
        ];

        $result = app(CalculatorRepositoryInterface::class)->add(new Request((array)$request));

        if (!empty($result['RESULT']) && $result['RESULT'] == 1) {
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', $request);
            $this->error = null;

            return redirect()->to(url()->previous() ?? '/'); // fallback if referer not available
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
            const offset = 30;
            const top = el.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top: top, behavior: 'smooth' });
        }
       JS);
        }
        return view('livewire.calculators.add-time-calculator');
    }
}

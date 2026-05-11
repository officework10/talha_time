<?php
namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AverageTimeCalculator extends Component
{
    public $rows = [];
    public $checkbox1 = true; // Hours
    public $checkbox2 = true; // Minutes
    public $checkbox3 = true; // Seconds
    public $checkbox4 = true; // Milliseconds
    
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';

    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = is_array($lang) ? $lang : [];
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');
        
        // Load translations if not provided
        if (empty($this->lang)) {
            $cal_data = DB::table('calculators')->where('cal_link', 'average-time-calculator')->first();
            $this->lang = $cal_data ? json_decode($cal_data->lang_keys, true) : [];
        }

        $this->initializeRows();

        // Restore previous inputs if available in session
        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');
            $this->rows = $inputs->rows ?? $this->rows;
            $this->checkbox1 = $inputs->checkbox1 ?? $this->checkbox1;
            $this->checkbox2 = $inputs->checkbox2 ?? $this->checkbox2;
            $this->checkbox3 = $inputs->checkbox3 ?? $this->checkbox3;
            $this->checkbox4 = $inputs->checkbox4 ?? $this->checkbox4;
        }
    }

    public function initializeRows()
    {
        $this->rows = [
            ['inhour' => '', 'inminutes' => '', 'inseconds' => '', 'inmiliseconds' => ''],
            ['inhour' => '', 'inminutes' => '', 'inseconds' => '', 'inmiliseconds' => ''],
        ];
    }

    public function addRow()
    {
        if (count($this->rows) < 20) {
            $this->rows[] = ['inhour' => '', 'inminutes' => '', 'inseconds' => '', 'inmiliseconds' => ''];
        } else {
            $this->error = 'Max limit reached (20 rows).';
        }
    }

    public function removeRow($index)
    {
        if (count($this->rows) > 2) {
            unset($this->rows[$index]);
            $this->rows = array_values($this->rows);
        }
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->initializeRows();
        $this->checkbox1 = true;
        $this->checkbox2 = true;
        $this->checkbox3 = true;
        $this->checkbox4 = true;
        $this->error = null;
        $this->detail = null;
        session()->forget(['calculator_result', 'calculator_back_inputs', 'validation_error', 'scroll_to_result']);
        
        return redirect()->to(url()->previous() ?? '/');
    }

    public function calculate()
    {
        $this->error = null;
        $this->detail = null;

        $requestData = [
            'rows' => $this->rows,
            'checkbox1' => $this->checkbox1,
            'checkbox2' => $this->checkbox2,
            'checkbox3' => $this->checkbox3,
            'checkbox4' => $this->checkbox4,
        ];

        $result = app(CalculatorRepositoryInterface::class)->average(new Request($requestData));

        if (isset($result['error'])) {
            $this->error = $result['error'];
            session()->flash('validation_error', $this->error);
        } else {
            $this->detail = $result;
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', (object)[
                'rows' => $this->rows,
                'checkbox1' => $this->checkbox1,
                'checkbox2' => $this->checkbox2,
                'checkbox3' => $this->checkbox3,
                'checkbox4' => $this->checkbox4,
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

        return view('livewire.calculators.average-time-calculator');
    }
}

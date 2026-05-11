<?php

namespace App\Livewire\Calculators;


use Livewire\Component;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;

class DecimalToTime extends Component
{
    public $type = 'calculator';
    public $error = null;
    public $detail = null;
    public $lang = [];

    public $decimal;
    public $startEvent = 'hours';

    public function mount($type = 'calculator', $lang = [])
    {
        // Default language
           $this->type = $type;
        $this->lang = $lang;
        
        // Previous result
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        // Persist form inputs if available
        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->decimal = $oldInputs->decimal ?? 42.756;
            $this->startEvent = $oldInputs->startEvent ?? 'hours';
        } else {
            $this->decimal = 42.756;
            $this->startEvent = 'hours';
        }
    }

    public function calculate()
    {
        // Manual validation since we're using a model method that expects a Request object or array
        if (!is_numeric($this->decimal)) {
            $this->error = 'Please enter a valid decimal number.';
            return;
        }

        $request = new Request([
            'decimal' => $this->decimal,
            'startEvent' => $this->startEvent,
        ]);

        $result = app(CalculatorRepositoryInterface::class)->decimal_to_time($request);

        if (!isset($result['error'])) {
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', (object)[
                'decimal' => $this->decimal,
                'startEvent' => $this->startEvent
            ]);
            $this->error = null;

            return redirect()->to(url()->previous() ?? '/');
        }

        // Handle error case
        $this->error = $result['error'];
        $this->detail = null;
        session()->flash('validation_error', $this->error);
        session()->forget('calculator_result');
        session()->flash('calculator_back_inputs', (object)[
            'decimal' => $this->decimal,
            'startEvent' => $this->startEvent
        ]);
        
        return redirect()->to(url()->previous() ?? '/');
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        
        $this->decimal = 42.756;
        $this->startEvent = 'hours';
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
                    const offset = el.getBoundingClientRect().top + window.pageYOffset - 100;
                    window.scrollTo({ top: offset, behavior: 'smooth' });
                }
            JS);
        }

        return view('livewire.calculators.decimal-to-time');
    }
}

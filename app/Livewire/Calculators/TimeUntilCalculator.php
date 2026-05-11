<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class TimeUntilCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $lang = [];
    public $type = 'calculator';

    public $current;
    public $next;
    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');

            // Restore inputs from session if available
            $this->current = $inputs['current'] ?? now()->format('Y-m-d\TH:i');
            $this->next = $inputs['next'] ?? now()->addYear()->format('Y-m-d\TH:i');
        } else {
            // Set defaults if no session inputs
            $this->current = now()->format('Y-m-d\TH:i');
            $this->next = now()->addYear()->format('Y-m-d\TH:i');
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
        $request = [
            'current' => $this->current,
            'next' => $this->next,
        ];

        $result = app(CalculatorRepositoryInterface::class)->time_until(new Request((array)$request));

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

        return view('livewire.calculators.time-until-calculator');
    }
}

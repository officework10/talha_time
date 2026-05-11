<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;
use Illuminate\Http\Request;

class ReadingTimeCalculator extends Component
{
    public $error = null;
    public $detail = null;
    public $type = 'calculator';
    public $lang = [];
    public $reading_speed = '2';
    public $read_pages = '0.50';
    public $book_unit = 'min';
    public $book_leng = 1;
    public $total_unit = 'min';

    public $daily_reading = 8;
    public $time_unit = 'min';
    public $reading_unit = 'min';
    public $period_unit = 'min';


    public function mount($type = 'calculator', $lang = [])
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        if (session()->has('calculator_back_inputs')) {
            $inputs = session('calculator_back_inputs');

            $this->reading_speed = $inputs->reading_speed ?? $this->reading_speed;
            $this->read_pages = $inputs->read_pages ?? $this->read_pages;
            $this->book_unit = $inputs->book_unit ?? $this->book_unit;
            $this->book_leng = $inputs->book_leng ?? $this->book_leng;
            $this->total_unit = $inputs->total_unit ?? $this->total_unit;
            $this->daily_reading = $inputs->daily_reading ?? $this->daily_reading;
            $this->time_unit = $inputs->time_unit ?? $this->time_unit;
            $this->reading_unit = $inputs->reading_unit ?? $this->reading_unit;
            $this->period_unit = $inputs->period_unit ?? $this->period_unit;
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
            'reading_speed'         => $this->reading_speed,
            'read_pages'     => $this->read_pages,
            'book_unit'    => $this->book_unit,
            'book_leng'       => $this->book_leng,
            'total_unit'      => $this->total_unit,
            'daily_reading'    => $this->daily_reading,
            'time_unit'   => $this->time_unit,
            'reading_unit'      => $this->reading_unit,
            'period_unit'      => $this->period_unit,
        ];


        $result = app(CalculatorRepositoryInterface::class)->reading(new Request((array)$request));
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
        return view('livewire.calculators.reading-time-calculator');
    }
}

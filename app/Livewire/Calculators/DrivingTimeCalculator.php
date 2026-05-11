<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;

class DrivingTimeCalculator extends Component
{
    public $type = 'calculator';
    public $lang = [];
    public $currencySymbol = '$';
    public $currancy = '$';

    // Inputs
    public $distance = '800';
    public $distance_unit = 'km';
    public $average_speed = '110';
    public $average_speed_unit = 'km/h';
    public $breaks = '0';
    public $breaks_unit = 'min';
    public $departure_time;
    public $fuel_e = '5';
    public $fuel_e_unit = 'L/100km';
    public $fuel_p = '9.5';
    public $fuel_p_unit; // Will set default in mount
    public $passengers = '5';

    public $error = null;
    public $detail = null;

    public function mount($type = 'calculator', $lang = [], $currencySymbol = '$')
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->currencySymbol = $currencySymbol;
        $this->currancy = $currencySymbol;
        $this->departure_time = now()->format('Y-m-d\TH:i');
        
        // Set default fuel price unit which depends on currency
        $this->fuel_p_unit = $this->currancy . '/L';

        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->distance = $oldInputs->distance ?? $this->distance;
            $this->distance_unit = $oldInputs->distance_unit ?? $this->distance_unit;
            $this->average_speed = $oldInputs->average_speed ?? $this->average_speed;
            $this->average_speed_unit = $oldInputs->average_speed_unit ?? $this->average_speed_unit;
            $this->breaks = $oldInputs->breaks ?? $this->breaks;
            $this->breaks_unit = $oldInputs->breaks_unit ?? $this->breaks_unit;
            $this->departure_time = $oldInputs->departure_time ?? $this->departure_time;
            $this->fuel_e = $oldInputs->fuel_e ?? $this->fuel_e;
            $this->fuel_e_unit = $oldInputs->fuel_e_unit ?? $this->fuel_e_unit;
            $this->fuel_p = $oldInputs->fuel_p ?? $this->fuel_p;
            $this->fuel_p_unit = $oldInputs->fuel_p_unit ?? $this->fuel_p_unit;
            $this->passengers = $oldInputs->passengers ?? $this->passengers;
        }
    }

    public function calculate()
    {
        $request = request();
        $request->merge([
            'distance' => $this->distance,
            'distance_unit' => $this->distance_unit,
            'average_speed' => $this->average_speed,
            'average_speed_unit' => $this->average_speed_unit,
            'breaks' => $this->breaks,
            'breaks_unit' => $this->breaks_unit,
            'departure_time' => $this->departure_time,
            'fuel_e' => $this->fuel_e,
            'fuel_e_unit' => $this->fuel_e_unit,
            'fuel_p' => $this->fuel_p,
            'fuel_p_unit' => $this->fuel_p_unit,
            'currancy' => $this->currancy,
            'passengers' => $this->passengers,
        ]);

        $result = app(CalculatorRepositoryInterface::class)->drive($request);

        if (isset($result['RESULT']) && $result['RESULT'] == 1) {
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', (object)$request->all());
            $this->error = null;

            return redirect()->to(url()->previous() ?? '/');
        }

        $this->error = $result['error'] ?? 'Something went wrong.';
        session()->flash('validation_error', $this->error);
    }

    public function resetForm()
    {
        $this->reset(['distance', 'distance_unit', 'average_speed', 'average_speed_unit', 'breaks', 'breaks_unit', 'fuel_e', 'fuel_e_unit', 'fuel_p', 'fuel_p_unit', 'passengers']);
        $this->departure_time = now()->format('Y-m-d\TH:i');
        $this->error = null;
        $this->detail = null;

        session()->forget([
            'calculator_result',
            'calculator_back_inputs',
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
        return view('livewire.calculators.driving-time-calculator');
    }
}

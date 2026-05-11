<?php
  
namespace App\Livewire\Calculators;

use Livewire\Component;
use App\Repositories\Interfaces\CalculatorRepositoryInterface;

class TravelTimeCalculator extends Component
{
    public $type = 'calculator';
    public $lang = [];
    public $currencySymbol = '$';
    public $currancy = '$'; // Matching model's typo and expected key

    // Inputs
    public $distance = '5';
    public $distance_unit = 'km';
    public $speed = '975';
    public $speed_unit = 'kmpl'; // Matching view's default
    public $break_hrs = '5';
    public $break_min = '5';
    public $dep_time;
    public $fule_effi = '5';
    public $fule_effi_unit = 'kmpl';
    public $price = '5';
    public $price_unit = 'liter';
    public $passenger = '5';

    public $error = null;
    public $detail = null;

    public function mount($type = 'calculator', $lang = [], $currencySymbol = '$')
    {
        $this->type = $type;
        $this->lang = $lang;
        $this->currencySymbol = $currencySymbol;
        $this->currancy = $currencySymbol;
        $this->dep_time = now()->format('Y-m-d\TH:i');

        $this->detail = session('calculator_result');
        $this->error = session('validation_error');

        $oldInputs = session('calculator_back_inputs');
        if ($oldInputs) {
            $this->distance = $oldInputs->distance ?? $this->distance;
            $this->distance_unit = $oldInputs->distance_unit ?? $this->distance_unit;
            $this->speed = $oldInputs->speed ?? $this->speed;
            $this->speed_unit = $oldInputs->speed_unit ?? $this->speed_unit;
            $this->break_hrs = $oldInputs->break_hrs ?? $this->break_hrs;
            $this->break_min = $oldInputs->break_min ?? $this->break_min;
            $this->dep_time = $oldInputs->dep_time ?? $this->dep_time;
            $this->fule_effi = $oldInputs->fule_effi ?? $this->fule_effi;
            $this->fule_effi_unit = $oldInputs->fule_effi_unit ?? $this->fule_effi_unit;
            $this->price = $oldInputs->price ?? $this->price;
            $this->price_unit = $oldInputs->price_unit ?? $this->price_unit;
            $this->passenger = $oldInputs->passenger ?? $this->passenger;
        }
    }

    public function calculate()
    {
        // Construct request object as expected by model
        $request = (object)[
            'distance' => $this->distance,
            'distance_unit' => $this->distance_unit,
            'speed' => $this->speed,
            'speed_unit' => $this->speed_unit,
            'break_hrs' => $this->break_hrs,
            'break_min' => $this->break_min,
            'dep_time' => $this->dep_time,
            'fule_effi' => $this->fule_effi,
            'fule_effi_unit' => $this->fule_effi_unit,
            'price' => $this->price,
            'price_unit' => $this->price_unit,
            'currancy' => $this->currancy,
            'passenger' => $this->passenger,
        ];

        // The model expects $request->input() so we need to bridge it if it uses Request object methods
        // However, the travel() method I saw uses $request->input('key')
        // So I'll wrap it in a pseudo-request if necessary or ensure model can handle it.
        // Actually, looking at Timedate.php::travel(function travel($request) { $distance = $request->input('distance'); ... })
        // It uses Laravel's Request::input(). Livewire properties are usually passed as objects or arrays.
        // I'll use the same pattern as SleepCalculator which uses (object) and model calls.
        
        // Wait, Timedate.php::travel uses $request->input('key'). 
        // If I pass a plain object, $request->input() will fail.
        // I need to use the request() helper or make a proper request wrapper.
        
        $pseudoRequest = request();
        $pseudoRequest->merge((array)$request);

        $result = app(CalculatorRepositoryInterface::class)->travel($pseudoRequest);

        if (isset($result['RESULT']) && $result['RESULT'] == 1) {
            $result['currencySymbol'] = $this->currencySymbol;
            session()->flash('calculator_result', $result);
            session()->flash('scroll_to_result', true);
            session()->flash('calculator_back_inputs', $request);
            $this->error = null;

            return redirect()->to(url()->previous() ?? '/');
        }

        $this->error = $result['error'] ?? 'Something went wrong.';
        session()->flash('validation_error', $this->error);
    }

    public function resetForm()
    {
        $this->reset(['distance', 'distance_unit', 'speed', 'speed_unit', 'break_hrs', 'break_min', 'fule_effi', 'fule_effi_unit', 'price', 'price_unit', 'passenger']);
        $this->dep_time = now()->format('Y-m-d\TH:i');
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
        return view('livewire.calculators.travel-time-calculator');
    }
}

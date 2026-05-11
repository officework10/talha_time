<?php

namespace App\Livewire;

use Livewire\Component;

class UnitConverter extends Component
{
    public $calculatorName = 'length';
    public $fromValue = '1';
    public $toValue = '';
    public $fromUnit = '1';
    public $toUnit = '2';
    public $result = '';
    public $resultUnit = '';
    public $showResult = false;


    public $device; // Add this with your other properties

    public function mount($device = 'desktop') // Add this method
    {
        $this->device = $device;
          $this->calculate();
    }

    // public function setCalculatorName($name)
    // {
    //     $this->calculatorName = $name;
    //     // dd($this->calculatorName);
    //     $this->calculate();
    // }

    public function setCalculatorName($name)
{
    $this->calculatorName = $name;

    // Get valid units for the selected type
    $units = array_keys($this->unitTypes[$this->calculatorName]);

    // Safely reset units
    $this->fromUnit = $units[0] ?? '1';
    $this->toUnit = $units[1] ?? $units[0] ?? '1';

    $this->calculate();
}




    public function onFromUnitChange($value)
    {
        $this->fromUnit = $value;

        // Your custom logic here
        $this->calculate(); // Or whatever you want
    }
    public function onToUnitChange($value)
    {
        $this->toUnit = $value;
        // Your custom logic here
        $this->calculate(); // Or whatever you want
    }


    // Example in: app/Livewire/YourComponent.php

    public function copyResult()
    {
        $textToCopy = $this->result . ' ' . $this->resultUnit;

        $this->dispatch('copy-to-clipboard', [
            'text' => $textToCopy,
            'message' => 'Result copied to clipboard!',
        ]);
    }


    // Unit definitions
    public $unitTypes = [
        'length' => [
            '1' => 'Meter',
            '2' => 'Kilometer',
            '3' => 'Centimeter',
            '4' => 'Millimeter',
            '5' => 'Micrometer',
            '6' => 'Nanometer',
            '7' => 'Mile',
            '8' => 'Yard',
            '9' => 'Foot',
            '10' => 'Inch',
            '11' => 'Light Year',
            '12' => 'Nautical mile',
        ],
        'temperature' => [
            '1' => 'Celsius',
            '2' => 'Kelvin',
            '3' => 'Fahrenheit',
        ],
        'area' => [
            '1' => 'Square Meter',
            '2' => 'Square Kilometer',
            '3' => 'Square Centimeter',
            '4' => 'Square Millimeter',
            '5' => 'Square Micrometer',
            '6' => 'Hectare',
            '7' => 'Square Mile',
            '8' => 'Square Yard',
            '9' => 'Square Foot',
            '10' => 'Square Inch',
            '11' => 'Acre',
        ],
        'volume' => [
            '1' => 'Cubic Meter',
            '2' => 'Cubic Kilometer',
            '3' => 'Cubic Centimeter',
            '4' => 'Cubic Millimeter',
            '5' => 'Liter',
            '6' => 'Milliliter',
            '7' => 'US Gallon',
            '8' => 'US Quart',
            '9' => 'US Pint',
            '10' => 'US Cup',
            '11' => 'US Fluid Ounce',
            '12' => 'US Table Spoon',
            '13' => 'US Tea Spoon',
            '14' => 'Imperial Gallon',
            '15' => 'Imperial Quart',
            '16' => 'Imperial Pint',
            '17' => 'Imperial Fluid Ounce',
            '18' => 'Imperial Table Spoon',
            '19' => 'Imperial Tea Spoon',
            '20' => 'Cubic Mile',
            '21' => 'Cubic Yard',
            '22' => 'Cubic Foot',
            '23' => 'Cubic Inch',
        ],
        'weight' => [
            '1' => 'Kilogram',
            '2' => 'Gram',
            '3' => 'Milligram',
            '4' => 'Metric Ton',
            '5' => 'Long Ton',
            '6' => 'Short Ton',
            '7' => 'Pound',
            '8' => 'Ounce',
            '9' => 'Carrat',
            '10' => 'Atomic Mass Unit',
        ],
        'time' => [
            '1' => 'Second',
            '2' => 'Millisecond',
            '3' => 'Microsecond',
            '4' => 'Nanosecond',
            '5' => 'Picosecond',
            '6' => 'Minute',
            '7' => 'Hour',
            '8' => 'Day',
            '9' => 'Week',
            '10' => 'Month',
            '11' => 'Year',
        ],
    ];

    public function calculate()
    {
        if ($this->fromValue === '' || !is_numeric($this->fromValue)) {
            $this->showResult = false;
            $this->toValue = '';
            return;
        }

        $fromValue = (float)$this->fromValue;
        $convertedValue = $this->convertValue($fromValue, $this->fromUnit, $this->toUnit);

        $this->result = $this->formatResult($convertedValue);
        $this->resultUnit = $this->unitTypes[$this->calculatorName][$this->toUnit];
        $this->toValue = $this->result;
        $this->showResult = true;
    }

    public function reverseCalculate()
    {
        if ($this->toValue === '' || !is_numeric($this->toValue)) {
            $this->showResult = false;
            $this->fromValue = '';
            return;
        }

        $toValue = (float)$this->toValue;
        $convertedValue = $this->convertValue($toValue, $this->toUnit, $this->fromUnit);

        $this->result = $this->formatResult($convertedValue);
        $this->resultUnit = $this->unitTypes[$this->calculatorName][$this->fromUnit];
        $this->fromValue = $this->result;
        $this->showResult = true;
    }

    protected function convertValue($value, $fromUnit, $toUnit)
    {
        // First convert to base unit
        $baseValue = $this->toBaseUnit($value, $fromUnit);

        // Then convert from base to target unit
        return $this->fromBaseUnit($baseValue, $toUnit);
    }

    protected function toBaseUnit($value, $unit)
    {
        switch ($this->calculatorName) {
            case 'length':
                return $this->lengthToBase($value, $unit);
            case 'temperature':
                return $this->temperatureToBase($value, $unit);
            case 'area':
                return $this->areaToBase($value, $unit);
            case 'volume':
                return $this->volumeToBase($value, $unit);
            case 'weight':
                return $this->weightToBase($value, $unit);
            case 'time':
                return $this->timeToBase($value, $unit);
            default:
                return $value;
        }
    }

    protected function fromBaseUnit($value, $unit)
    {
        switch ($this->calculatorName) {
            case 'length':
                return $this->lengthFromBase($value, $unit);
            case 'temperature':
                return $this->temperatureFromBase($value, $unit);
            case 'area':
                return $this->areaFromBase($value, $unit);
            case 'volume':
                return $this->volumeFromBase($value, $unit);
            case 'weight':
                return $this->weightFromBase($value, $unit);
            case 'time':
                return $this->timeFromBase($value, $unit);
            default:
                return $value;
        }
    }

    // Length conversion methods
    protected function lengthToBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Meter
            case '2':
                return $value * 1000; // Kilometer to Meter
            case '3':
                return $value / 100; // Centimeter to Meter
            case '4':
                return $value / 1000; // Millimeter to Meter
            case '5':
                return $value / 1000000; // Micrometer to Meter
            case '6':
                return $value / 1000000000; // Nanometer to Meter
            case '7':
                return $value * 1609.35; // Mile to Meter
            case '8':
                return $value * 0.9144; // Yard to Meter
            case '9':
                return $value * 0.3048; // Foot to Meter
            case '10':
                return $value * 0.0254; // Inch to Meter
            case '11':
                return $value * 9.46066e+15; // Light Year to Meter
            case '12':
                return $value * 1852; // Nautical mile to Meter
            default:
                return $value;
        }
    }

    protected function lengthFromBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Meter
            case '2':
                return $value / 1000; // Meter to Kilometer
            case '3':
                return $value * 100; // Meter to Centimeter
            case '4':
                return $value * 1000; // Meter to Millimeter
            case '5':
                return $value * 1e+6; // Meter to Micrometer
            case '6':
                return $value * 1e+9; // Meter to Nanometer
            case '7':
                return $value / 1609.35; // Meter to Mile
            case '8':
                return $value / 0.9144; // Meter to Yard
            case '9':
                return $value / 0.3048; // Meter to Foot
            case '10':
                return $value / 0.0254; // Meter to Inch
            case '11':
                return $value / 9.46066e+15; // Meter to Light Year
            case '12':
                return $value / 1852; // Meter to Nautical mile
            default:
                return $value;
        }
    }

    // Temperature conversion methods
    protected function temperatureToBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Celsius (base for our calculations)
            case '2':
                return $value - 273.15; // Kelvin to Celsius
            case '3':
                return ($value - 32) * 5 / 9; // Fahrenheit to Celsius
            default:
                return $value;
        }
    }

    protected function temperatureFromBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Celsius
            case '2':
                return $value + 273.15; // Celsius to Kelvin
            case '3':
                return ($value * 9 / 5) + 32; // Celsius to Fahrenheit
            default:
                return $value;
        }
    }

    // Area conversion methods
    protected function areaToBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Square Meter
            case '2':
                return $value * 1000000; // Square Kilometer to Square Meter
            case '3':
                return $value * 0.0001; // Square Centimeter to Square Meter
            case '4':
                return $value * 0.000001; // Square Millimeter to Square Meter
            case '5':
                return $value * 0.000000000001; // Square Micrometer to Square Meter
            case '6':
                return $value * 10000; // Hectare to Square Meter
            case '7':
                return $value * 2589990; // Square Mile to Square Meter
            case '8':
                return $value * 0.83612736; // Square Yard to Square Meter
            case '9':
                return $value * 0.09290304; // Square Foot to Square Meter
            case '10':
                return $value * 0.000645160; // Square Inch to Square Meter
            case '11':
                return $value * 4046.8564224; // Acre to Square Meter
            default:
                return $value;
        }
    }

    protected function areaFromBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Square Meter
            case '2':
                return $value / 1000000; // Square Meter to Square Kilometer
            case '3':
                return $value / 0.0001; // Square Meter to Square Centimeter
            case '4':
                return $value / 0.000001; // Square Meter to Square Millimeter
            case '5':
                return $value / 0.000000000001; // Square Meter to Square Micrometer
            case '6':
                return $value / 10000; // Square Meter to Hectare
            case '7':
                return $value / 2589990; // Square Meter to Square Mile
            case '8':
                return $value / 0.83612736; // Square Meter to Square Yard
            case '9':
                return $value / 0.09290304; // Square Meter to Square Foot
            case '10':
                return $value / 0.000645160; // Square Meter to Square Inch
            case '11':
                return $value / 4046.8564224; // Square Meter to Acre
            default:
                return $value;
        }
    }

    // Volume conversion methods (similar pattern)
    protected function volumeToBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Cubic Meter
            case '2':
                return $value * 1000000000; // Cubic Kilometer to Cubic Meter
            case '3':
                return $value * 0.000001; // Cubic Centimeter to Cubic Meter
            case '4':
                return $value * 1.0e-9; // Cubic Millimeter to Cubic Meter
            case '5':
                return $value * 0.001; // Liter to Cubic Meter
            case '6':
                return $value * 0.000001; // Milliliter to Cubic Meter
            case '7':
                return $value * 0.00378541; // US Gallon to Cubic Meter
            case '8':
                return $value * 0.0009463525; // US Quart to Cubic Meter
            case '9':
                return $value * 0.00047317625; // US Pint to Cubic Meter
            case '10':
                return $value * 0.000236588125; // US Cup to Cubic Meter
            case '11':
                return $value * 0.000029573515625; // US Fluid Ounce to Cubic Meter
            case '12':
                return $value * 0.0000147867578125; // US Table Spoon to Cubic Meter
            case '13':
                return $value * 4.9289192708333333333333333333333e-6; // US Tea Spoon to Cubic Meter
            case '14':
                return $value * 0.00454609; // Imperial Gallon to Cubic Meter
            case '15':
                return $value * 0.0011365225; // Imperial Quart to Cubic Meter
            case '16':
                return $value * 0.00056826125; // Imperial Pint to Cubic Meter
            case '17':
                return $value * 0.0000284130625; // Imperial Fluid Ounce to Cubic Meter
            case '18':
                return $value * 0.0000177581640625; // Imperial Table Spoon to Cubic Meter
            case '19':
                return $value * 5.9193880208333333333333333333333e-6; // Imperial Tea Spoon to Cubic Meter
            case '20':
                return $value * 4.16818e+9; // Cubic Mile to Cubic Meter
            case '21':
                return $value * 0.764554857984; // Cubic Yard to Cubic Meter
            case '22':
                return $value * 0.028316846592; // Cubic Foot to Cubic Meter
            case '23':
                return $value * 0.000016387064; // Cubic Inch to Cubic Meter
            default:
                return $value;
        }
    }

    protected function volumeFromBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Cubic Meter
            case '2':
                return $value / 1000000000; // Cubic Meter to Cubic Kilometer
            case '3':
                return $value / 0.000001; // Cubic Meter to Cubic Centimeter
            case '4':
                return $value / 1.0e-9; // Cubic Meter to Cubic Millimeter
            case '5':
                return $value / 0.001; // Cubic Meter to Liter
            case '6':
                return $value / 0.000001; // Cubic Meter to Milliliter
            case '7':
                return $value / 0.00378541; // Cubic Meter to US Gallon
            case '8':
                return $value / 0.0009463525; // Cubic Meter to US Quart
            case '9':
                return $value / 0.00047317625; // Cubic Meter to US Pint
            case '10':
                return $value / 0.000236588125; // Cubic Meter to US Cup
            case '11':
                return $value / 0.000029573515625; // Cubic Meter to US Fluid Ounce
            case '12':
                return $value / 0.0000147867578125; // Cubic Meter to US Table Spoon
            case '13':
                return $value / 4.9289192708333333333333333333333e-6; // Cubic Meter to US Tea Spoon
            case '14':
                return $value / 0.00454609; // Cubic Meter to Imperial Gallon
            case '15':
                return $value / 0.0011365225; // Cubic Meter to Imperial Quart
            case '16':
                return $value / 0.00056826125; // Cubic Meter to Imperial Pint
            case '17':
                return $value / 0.0000284130625; // Cubic Meter to Imperial Fluid Ounce
            case '18':
                return $value / 0.0000177581640625; // Cubic Meter to Imperial Table Spoon
            case '19':
                return $value / 5.9193880208333333333333333333333e-6; // Cubic Meter to Imperial Tea Spoon
            case '20':
                return $value / 4.16818e+9; // Cubic Meter to Cubic Mile
            case '21':
                return $value / 0.764554857984; // Cubic Meter to Cubic Yard
            case '22':
                return $value / 0.028316846592; // Cubic Meter to Cubic Foot
            case '23':
                return $value / 0.000016387064; // Cubic Meter to Cubic Inch
            default:
                return $value;
        }
    }

    // Weight conversion methods
    protected function weightToBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Kilogram
            case '2':
                return $value * 0.001; // Gram to Kilogram
            case '3':
                return $value * 0.000001; // Milligram to Kilogram
            case '4':
                return $value * 1000; // Metric Ton to Kilogram
            case '5':
                return $value * 1016.04608; // Long Ton to Kilogram
            case '6':
                return $value * 907.184; // Short Ton to Kilogram
            case '7':
                return $value * 0.453592; // Pound to Kilogram
            case '8':
                return $value * 0.0283495; // Ounce to Kilogram
            case '9':
                return $value * 0.0002; // Carrat to Kilogram
            case '10':
                return $value * 1.6605401999104288e-27; // Atomic Mass Unit to Kilogram
            default:
                return $value;
        }
    }

    protected function weightFromBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Kilogram
            case '2':
                return $value / 0.001; // Kilogram to Gram
            case '3':
                return $value / 0.000001; // Kilogram to Milligram
            case '4':
                return $value / 1000; // Kilogram to Metric Ton
            case '5':
                return $value / 1016.04608; // Kilogram to Long Ton
            case '6':
                return $value / 907.184; // Kilogram to Short Ton
            case '7':
                return $value / 0.453592; // Kilogram to Pound
            case '8':
                return $value / 0.0283495; // Kilogram to Ounce
            case '9':
                return $value / 0.0002; // Kilogram to Carrat
            case '10':
                return $value / 1.6605401999104288e-27; // Kilogram to Atomic Mass Unit
            default:
                return $value;
        }
    }

    // Time conversion methods
    protected function timeToBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Second
            case '2':
                return $value * 0.001; // Millisecond to Second
            case '3':
                return $value * 0.000001; // Microsecond to Second
            case '4':
                return $value * 0.000000001; // Nanosecond to Second
            case '5':
                return $value * 0.000000000001; // Picosecond to Second
            case '6':
                return $value * 60; // Minute to Second
            case '7':
                return $value * 3600; // Hour to Second
            case '8':
                return $value * 86400; // Day to Second
            case '9':
                return $value * 604800; // Week to Second
            case '10':
                return $value * 2629800; // Month to Second (approximate)
            case '11':
                return $value * 31557600; // Year to Second (approximate)
            default:
                return $value;
        }
    }

    protected function timeFromBase($value, $unit)
    {
        switch ($unit) {
            case '1':
                return $value; // Second
            case '2':
                return $value / 0.001; // Second to Millisecond
            case '3':
                return $value / 0.000001; // Second to Microsecond
            case '4':
                return $value / 0.000000001; // Second to Nanosecond
            case '5':
                return $value / 0.000000000001; // Second to Picosecond
            case '6':
                return $value / 60; // Second to Minute
            case '7':
                return $value / 3600; // Second to Hour
            case '8':
                return $value / 86400; // Second to Day
            case '9':
                return $value / 604800; // Second to Week
            case '10':
                return $value / 2629800; // Second to Month (approximate)
            case '11':
                return $value / 31557600; // Second to Year (approximate)
            default:
                return $value;
        }
    }

    protected function formatResult($value)
    {
        if (is_nan($value)) {
            return '';
        }

        // Format the result similar to your get_final_res function
        $formatted = number_format($value, 12, '.', '');
        $formatted = rtrim($formatted, '0');
        $formatted = rtrim($formatted, '.');

        return $formatted;
    }

    public function updated($property)
    {
        if ($property === 'calculatorName') {
            // Reset units when calculator type changes
            $this->fromUnit = '1';
            $this->toUnit = '2';
            $this->fromValue = '';
            $this->toValue = '';
            $this->showResult = false;
        } elseif ($property === 'fromValue' || $property === 'fromUnit' || $property === 'toUnit') {
            $this->calculate();
        } elseif ($property === 'toValue') {
            $this->reverseCalculate();
        }
    }

    public function render()
    {
        return view('livewire.unit-converter');
    }
}

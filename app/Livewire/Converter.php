<?php

namespace App\Livewire;

use Livewire\Component;

class Converter extends Component
{
    public $page;
    public $device;
    public $lang;
    public $fromValue = '';
    public $toValue = '';
    public $fromUnit;
    public $toUnit;
    public $showResult = false;
    public $resultText = '';

    protected $listeners = ['copyResult'];

    public function mount($page, $device, $lang)
    {
        $this->page = $page;
        $this->device = $device;
        $this->lang = $lang;
        
        // Get all options
        $options = $this->loadOptions();
        $toOptions = $this->loadOptions(true);
        
        // Set fromUnit to first option
        $this->fromUnit = $options[0]['value'] ?? null;
        
        // Set toUnit to second option (if exists)
        $this->toUnit = $toOptions[1]['value'] ?? ($toOptions[0]['value'] ?? null);
        
        $this->fromValue = '1'; // Default input value
        $this->calculate(); // Perform initial calculation
    }

    public function updatedFromValue()
    {
        $this->calculate();
    }

    public function updatedToValue()
    {
        $this->revCalculate();
    }

    public function updatedFromUnit()
    {
        $this->calculate();
    }

    public function updatedToUnit()
    {
        $this->calculate();
    }

    private function loadOptions($forTo = false)
    {
        $options = [];
        $bladeContent = view('converters.' . $this->page, [
            'first' => $forTo,
            'lang' => $this->lang
        ])->render();
        
        $dom = new \DOMDocument();
        @$dom->loadHTML($bladeContent);
        $selectElements = $dom->getElementsByTagName('option');
        
        foreach ($selectElements as $option) {
            $value = $option->getAttribute('value');
            $text = $option->nodeValue;
            $selected = $option->hasAttribute('selected');
            
            $options[] = [
                'value' => $value,
                'text' => $text,
                'selected' => $selected
            ];
        }
        
        return $options;
    }

    public function render()
    {
        return view('livewire.converter', [
            'options' => $this->loadOptions(),
            'toOptions' => $this->loadOptions(true)
        ]);
    }

    public function calculate()
    {
        if ($this->fromValue === '') {
            $this->showResult = false;
            $this->toValue = '';
            return;
        }

        $ans = $this->performCalculation($this->fromValue, $this->fromUnit, $this->toUnit);
        
        $this->toValue = $ans;
        $this->resultText = $this->getResultText($ans, $this->toUnit);
        $this->showResult = true;
    }

    public function revCalculate()
    {
        if ($this->toValue === '') {
            $this->showResult = false;
            $this->fromValue = '';
            return;
        }

        $ans = $this->performCalculation($this->toValue, $this->toUnit, $this->fromUnit);
        
        $this->fromValue = $ans;
        $this->resultText = $this->getResultText($ans, $this->fromUnit);
        $this->showResult = true;
    }

    private function performCalculation($value, $fromUnit, $toUnit)
    {
        if ($this->page == 'temperature-converter') {
            return $this->calculateTemperature($value, $fromUnit, $toUnit);
        } elseif ($this->page == 'numbers-converter') {
            return $this->convertBase($value, $fromUnit, $toUnit);
        } else {
            return $this->calculateStandard($value, $fromUnit, $toUnit);
        }
    }

    private function calculateTemperature($value, $fromUnit, $toUnit)
    {
        // Convert from source unit to Celsius first
        $celsius = match($fromUnit) {
            '1' => $value,
            '2' => $value - 273.15,
            '3' => ($value - 32) * (5 / 9),
            '4' => ($value - 491.67) * 5 / 9,
            '5' => $value * 1.25,
            '6' => ($value * 273.16) - 273.15,
            default => $value,
        };

        // Convert from Celsius to target unit
        return match($toUnit) {
            '1' => $celsius,
            '2' => $celsius + 273.15,
            '3' => ($celsius * (9 / 5)) + 32,
            '4' => ($celsius * (9 / 5)) + 491.67,
            '5' => $celsius * 0.8,
            '6' => ($celsius + 273.15) / 273.16,
            default => $celsius,
        };
    }

    private function convertBase($value, $fromBase, $toBase)
    {
        $range = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+/';
        $fromRange = substr($range, 0, $fromBase);
        $toRange = substr($range, 0, $toBase);

        $decValue = 0;
        $value = strtolower($value);
        $length = strlen($value);
        
        for ($i = 0; $i < $length; $i++) {
            $digit = $value[$length - 1 - $i];
            $pos = strpos($fromRange, $digit);
            if ($pos === false) {
                continue;
            }
            $decValue += $pos * (pow($fromBase, $i));
        }

        $newValue = '';
        while ($decValue > 0) {
            $newValue = $toRange[$decValue % $toBase] . $newValue;
            $decValue = (int)($decValue / $toBase);
        }

        return $newValue ?: '0';
    }

    private function calculateStandard($value, $fromUnit, $toUnit)
    {
        if (str_contains($fromUnit, ':') || str_contains($toUnit, ':')) {
            if (str_contains($fromUnit, ':')) {
                $tempF = explode(':', $fromUnit);
                if (str_contains($toUnit, ':')) {
                    $tempT = explode(':', $toUnit);
                    return $value * $tempT[1] / $tempF[1];
                } else {
                    return (1 / $value) * $tempF[1] * $toUnit;
                }
            } else {
                $tempT = explode(':', $toUnit);
                return (1 / $value) * $fromUnit * $tempT[1];
            }
        } else {
            return $toUnit / ($fromUnit / $value);
        }
    }

    private function getFinalRes($finalRes)
    {
        $valStr = (string)$finalRes;
        
        if (strpos($valStr, 'N') !== false || ($finalRes == 2 * $finalRes && $finalRes == 1 + $finalRes)) {
            return 'Error';
        }
        
        $i = strpos($valStr, 'e');
        if ($i !== false) {
            $expStr = substr($valStr, $i + 1);
            if ($i > 11) $i = 11;
            $valStr = substr($valStr, 0, $i);
            
            if (!str_contains($valStr, '.')) {
                $valStr .= '.';
            } else {
                $j = strlen($valStr) - 1;
                while ($j >= 0 && $valStr[$j] == '0') $j--;
                $valStr = substr($valStr, 0, $j + 1);
            }
            
            return $valStr . 'E' . $expStr;
        }
        
        $valNeg = $finalRes < 0;
        if ($valNeg) {
            $finalRes = -$finalRes;
        }
        
        $valInt = floor($finalRes);
        $valFrac = $finalRes - $valInt;
        $prec = 12 - strlen((string)$valInt) - 1;
        
        $mult = (int)substr('1000000000000000000', 0, $prec + 1);
        $frac = floor($valFrac * $mult + 0.5);
        $valInt = floor(floor($finalRes * $mult + 0.5)) / $mult;
        
        $valStr = $valNeg ? '-' . $valInt : (string)$valInt;
        $fracStr = substr('00000000000000' . $frac, -$prec);
        $i = strlen($fracStr) - 1;
        
        while ($i >= 0 && $fracStr[$i] == '0') $i--;
        $fracStr = substr($fracStr, 0, $i + 1);
        
        if ($i >= 0) $valStr .= '.' . $fracStr;
        
        return $valStr;
    }

    private function getResultText($value, $unitValue)
    {
        $options = $this->loadOptions();
        $unitText = '';
        
        foreach ($options as $option) {
            if ($option['value'] == $unitValue) {
                $unitText = $option['text'];
                break;
            }
        }
        
        return $value . ' ' . $unitText;
    }


      public function copyResult()
    {
        $textToCopy = $this->resultText;
        $this->dispatch('copy-to-clipboard', [
            'text' => $textToCopy,
            'message' => 'Result copied to clipboard!',
        ]);
    }
    
}
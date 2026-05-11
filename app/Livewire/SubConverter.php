<?php

namespace App\Livewire;

use Livewire\Component;

class SubConverter extends Component
{
    public $lang;
    public $from;
    public $to;
    public $result;
    public $showResult = false;
    public $device = 'destop';

    public function mount($lang)
    {
        $this->lang = $lang;

        // Clean the formulas when component mounts
        $this->lang['formula1'] = $this->cleanFormula($this->lang['formula1']);
        $this->lang['formula2'] = $this->cleanFormula($this->lang['formula2']);
    }

    private function cleanFormula($formula)
    {
        // Remove all whitespace
        $formula = preg_replace('/\s+/', '', $formula);

        // Remove trailing parenthesis if it's unmatched
        if (substr($formula, -1) === ')' && strpos($formula, '(') === false) {
            $formula = substr($formula, 0, -1);
        }

        // Add 'from' if not present at beginning
        if (!str_starts_with($formula, 'from')) {
            $formula = 'from' . $formula;
        }

        return $formula;
    }

    private function evaluateFormula($value, $formula)
    {
        if (!is_numeric($value)) {
            return "Error: Invalid input";
        }

        try {
            $expression = str_replace('from', (float)$value, $formula);
            $result = eval("return $expression;");
            return is_numeric($result) ? $result : "Error: Invalid calculation";
        } catch (\Throwable $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function calculate()
    {
        // If empty input, clear results
        if ($this->from === '') {
            $this->reset(['to', 'result', 'showResult']);
            return;
        }

        if (!is_numeric($this->from)) {
            $this->showResult = false;
            $this->to = '';
            return;
        }

        $ans = $this->evaluateFormula($this->from, $this->lang['formula1']);

        $this->result = is_numeric($ans)
            ? number_format($ans, 4) . " " . $this->lang['unit2']
            : $ans;

        $this->to = is_numeric($ans) ? $ans : '';
        $this->showResult = true;
    }

    public function revCal()
    {
        // If empty input, clear results
        if ($this->to === '') {
            $this->reset(['from', 'result', 'showResult']);
            return;
        }

        if (!is_numeric($this->to)) {
            $this->showResult = false;
            $this->from = '';
            return;
        }

        $ans = $this->evaluateFormula($this->to, $this->lang['formula2']);

        $this->result = is_numeric($ans)
            ? number_format($ans, 4) . " " . $this->lang['unit1']
            : $ans;

        $this->from = is_numeric($ans) ? $ans : '';
        $this->showResult = true;
    }

    public function resetAll()
    {
        $this->reset(['from', 'to', 'result', 'showResult']);
    }

      public function copyResult()
    {
        $textToCopy = $this->result;

        $this->dispatch('copy-to-clipboard', [
            'text' => $textToCopy,
            'message' => 'Result copied to clipboard!',
        ]);
    }

    public function render()
    {
        return view('livewire.sub-converter');
    }
}

<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;

class NineMonthsFromToday extends Component
{
    public $months = 9;
    public $currentDate;
    public $targetDate;

    public function mount()
    {
        $this->updateCalculation();
    }

    public function updatedMonths()
    {
        if (!is_numeric($this->months)) return;
        $this->updateCalculation();
    }

    public function updateCalculation()
    {
        $this->currentDate = Carbon::now();
        $this->targetDate = $this->currentDate->copy()->addMonths((int)$this->months);
    }

    public function render()
    {
        return view('livewire.calculators.nine-months-from-today');
    }
}

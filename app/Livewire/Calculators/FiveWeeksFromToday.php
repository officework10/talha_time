<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;

class FiveWeeksFromToday extends Component
{
    public $weeks = 5;
    public $currentDate;
    public $targetDate;

    public function mount()
    {
        $this->updateCalculation();
    }

    public function updatedWeeks()
    {
        if (!is_numeric($this->weeks)) return;
        $this->updateCalculation();
    }

    public function updateCalculation()
    {
        $this->currentDate = Carbon::now();
        $this->targetDate = $this->currentDate->copy()->addWeeks((int)$this->weeks);
    }

    public function render()
    {
        return view('livewire.calculators.five-weeks-from-today');
    }
}

<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;

class TwelveWeeksFromToday extends Component
{
    public $weeks = 12;
    public $currentDate;
    public $targetDate;
    public $calendarMonth;
    public $calendarYear;
    public $calendarDays = [];

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
        
        if (!$this->calendarMonth) {
            $this->calendarMonth = $this->targetDate->month;
            $this->calendarYear = $this->targetDate->year;
        }
        
        $this->generateCalendar();
    }

    public function generateCalendar()
    {
        $date = Carbon::create($this->calendarYear, $this->calendarMonth, 1);
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        
        $days = [];
        
        for ($i = 0; $i < $startOfMonth->dayOfWeek; $i++) {
            $days[] = null;
        }
        
        for ($i = 1; $i <= $endOfMonth->day; $i++) {
            $dayDate = Carbon::create($this->calendarYear, $this->calendarMonth, $i);
            $days[] = [
                'day' => $i,
                'date' => $dayDate->toDateString(),
                'isTarget' => $dayDate->isSameDay($this->targetDate),
                'isToday' => $dayDate->isToday()
            ];
        }
        
        $this->calendarDays = $days;
    }

    public function previousMonth()
    {
        if ($this->calendarMonth == 1) {
            $this->calendarMonth = 12;
            $this->calendarYear--;
        } else {
            $this->calendarMonth--;
        }
        $this->generateCalendar();
    }

    public function nextMonth()
    {
        if ($this->calendarMonth == 12) {
            $this->calendarMonth = 1;
            $this->calendarYear++;
        } else {
            $this->calendarMonth++;
        }
        $this->generateCalendar();
    }

    public function render()
    {
        return view('livewire.calculators.twelve-weeks-from-today');
    }
}

<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Carbon\Carbon;

class FortyFiveMinutesFromNow extends Component
{
    public $currentDate;
    public $selectedDate;
    public $calendarMonth;
    public $calendarYear;
    public $calendarDays = [];
    public $currentTime;
    public $timezoneInfo = [];
    public $minutes = 45;

    protected $listeners = ['updateTime'];

    public function mount()
    {
        $this->updateDateTime();
        $this->calendarMonth = $this->currentDate->month;
        $this->calendarYear = $this->currentDate->year;
        $this->generateCalendar();
    }

    public function updateDateTime()
    {
        $this->currentDate = Carbon::now();
        $this->currentTime = $this->currentDate->format('h:i:s A');
        $this->timezoneInfo = [
            'timezone' => config('app.timezone'),
            'offset' => $this->currentDate->format('P'),
        ];
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
                'isCurrent' => $dayDate->isToday()
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

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    public function updateTime()
    {
        $this->updateDateTime();
    }

    public function getDateInfoProperty()
    {
        $current = $this->currentDate;
        $remainingDays = $current->diffInDays($current->copy()->endOfYear());
        $weekNumber = $current->weekOfYear;
        $startOfWeek = $current->copy()->startOfWeek();
        $endOfWeek = $current->copy()->endOfWeek();
        $monthNumber = $current->month;

        return [
            'remainingDays' => $remainingDays,
            'weekNumber' => $weekNumber,
            'startOfWeek' => $startOfWeek->format('l, F j, Y'),
            'endOfWeek' => $endOfWeek->format('l, F j, Y'),
            'monthNumber' => $monthNumber,
        ];
    }

    public function render()
    {
        return view('livewire.calculators.forty-five-minutes-from-now');
    }
}

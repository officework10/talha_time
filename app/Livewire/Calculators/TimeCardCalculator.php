<?php

namespace App\Livewire\Calculators;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TimeCardCalculator extends Component
{
    public $name;
    public $date;
    public $rows = [];
    public $cal_gross = false;
    public $price;
    public $working_hr = false;
    public $working_hours = 8;
    public $working_period = 'day';
    public $overtime_rate = 1.5;
    public $bi_weekly = false;
    public $total_hours_display = '00h 00m';
    public $overtime_hours_display = '00h 00m';
    public $total_gross_pay = 0;
    public $overtime_pay = 0;
    public $device = 'desktop';

    public function resetForm()
    {
        $this->initializeRows();
    }

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->initializeRows();
        $this->device = is_numeric(strpos(strtolower(request()->userAgent()), 'mobile')) ? 'mobile' : 'desktop';
    }

    public function initializeRows()
    {
        $this->name = '';
        $this->date = date('Y-m-d');
        $this->cal_gross = false;
        $this->price = '';
        $this->working_hr = false;
        $this->working_hours = 8;
        $this->working_period = 'day';
        $this->overtime_rate = 1.5;
        $this->bi_weekly = false;
        $this->total_hours_display = '00h 00m';
        $this->overtime_hours_display = '00h 00m';
        $this->total_gross_pay = 0;
        $this->overtime_pay = 0;

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $this->rows = [];
        foreach ($days as $day) {
            $this->addRow($day);
        }
    }

    public function addRow($day)
    {
        $this->rows[] = [
            'day' => $day,
            'start_h' => '',
            'start_m' => '',
            'start_p' => 'AM',
            'end_h' => '',
            'end_m' => '',
            'end_p' => 'PM',
            'break_h' => '',
            'break_m' => '',
            'total' => '0h 0m',
            'total_minutes' => 0,
        ];
    }

    public function updatedBiWeekly($value)
    {
        if ($value) {
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            foreach ($days as $day) {
                $this->addRow($day);
            }
        } else {
            $this->rows = array_slice($this->rows, 0, 7);
        }
        $this->calculate();
    }

    public function updated($propertyName)
    {
        $this->calculate();
    }

    public function calculate()
    {
        $totalMinutesAllDays = 0;
        $overtimeMinutes = 0;

        foreach ($this->rows as $index => &$row) {
            $startMinutes = $this->convertToMinutes($row['start_h'], $row['start_m'], $row['start_p']);
            $endMinutes = $this->convertToMinutes($row['end_h'], $row['end_m'], $row['end_p']);
            $breakMinutes = (intval($row['break_h']) * 60) + intval($row['break_m']);

            if ($row['start_h'] !== '' && $row['end_h'] !== '') {
                $dayTotalMinutes = $endMinutes - $startMinutes - $breakMinutes;
                if ($dayTotalMinutes < 0) $dayTotalMinutes = 0;

                $row['total_minutes'] = $dayTotalMinutes;
                $row['total'] = floor($dayTotalMinutes / 60) . 'h ' . ($dayTotalMinutes % 60) . 'm';

                if ($this->working_hr && $this->working_period === 'day') {
                    $threshold = floatval($this->working_hours) * 60;
                    if ($dayTotalMinutes > $threshold) {
                        $overtimeMinutes += ($dayTotalMinutes - $threshold);
                        $totalMinutesAllDays += $threshold;
                    } else {
                        $totalMinutesAllDays += $dayTotalMinutes;
                    }
                } else {
                    $totalMinutesAllDays += $dayTotalMinutes;
                }
            } else {
                $row['total'] = '0h 0m';
                $row['total_minutes'] = 0;
            }
        }

        if ($this->working_hr && $this->working_period === 'week') {
            $threshold = floatval($this->working_hours) * 60;
            if ($totalMinutesAllDays > $threshold) {
                $overtimeMinutes += ($totalMinutesAllDays - $threshold);
                $totalMinutesAllDays = $threshold;
            }
        }

        $this->total_hours_display = floor($totalMinutesAllDays / 60) . 'h ' . ($totalMinutesAllDays % 60) . 'm';
        $this->overtime_hours_display = floor($overtimeMinutes / 60) . 'h ' . ($overtimeMinutes % 60) . 'm';

        if ($this->cal_gross) {
            $baseRate = floatval($this->price);
            $regularPay = ($totalMinutesAllDays / 60) * $baseRate;
            $this->overtime_pay = ($overtimeMinutes / 60) * ($baseRate * floatval($this->overtime_rate));
            $this->total_gross_pay = $regularPay + $this->overtime_pay;
        } else {
            $this->total_gross_pay = 0;
            $this->overtime_pay = 0;
        }
    }

    private function convertToMinutes($hour, $minute, $ampm)
    {
        $h = intval($hour);
        $m = intval($minute);
        if ($ampm === 'PM' && $h !== 12) {
            $h += 12;
        } elseif ($ampm === 'AM' && $h === 12) {
            $h = 0;
        }
        return ($h * 60) + $m;
    }

    public function render()
    {
        $cal_data = DB::table('calculators')->where('cal_link', 'time-card-calculator')->first();
        $lang = $cal_data ? json_decode($cal_data->lang_keys, true) : [];
        
        return view('livewire.calculators.time-card-calculator', [
            'lang' => $lang,
            'type' => request()->get('type', 'full')
        ]);
    }
}

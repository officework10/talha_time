<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface CalculatorRepositoryInterface
{
    /**
     * Handle general calculation requests.
     *
     * @param Request $request
     * @param string $calculatorType
     * @return array
     */
    public function calculate(Request $request, string $calculatorType);

    /**
     * Handle time-related calculations.
     *
     * @param Request $request
     * @return array
     */
    public function time(Request $request);


    // Phase 1 Methods
    public function reading(Request $request);

    // Phase 2 Methods
    public function add(Request $request);
    public function lead(Request $request);
    public function military_time(Request $request);
    public function elapsed(Request $request);
    public function date(Request $request);
    public function business(Request $request);
    public function working(Request $request);
    public function month(Request $request);
    public function date_duration(Request $request);

    // Phase 3 Methods
    // Phase 3 Methods
    public function deadline(Request $request);
    public function birthyear(Request $request);
    public function time_until(Request $request);
    public function week_calc(Request $request);
    public function days_from(Request $request);
    public function weeks_from(Request $request);
    public function years_from(Request $request);
    public function hours_from(Request $request);
    public function weeks_ago(Request $request);
    public function time_ago(Request $request);
    public function year_ago(Request $request);
    public function days_ago(Request $request);
    public function months_from(Request $request);
    public function days_since(Request $request);
    public function weeks_left(Request $request);
    public function birthday_days(Request $request);
    public function days_left(Request $request);
    public function julians(Request $request);
    public function months_left(Request $request);
    public function weeks_between(Request $request);

    // Phase 4 Methods
    public function playback_speed_calculator(Request $request);
    public function thirty_days_from_today_calculator(Request $request);
    public function hours(Request $request);
    public function decimal_to_time(Request $request);
    public function time_to_decimal(Request $request);
    public function days_until(Request $request);
    public function doubling(Request $request);
    public function time_flight(Request $request);
    public function SleepCalculator(Request $request);
    public function travel(Request $request);
    public function overtime(Request $request);
    public function time_and_half(Request $request);
    public function average(Request $request);
    public function dilation(Request $request);

    // Phase 5 Methods
    public function time_card(Request $request);
}

<?php

namespace App\Livewire\Search;

use Livewire\Component;
use Livewire\Attributes\On;

class SearchTwo extends Component
{
    public $search = '';
    public $suggestions = [];
    public $showSuggestions = false;
    public $highlightIndex = -1;
    protected $listeners = ['closeSearchModal' => 'clearSearch'];
     protected $searchCalculators = [
        ["Time Calculator", "time-calculator/", "Date & Time"],
        ["Time to Decimal", "time-to-decimal/", "Date & Time"],
        ["Time Duration Calculator", "time-duration-calculator/", "Date & Time"],
        ["Time Span Calculator", "time-span-calculator/", "Date & Time"],
        ["Time and a Half Calculator", "time-and-a-half-calculator/", "Date & Time"],
        ["Time Dilation Calculator", "time-dilation-calculator/", "Date & Time"],
        ["Average Time Calculator", "average-time-calculator/", "Date & Time"],
        ["Reading time Calculator", "reading-time-calculator/", "Date & Time"],
        ["Military Time Converter", "military-time-converter/", "Date & Time"],
        ["add time calculator", "add-time-calculator/", "Date & Time"],
        ["Lead time Calculator", "lead-time-calculator/", "Date & Time"],
        ["Time Card Calculator", "time-card-calculator/", "Date & Time"],
        ["Overtime Calculator", "overtime-calculator/", "Date & Time"],
        ["Travel Time Calculator", "travel-time-calculator/", "Date & Time"],
        ["Driving Time Calculator", "driving-time-calculator/", "Date & Time"],
        ["Sleep Calculator", "sleep-calculator/", "Date & Time"],
        ["Time of Flight Calculator", "time-of-flight-calculator/", "Date & Time"],
        ["Doubling Time Calculator", "doubling-time-calculator/", "Date & Time"],
        ["What Is Today’s Date?", "todays-date/", "Date & Time"],
        ["Date Calculator", "date-calculator/", "Date & Time"],
        ["Date Duration Calculator", "date-duration-calculator/", "Date & Time"],
        ["Time Until Calculator", "time-until-calculator/", "Date & Time"],
        ["Date Until Calculator", "date-until-calculator/", "Date & Time"],
        ["Decimal to Time", "decimal-to-time/", "Date & Time"],
        ["Hours Calculator", "hours-calculator/", "Date & Time"],
        ["Days From Today Calculator", "days-from-today/", "Date & Time"],
        ["Week Calculator", "week-calculator/", "Date & Time"],
        ["Month Calculator", "month-calculator/", "Date & Time"],
        ["Deadline Calculator", "deadline-calculator/", "Date & Time"],
        ["Working Days Calculator", "working-days-calculator/", "Date & Time"],
        ["Birth Year Calculator", "birth-year-calculator/", "Date & Time"],
        ["Business Days Calculator", "business-days-calculator/", "Date & Time"],
        ["Elapsed Time Calculator", "elapsed-time-calculator/", "Date & Time"],
        ["Days Until Calculator", "days-until-calculator/", "Date & Time"],
        ["Weeks From Today Calculator", "weeks-from-today/", "Date & Time"],
        ["Years From Today Calculator", "years-from-today/", "Date & Time"],
        ["Hours From Now Calculator", "hours-from-now/", "Date & Time"],
        ["Time Ago Calculator", "hours-ago-calculator/", "Date & Time"],
        ["Years Ago Calculator", "years-ago-calculator/", "Date & Time"],
        ["Weeks Ago Calculator", "weeks-ago-calculator/", "Date & Time"],
        ["Days ago calculator", "days-ago-calculator/", "Date & Time"],
        ["Julians Date Calendar", "julians-date-calculator/", "Date & Time"],
        ["Months From Now Calculator", "months-from-now/", "Date & Time"],
        ["How Many Weeks Left In 2026?", "weeks-left-in-the-year/", "Date & Time"],
        ["How Many Months Left In 2026?", "months-left-in-the-year/", "Date & Time"],
        ["Days Since Date Calculator", "days-since-date-calculator/", "Date & Time"],
        ["Playback Speed Calculator", "playback-speed-calculator/", "Date & Time"],
        ["What Is 4 weeks from Today?", "four-weeks-from-today/", "Date & Time"],
        ["What Time Is 3 Hours From Now?", "three-hours-from-now-calculator/", "Date & Time"],
        ["What Time Is 16 Hours From Now?", "sixteen-hours-from-now-calculator/", "Date & Time"],
        ["What Time Is 12 Hours From Now?", "twelve-hours-from-now-calculator/", "Date & Time"],
        ["What Time Is 72 Hours From Now?", "seventy-two-hours-from-now-calculator/", "Date & Time"],
        ["What Time Was It 7 Hours Ago?", "seven-hours-ago-calculator/", "Date & Time"],
        ["What Time Is 6 Hours From Now?", "six-hours-from-now-calculator/", "Date & Time"],
        ["What Time Is 7 Hours From Now?", "seven-hours-from-now-calculator/", "Date & Time"],
        ["What Time Is 4 Hours From Now?", "four-hours-from-now-calculator/", "Date & Time"],
        ["What Time Is 5 Hours From Now?", "five-hours-from-now-calculator/", "Date & Time"],
        ["Weeks Between Dates Calculator", "weeks-between-dates-calculator/", "Date & Time"],
        ["How Many Days Till My Birthday?", "how-many-days-until-my-birthday/", "Date & Time"],
        ["How Many Days Are Left in 2026?", "days-left-in-the-year/", "Date & Time"],
        ["What Date Is 30 Days From Today?", "thirty-days-from-today-calculator/", "Date & Time"],
        ["What Date Is 60 Days From Today?", "sixty-days-from-today-calculator/", "Date & Time"],
        ["What Date Is 180 Days From Today", "one-hundred-eighty-days-from-today-calculator/", "Date & Time"],
        ["What Date is 28 Days From Today?", "twenty-eight-days-from-today-calculator/", "Date & Time"],
        ["What Date is 120 Days From Today?", "one-hundred-twenty-days-from-today-calculator/", "Date & Time"],
        ["What Date is 14 Days From Today?", "fourteen-days-from-today-calculator/", "Date & Time"],
        ["What Date Is 21 Days from Today?", "twenty-one-days-from-today-calculator/", "Date & Time"],
        ["What Date Is 3 months from Today?", "three-months-from-today/", "Date & Time"],
        ["What Time Is 5 minutes from now?", "five-minutes-from-now/", "Date & Time"],
        ["What Time Is 8 hours from now?", "eight-hours-from-now/", "Date & Time"],
        ["What Time Is 10 hours from now?", "ten-hours-from-now/", "Date & Time"],
        ["What Time Is 16 hours from now?", "sixteen-hours-from-now/", "Date & Time"],
        ["What Time Is 18 hours from now?", "eighteen-hours-from-now/", "Date & Time"],
        ["What Time Is 20 hours from now?", "twenty-hours-from-now/", "Date & Time"],
        ["What Time Was It 6 hours ago?", "six-hours-ago/", "Date & Time"],
        ["What Time Was It 8 hours ago?", "eight-hours-ago/", "Date & Time"],
        ["What Time Was It 9 hours ago?", "nine-hours-ago/", "Date & Time"],
        ["What Time Was It 11 hours ago?", "eleven-hours-ago/", "Date & Time"],
        ["What Time Was It 15 hours ago?", "fifteen-hours-ago/", "Date & Time"],
        ["What Time Was It 17 hours ago?", "seventeen-hours-ago/", "Date & Time"],
        ["What Time Was It 19 hours ago?", "nineteen-hours-ago/", "Date & Time"],
        ["What Time is 10 minutes from now?", "ten-minutes-from-now/", "Date & Time"],
        ["What Time is 15 minutes from now?", "fifteen-minutes-from-now/", "Date & Time"],
        ["What Time is 20 minutes from now?", "twenty-minutes-from-now/", "Date & Time"],
        ["What Time is 25 minutes from now?", "twenty-five-minutes-from-now/", "Date & Time"],
        ["What Time is 30 minutes from now?", "thirty-minutes-from-now/", "Date & Time"],
        ["What Time is 45 minutes from now?", "forty-five-minutes-from-now/", "Date & Time"],
        ["What Date is 4 months from today?", "four-months-from-today/", "Date & Time"],
        ["What Date is 6 months from today?", "six-months-from-today/", "Date & Time"],
        ["What Date is 8 months from today?", "eight-months-from-today/", "Date & Time"],
        ["What Date is 9 months from today?", "nine-months-from-today/", "Date & Time"],
        ["What Date is 18 months from today?", "eighteen-months-from-today/", "Date & Time"],
        ["What is 5 weeks from today?", "five-weeks-from-today/", "Date & Time"],
        ["What is 8 weeks from today?", "eight-weeks-from-today/", "Date & Time"],
        ["What is 10 weeks from today?", "ten-weeks-from-today/", "Date & Time"],
        ["What is 12 weeks from today?", "twelve-weeks-from-today/", "Date & Time"],
        ["What is 14 weeks from today?", "fourteen-weeks-from-today/", "Date & Time"],
        ["What is 20 weeks from today?", "twenty-weeks-from-today/", "Date & Time"],
    ];

    public function updatedSearch($value)
    {
        $this->highlightIndex = -1;

        if (empty($value)) {
            $this->suggestions = [];
            $this->showSuggestions = false;
            return;
        }

        $value = strtolower($value);

        // Filter suggestions
        $this->suggestions = array_values(array_filter(
            $this->searchCalculators,
            function ($calc) use ($value) {
                $name = strtolower($calc[0]);
                return strpos($name, $value) === 0 || strpos($name, ' ' . $value) !== false;
            }
        ));

        // Sort suggestions - exact matches first, then word-start matches
        usort($this->suggestions, function ($a, $b) use ($value) {
            $aName = strtolower($a[0]);
            $bName = strtolower($b[0]);

            $aScore = strpos($aName, $value) === 0 ? 2 : (strpos($aName, ' ' . $value) !== false ? 1 : 0);
            $bScore = strpos($bName, $value) === 0 ? 2 : (strpos($bName, ' ' . $value) !== false ? 1 : 0);

            return $bScore <=> $aScore;
        });

        $this->showSuggestions = true;
    }

    public function moveHighlight($direction)
    {
        if (empty($this->suggestions)) return;

        if ($direction === 'up') {
            $this->highlightIndex = $this->highlightIndex <= 0
                ? count($this->suggestions) - 1
                : $this->highlightIndex - 1;
        } else {
            $this->highlightIndex = $this->highlightIndex >= count($this->suggestions) - 1
                ? 0
                : $this->highlightIndex + 1;
        }
    }
    public function selectCalculator($index = null)
    {
        $index = $index ?? $this->highlightIndex;

        if (isset($this->suggestions[$index])) {
            $this->showSuggestions = false;
            return redirect()->to('/' . $this->suggestions[$index][1]);
        }
    }
    public function highlight($text)
    {
        if (empty($this->search)) return e($text);

        $pattern = '/(' . preg_quote($this->search, '/') . ')/i';
        return preg_replace($pattern, '<strong class="text-blue-600">$0</strong>', e($text));
    }

    public function hideSuggestions()
    {
        $this->showSuggestions = false;
    }

    public function clearSearch()
    {
        $this->reset(['search', 'suggestions', 'highlightIndex', 'showSuggestions']);
    }

    public function render()
    {
        return view('livewire.search.search-two');
    }
}

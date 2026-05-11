<?php

namespace App\Livewire\Search;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class UnitSearch extends Component
{
    public $query = '';
    public $results = [];

    public function updatedQuery()
    {
        if (!empty($this->query)) {
            $this->results = DB::table('calculators')
                ->select('image_class', 'cal_link', 'cal_title', 'is_calculator')
                ->where('image_class', 'like', '%' . $this->query . '%')
                ->where('is_calculator', 'Sub-Converter')
                ->get()
                ->toArray();
        } else {
            $this->results = [];
        }
    }

    private function highlightMatch($text, $query)
    {
        $escapedQuery = preg_quote($query, '/');
        return preg_replace_callback("/($escapedQuery)/i", function ($match) {
            return '<strong class="text-blue-600">' . $match[0] . '</strong>';
        }, $text);
    }

    public function render()
    {
        return view('livewire.search.unit-search')->with([
            'highlightMatch' => function ($text, $query) {
                return $this->highlightMatch($text, $query);
            }
        ]);
    }
}

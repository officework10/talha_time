<?php

namespace App\Livewire\Component;

use Livewire\Component;

class RelatedCalculator extends Component
{
    public $relatedCal;
    public $calName;

    public function mount($relatedCal, $calName)
    {
        $this->relatedCal = $relatedCal;
        $this->calName = $calName;
    }
    public function render()
    {
        return view('livewire.component.related-calculator');
    }
}

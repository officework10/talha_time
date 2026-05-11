<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Breadcrumb extends Component
{

    public $calData;
    public $calCat;
    public $brudcumParent;
    public function render()
    {
        return view('livewire.component.breadcrumb');
    }
}

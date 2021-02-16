<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use App\Models\material;

class DashSummary extends Component
{
    public $products;
    public $materials;

    public function mount(){
        $this->products = product::all();
        $this->materials = material::all();
    }

    public function render()
    {
        return view('livewire.dash-summary');
    }
}

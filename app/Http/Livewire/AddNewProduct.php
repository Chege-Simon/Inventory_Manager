<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\product;
use App\Models\Measurement;
use Illuminate\Validation\ValidationException;

class AddNewProduct extends Component
{
    public $units;
    public $product_name;
    public $unit;
    public $quantity;
    public $upper_threshold;
    public $lower_threshold;

    protected $rules = [
        'upper_threshold' => 'required|int',
        'lower_threshold' => 'required|int',
        'quantity' => 'required|int',
    ];

    public function addNewProduct(){
        $this->validate();
        if($this->upper_threshold <= $this->lower_threshold){
            throw ValidationException::withMessages(['upper_threshold' => 'Must Be Greater Than Lower Threshold']);
        }elseif ($this->lower_threshold >= $this->upper_threshold){
            throw ValidationException::withMessages(['upper_threshold' => 'Must Be Greater Than Lower Threshold']);
        }

        product::create([
            'product_name' => $this->product_name,
            'product_quantity' => $this->quantity." ".$this->unit,
            'product_upper_threshold' => $this->upper_threshold,
            'product_lower_threshold' => $this->lower_threshold,
            'product_count' => 0,
        ]);

        session()->flash('message', 'New Product Added Successfully.');
        $this->redirect('/products');
    }

    public function mount(){
        $this->units = Measurement::all();
    }

    public function render()
    {
        return view('livewire.add-new-product')
            ->layout('layouts.app',['header' => 'Add New Product']);
    }
}

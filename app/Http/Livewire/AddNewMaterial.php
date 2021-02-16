<?php

namespace App\Http\Livewire;

use App\Models\Measurement;
use App\Models\material;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AddNewMaterial extends Component
{
    public $units;
    public $material_name;
    public $unit;
    public $quantity;
    public $upper_threshold;
    public $lower_threshold;

    protected $rules = [
        'upper_threshold' => 'required|int',
        'lower_threshold' => 'required|int',
        'quantity' => 'required|int',
    ];

    public function addNewMaterial(){
        $this->validate();

        if($this->upper_threshold <= $this->lower_threshold){
            throw ValidationException::withMessages(['upper_threshold' => 'Must Be Greater Than Lower Threshold']);
        }elseif ($this->lower_threshold >= $this->upper_threshold){
            throw ValidationException::withMessages(['upper_threshold' => 'Must Be Greater Than Lower Threshold']);
        }
        material::create([
            'material_name' => $this->material_name,
            'material_quantity' => $this->quantity." ".$this->unit,
            'material_upper_threshold' => $this->upper_threshold,
            'material_lower_threshold' => $this->lower_threshold,
            'material_count' => 0,
        ]);


        session()->flash('message', ' Material Added Successfully.');
        $this->redirect('/materials');
    }

    public function mount(){
        $this->units = Measurement::all();
    }

    public function render()
    {
        return view('livewire.add-new-material')
            ->layout('layouts.app',['header' => 'Add New Material']);
    }
}

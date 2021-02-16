<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Measurement;

class Settings extends Component
{
    public $units;
    public $measurement_unit;
    public $measurement_id;
    public $the_measurement;
    public $open;
    public $add_open;
    public $new_measurement_unit;

    protected $listeners = ['deleteMeasurementUnit'];

    public function addUnit(){
        Measurement::create([
            'value' => $this->new_measurement_unit,
        ]);
        $this->emit('swal:alert', [
            'type' => 'success',
            'title' => 'New Unit Of Measurement Added Successfully',
            'timeout' => 10000
        ]);
        $this->mount();
        $this->closeUnitModal();
    }

    public function openUnitModal(){
        $this->add_open = true;
    }

    public function closeUnitModal(){
        $this->add_open = false;
    }

    public function openModal($id){
        $this->measurement_id = $id;
        $this->the_measurement = Measurement::find($this->measurement_id);
        $this->measurement_unit = $this->the_measurement->value;
        $this->open = true;
    }

    public function closeModal(){
        $this->open = false;
    }
    public function modifyUnit(){
        $this->the_measurement->value =  $this->measurement_unit;

        $this->the_measurement->save();

        $this->closeModal();
        $this->emit('swal:alert', [
            'type' => 'success',
            'title' => 'Unit Of Measurement Modified Successfully',
            'timeout' => 10000
        ]);
        $this->mount();
    }

    public function confirmDelete($id){
        $this->the_measurement = Measurement::find($id);
        $this->emit("swal:confirm", [
            'type'        => 'danger',
            'title'       => 'Confirm Deletion of unit of measurement',
            'text'        => "Measurement: <b class='lead font-weight-bolder' style='font-size: 1.25em'>".$this->the_measurement->value."</b></b><br><hr><br><b>Are you sure you want to delete this Unit Of Measurement?</b><br><h5><b>Caution! This action is unreversable</b></h5>",
            'confirmText' => 'Yes, Delete!',
            'method'      => 'deleteMeasurementUnit',
            'params'      => [], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function deleteMeasurementUnit()
    {
        $this->the_measurement->delete();
        $this->emit('swal:alert', [
            'type' => 'success',
            'title' => 'Unit Of Measurement Deleted Successfully',
            'timeout' => 10000
        ]);
        $this->mount();
    }

    public function mount(){
        $this->units = Measurement::all();
    }
    public function render()
    {
        return view('livewire.settings')
            ->layout('layouts.app', ['header' => 'Settings']);
    }
}

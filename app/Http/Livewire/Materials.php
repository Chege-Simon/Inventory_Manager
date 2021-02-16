<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\material;
use Livewire\WithPagination;

class Materials extends Component
{

    use withPagination;

    private $headers;
    public $sortColumn = 'created_at';
    public $sortDirection = 'asc';
    public $searchTerm = '';
    public $open;
    public $material_id;
    public $the_material;
    public $new_input;
    public $material_upper_threshold;
    public $material_lower_threshold;

    protected $rules = [
        'material_upper_threshold' => 'required|int',
        'material_lower_threshold' => 'required|int',
        'new_input' => 'required|int',
    ];

    protected $listeners = ['deleteMaterial'];

    public function openModal($id){
        $this->material_id = $id;
        $this->the_material = material::find($this->material_id);
        $this->material_upper_threshold = $this->the_material->material_upper_threshold;
        $this->material_lower_threshold = $this->the_material->material_lower_threshold;
        $this->new_input= 0;
        $this->open = true;
    }

    public function closeModal(){
        $this->open = false;
    }

    public function addInput(){
        $this->validate();

        $this->the_material->material_count += $this->new_input;
        $this->the_material->material_upper_threshold =  $this->material_upper_threshold;
        $this->the_material->material_lower_threshold =  $this->material_lower_threshold;

        $this->the_material->save();

        $this->closeModal();
        $this->emit('swal:alert', [
            'type'    => 'success',
            'title'   => 'Fresh Material Added Successfully',
            'timeout' => 10000
        ]);
    }

    public function confirmDelete($id){
        $this->the_material = material::find($id);
        $this->emit("swal:confirm", [
            'type'        => 'danger',
            'title'       => 'Confirm Deletion of material',
            'text'        => "Material: <b class='lead font-weight-bolder' style='font-size: 1.25em'>".$this->the_material->material_name." ".$this->the_material->material_quantity."</b></b><br><hr><br><b>Are you sure you want to delete this material?</b><br><h5><b>Caution! This action is unreversable</b></h5>",
            'confirmText' => 'Yes, Delete!',
            'method'      => 'deleteMaterial',
            'params'      => [], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function deleteMaterial()
    {
        $this->the_material->delete();
        $this->emit('swal:alert', [
            'type' => 'success',
            'title' => 'Material Deleted Successfully',
            'timeout' => 10000
        ]);
    }



    private function headerConfig(){
        return [
            'material_name' => 'Material Name',
            'material_quantity' => 'Material Quantity',
            'material_count' => 'Material Count',
            'updated_at' => 'Updated On',
        ];
    }

    public function mount(){
        $this->headers = $this->headerConfig();
    }

    public function hydrate(){
        $this->headers = $this->headerConfig();
    }

    public function sort($column){
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection== 'asc' ? 'desc':'asc';
    }

    private function resultData(){
        return material::where(function ($query){
            $query->where('material_name', '!=', '');
            if($this->searchTerm != ""){
                $query->where('material_name','like','%'.$this->searchTerm.'%');
                $query->orWhere('material_quantity','like','%'.$this->searchTerm.'%');
                $query->orWhere('material_count','like','%'.$this->searchTerm.'%');
                $query->orWhere('updated_at','like','%'.$this->searchTerm.'%');
            }
        })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate(8);
    }


    public function render()
    {
        return view('livewire.materials',[
            'materials'=> $this->resultData(),
            'headers' => $this->headers
        ])
            ->layout('layouts.app', ['header' => 'All Materials']);
    }
}

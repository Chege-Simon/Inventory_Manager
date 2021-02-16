<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\product;

class Products extends Component
{

    use withPagination;

    private $headers;
    public $sortColumn = 'created_at';
    public $sortDirection = 'asc';
    public $searchTerm = '';
    public $open;
    public $product_id;
    public $the_product;
    public $new_stock;
    public $product_upper_threshold;
    public $product_lower_threshold;

    protected $rules = [
        'product_upper_threshold' => 'required|int',
        'product_lower_threshold' => 'required|int',
        'new_stock' => 'required|int',
    ];

    protected $listeners = ['deleteProduct'];

    public function openModal($id){
        $this->product_id = $id;
        $this->the_product = product::find($this->product_id);
        $this->product_upper_threshold = $this->the_product->product_upper_threshold;
        $this->product_lower_threshold = $this->the_product->product_lower_threshold;
        $this->new_stock = 0;
        $this->open = true;
    }

    public function closeModal(){
        $this->open = false;
    }

    public function addStock(){
        $this->validate();

        $this->the_product->product_count += $this->new_stock;
        $this->the_product->product_upper_threshold =  $this->product_upper_threshold;
        $this->the_product->product_lower_threshold =  $this->product_lower_threshold;

        $this->the_product->save();

        $this->closeModal();
        $this->emit('swal:alert', [
            'type'    => 'success',
            'title'   => 'Stock Added Successfully',
            'timeout' => 10000
        ]);
    }

    public function confirmDelete($id){
        $this->the_product = product::find($id);
        $this->emit("swal:confirm", [
            'type'        => 'danger',
            'title'       => 'Confirm Deletion of Product',
            'text'        => "Product: <b class='lead font-weight-bolder' style='font-size: 1.25em'>".$this->the_product->product_name." ".$this->the_product->product_quantity."</b></b><br><hr><br><b>Are you sure you want to delete this product?</b><br><h5><b>Caution! This action is unreversable</b></h5>",
            'confirmText' => 'Yes, Delete!',
            'method'      => 'deleteProduct',
            'params'      => [], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function deleteProduct()
    {
        $this->the_product->delete();
        $this->emit('swal:alert', [
            'type' => 'success',
            'title' => 'Product Deleted Successfully',
            'timeout' => 10000
        ]);
    }

        private function headerConfig(){
        return [
            'product_name' => 'Product Name',
            'product_quantity' => 'Product Quantity',
            'product_count' => 'Product Count',
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
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc':'asc';
    }

    private function resultData(){
        return product::where(function ($query){
            $query->where('product_name', '!=', '');
            if($this->searchTerm != ""){
                $query->where('product_name','like','%'.$this->searchTerm.'%');
                $query->orWhere('product_quantity','like','%'.$this->searchTerm.'%');
                $query->orWhere('product_count','like','%'.$this->searchTerm.'%');
                $query->orWhere('updated_at','like','%'.$this->searchTerm.'%');
            }
        })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate(8);
    }


    public function render()
    {
        return view('livewire.products',[
            'products' => $this->resultData(),
            'headers' => $this->headers
        ])
            ->layout('layouts.app', ['header' => 'All Products']);
    }
}

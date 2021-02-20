<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use Livewire\Component;

class Sales extends Component
{
    private $headers;
    public $sortColumn = 'created_at';
    public $sortDirection = 'asc';
    public $searchTerm = '';
    public $open;

    private function headerConfig(){
        return [
            'product_id' => 'Product Name',
            'count' => 'Product Quantity',
            'price' => 'Product Count',
            'customer' => 'Customer',
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
        return Sale::where(function ($query){
            $query->where('product_id', '!=', '');
            if($this->searchTerm != ""){
                $query->where('product_id','like','%'.$this->searchTerm.'%');
                $query->where('count','like','%'.$this->searchTerm.'%');
                $query->orWhere('price','like','%'.$this->searchTerm.'%');
                $query->orWhere('customer','like','%'.$this->searchTerm.'%');
                $query->orWhere('updated_at','like','%'.$this->searchTerm.'%');
            }
        })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate(8);
    }


    public function render()
    {
        return view('livewire.sales',
        [
            'sales' => $this->resultData(),
            'headers' => $this->headers
        ])
            ->layout('layouts.app', ['headers' => 'Sales']);
    }
}

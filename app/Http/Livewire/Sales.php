<?php

namespace App\Http\Livewire;

use App\Exports\SalesExport;
use App\Models\Sale;
use Livewire\Component;
use App\Models\product;
use Maatwebsite\Excel\Facades\Excel;

class Sales extends Component
{
    private $headers;
    public $sortColumn = 'created_at';
    public $sortDirection = 'desc';
    public $searchTerm = '';
    public $open;

    public function export(){
        return Excel::download(new SalesExport(), 'All_Sales.xlsx');
    }

    private function headerConfig(){
        return [
            'product_id' => [
                'label'=>'Product',
                'func' => function($value){
                        $product = product::find($value);
                        return  $product->product_name." -- ".$product->product_quantity;
                }
            ],
            'count' => 'Count',
            'price' => 'Price for Each',
            'customer' => 'Customer',
            'updated_at' => 'Purchased On',
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

    public function searchProduct(){
        $product = product::where('product_name','like','%'.$this->searchTerm.'%')->first();
        $id = '';
        if($product != null){
            $id = $product->id;
        }else{
            $id = '';
        }
        return $id;
    }

    private function resultData(){
        return Sale::where(function ($query){
            $query->where('product_id', '!=', '');
            if($this->searchTerm != ""){
                $query->where('product_id','like','%'.$this->searchProduct().'%');
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
            ->layout('layouts.app', ['header' => 'Sales']);
    }
}

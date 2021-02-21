<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sale;
use App\Models\product;

class NewSale extends Component
{
    public $customer;
    public $product_id;
    public $price;
    public $count;
    public $products;

    protected $rules = [
        'customer' => 'required|String',
        'price' => 'required|int',
        'count' => 'required|int',
    ];

    public function newSale(){
        $this->validate();
        Sale::create([
            'customer' => $this->customer,
            'price' => $this->price,
            'product_id' => $this->product_id,
            'count' => $this->count,
        ]);

        $product = product::find($this->product_id);
        $product->product_count -= $this->count;
        $product->save();

        session()->flash('message', 'New Sale Added Successfully.');
        $this->redirect('/sales');
    }
    public function mount(){
        $this->products = product::all();
    }

    public function render()
    {
        return view('livewire.new-sale');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Union;
use Livewire\Component;
use Livewire\WithPagination;

class SearchProduct extends Component
{
    use WithPagination;
    
    public $search;
    public function render()
    {
        $unions=Union::all();
        $suppliers=Supplier::all();
        $products=Product::where('products.name','like','%'.$this->search.'%')->get();
        return view('livewire.search-product',[
            'products'=>$products,
            'unions'=>$unions,
            'suppliers'=>$suppliers,
        ]);
    }
}

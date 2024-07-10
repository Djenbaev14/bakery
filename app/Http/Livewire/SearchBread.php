<?php

namespace App\Http\Livewire;

use App\Models\Bread;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class SearchBread extends Component
{
    
    use WithPagination;
    public $search;
    public function render()
    {
        
        $users=User::where('role_id',3)->get();
        $products=Product::all();
        $breads=Bread::with('bread_product')->where('name','like','%'.$this->search.'%')->get();
        return view('livewire.search-bread',['breads'=>$breads,'products'=>$products,'users'=>$users]);
    }
}

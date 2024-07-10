<?php

namespace App\Http\Livewire;

use App\Models\Coming_product;
use App\Models\Expenditure_product;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProduct extends Component
{
    use WithPagination;
    
    public $product;
    public $start_date;
    public $end_date;
    public $active1 = 'text-primary';
    public $active2 = '';
    public $display1='block';
    public $display2 = 'd-none';

    
    public function coming(){
        $this->display1='block';
        $this->display2='d-none';
        
        $this->active1 = 'text-primary';
        $this->active2 = '';
    }
    public function expenditure(){
        $this->display2='block';
        $this->display1='d-none';
        
        $this->active2 = 'text-primary';
        $this->active1 = '';
    }

    public function mount(Product $product,$start_date,$end_date){
        $this->product=$product;
        $this->start_date=$start_date;
        $this->end_date=$end_date;
    }
    public function render()
    {
        
        $coming_products=Coming_product::where('product_id',$this->product->id)->whereBetween(DB::raw('date(created_at)'),[$this->start_date,$this->end_date])->orderBy('created_at','desc')->get();
        $expenditure_products=Expenditure_product::where('product_id',$this->product->id)->whereBetween(DB::raw('date(created_at)'),[$this->start_date,$this->end_date])->orderBy('created_at','desc')->get();

        return view('livewire.show-product',['coming_products'=>$coming_products,'expenditure_products'=>$expenditure_products]);
    }
}

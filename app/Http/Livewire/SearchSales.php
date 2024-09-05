<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SearchSales extends Component
{
    
    use WithPagination;
    public $search;
    public function render()
    {
        if(auth()->user()->role_id == 3){

            $sales = Sale::where('user_id',auth()->user()->id)->orderBy('created_at','desc')
            ->whereHas('client', function ($query) {
                return $query->where('name','like','%'.$this->search.'%');
            })->paginate(30);
            
        }
        else{
            $sales = Sale::orderBy('created_at','desc')->whereHas('client', function ($query) {
                return $query->where('name','like','%'.$this->search.'%');
            })->orWhereHas('user', function ($query) {
                return $query->where('username','like','%'.$this->search.'%');
            })->paginate(30);  
            
        }
        
        return view('livewire.search-sales',[
            'sales'=>$sales
        ]);
    }
}

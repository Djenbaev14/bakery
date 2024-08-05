<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use App\Models\sale_history;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ExpectedDebt extends Component
{
    public $search;
    // public $sale_histories;
    // public function mount($sale_histories){
    //     $this->sale_histories=$sale_histories->where('paid','like','%'.$this->search.'%')->get();
    // }
    public function render()
    {
        return view('livewire.expected-debt',[
            'sale_histories'=>sale_history::where('status','0')->whereHas('client', function ($query) {
                return $query->where('name','like','%'.$this->search.'%');
            })->orderBy('id','desc')
            ->paginate(20),
            // 'total_paid'=>DB::table('sales')
            // ->join('clients','clients.id','=','sales.client_id')
            // ->where('clients.name','like','%'.$this->search.'%')
            // ->sum('paid')
        ]);
    }
}

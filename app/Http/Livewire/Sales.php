<?php

namespace App\Http\Livewire;

use App\Models\Bread;
use App\Models\Client;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Sales extends Component
{
    protected $rules = [
        'breads.*.vprice' => ['required', 'numeric'],
    ];
    public $clients;
    public $client_id="";
    public $breads;
    public $kindergarden=0;

    public function mount(){
        $this->clients=Client::orderBy('id','desc')->get();
        if(auth()->user()->role_id == 3){
            $this->breads=Bread::with(["delivery" => function($q){$q->where('truck_id', '=', auth()->user()->id);}])
            ->with(["bread_delivery_price" => function($q){$q->where('user_id', '=', auth()->user()->id);}])
            ->with(["refund_bread" => function($q){$q->where('user_id', '=', auth()->user()->id);}])
            ->with(["sale_item" => function($q){$q->where('user_id', '=', auth()->user()->id);}])->get();
            foreach ($this->breads as $bread) {
                $bread->quan=$bread->delivery->sum('quantity')-$bread->sale_item->sum('quantity')-$bread->refund_bread->sum('quantity');
                $bread->vprice=$bread->bread_delivery_price[0]->price;
            }
        }else{
            $this->breads=Bread::with(["sale_item" => function($q){$q->where('user_id', '=', auth()->user()->id);}])->get();
            foreach ($this->breads as $bread) {
                $bread->quan=$bread->quantity+$bread->refund_bread->sum('quantity');
                $bread->vprice=$bread->price;
            }
        }
    }
    public function change(){

        if($this->client_id){
            $this->kindergarden=Client::find($this->client_id)->kindergarden; 
        }
        if(auth()->user()->role_id == 3){
            $this->breads=Bread::with(["delivery" => function($q){$q->where('truck_id', '=', auth()->user()->id);}])
            ->with(["bread_delivery_price" => function($q){$q->where('user_id', '=', auth()->user()->id);}])
            ->with(["refund_bread" => function($q){$q->where('user_id', '=', auth()->user()->id);}])
            ->with(["sale_item" => function($q){$q->where('user_id', '=', auth()->user()->id);}])->get();

            
            if($this->kindergarden==1){
                foreach ($this->breads as $bread) {
                    $bread->quan=$bread->delivery->sum('quantity')-$bread->sale_item->sum('quantity')-$bread->refund_bread->sum('quantity');
                    $bread->vprice=$bread->bread_delivery_price[0]->kindergarden_price;
                }
            }else{
                foreach ($this->breads as $bread) {
                    $bread->quan=$bread->delivery->sum('quantity')-$bread->sale_item->sum('quantity')-$bread->refund_bread->sum('quantity');
                    $bread->vprice=$bread->bread_delivery_price[0]->price;
                }
            }
        }else{
            $this->breads=Bread::all();
            if($this->kindergarden==1){
                foreach ($this->breads as $bread) {
                    $bread->vprice=$bread->kindergarden_price;
                    $bread->quan=$bread->quantity+$bread->refund_bread->sum('quantity');
                }
            }else{
                foreach ($this->breads as $bread) {
                    $bread->vprice=$bread->price;
                    $bread->quan=$bread->quantity+$bread->refund_bread->sum('quantity');
                }
            }
        }
        
        
    }
    
    
    public function render()
    {
        if(auth()->user()->role_id == 3){
            foreach ($this->breads as $bread) {
                $bread->quan=$bread->delivery->sum('quantity')-$bread->sale_item->sum('quantity')-$bread->refund_bread->sum('quantity');
            }
        }else{
            foreach ($this->breads as $bread) {
                $bread->quan=$bread->quantity+$bread->refund_bread->sum('quantity');
            }
        }
        return view('livewire.sales');
    }
}
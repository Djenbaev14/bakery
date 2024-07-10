<?php

namespace App\Http\Livewire;

use App\Models\Bread;
use App\Models\Delivery;
use App\Models\Refund_bread;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class HistoryDelivery extends Component
{
    use WithPagination;

    public $deliveries;
    public $breads;
    public $moveDel;
    public $all_truck;
    public $truck;
    public $refund_breads;
   
    public $truck_id;
    
    // public function mount(){
    //     $this->deliveries=DB::table('deliveries')
    //     ->join('users','users.id','=','deliveries.responsible_id')
    //     ->join('breads','breads.id','=','deliveries.bread_id')
    //     ->where('deliveries.truck_id','=',$this->truck_id)
    //     ->select('deliveries.*','users.username as responsible_name','breads.name as bread_name')
    //     ->orderBy('id','desc')
    //     ->paginate(10);
    //     $this->deliveries=collect($this->deliveries->items());
    // }
   
    public function render()
    {
        $this->breads=Bread::orderBy('created_at','desc')->get();
        if(auth()->user()->role_id == 3){
            $this->truck_id=auth()->user()->id;
            $this->truck=User::where('id',auth()->user()->id)->with('role')->get();

            foreach ($this->breads as $bread) {
                $bread->quantity=warehouse_quan_delivery($bread->id);
            }
        }else{
            $this->truck=User::where('role_id',3)->with('role')->get();

            foreach ($this->breads as $bread) {
                $bread->quantity=warehouse_quan_truck($this->truck_id,$bread->id);
            }
        }

        $this->refund_breads=Refund_bread::where('user_id',$this->truck_id)->where('status','1')->orderBy('created_at','desc')->paginate(30);
        $this->refund_breads=collect($this->refund_breads->items());
        $this->expected_movements=Refund_bread::where('user_id',$this->truck_id)->where('status','0')->orderBy('created_at','desc')->paginate(30);
        $this->expected_movements=collect($this->expected_movements->items());
        $this->deliveries=Delivery::where('deliveries.truck_id','=',$this->truck_id)->orderBy('created_at','desc')->paginate(30);
        $this->deliveries=collect($this->deliveries->items());
        return view('livewire.history-delivery',[
            'deliveries'=>$this->deliveries,
            'truck'=>$this->truck,
            'refund_breads'=>$this->refund_breads,
            'expected_movements'=>$this->refund_breads
        ]);
    }
}

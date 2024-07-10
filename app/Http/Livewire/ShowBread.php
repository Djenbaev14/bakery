<?php

namespace App\Http\Livewire;

use App\Models\Bread;
use App\Models\Client;
use App\Models\Production;
use App\Models\Sale_items;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBread extends Component
{
    use WithPagination;
    
    public $bread;
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
    public function mount(Bread $bread,$start_date,$end_date){
        $this->bread_id=$bread->id;
        $this->start_date=$start_date;
        $this->end_date=$end_date;
    }

    public function render()
    {
        $coming_bread=Production::where('bread_id',$this->bread->id)->whereBetween(DB::raw('date(created_at)'),[$this->start_date,$this->end_date])->orderBy('created_at','desc')->get();
        
        $expenditure_bread=Sale_items::where('bread_id',$this->bread->id)->whereBetween(DB::raw('date(created_at)'),[$this->start_date,$this->end_date])->orderBy('created_at','desc')->get();

        $sellers=User::where('role_id',1)->orWhere('role_id',2)->orWhere('role_id',3)->with(["sale_item" => function($q) {$q->where('bread_id', '=', $this->bread->id)->whereBetween(DB::raw('date(created_at)'), [$this->start_date,$this->end_date]);}])->get();
        

        return view('livewire.show-bread',[
            'coming_bread'=>$coming_bread,
            'expenditure_bread'=>$expenditure_bread,
            'sellers'=>$sellers,
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DebtFilter extends Component
{
    use WithPagination;
    public $search_main;
    public $search_kindergarten;


    

    public function render()
    {
        $total_paid=0;
        if(auth()->user()->role_id == 3){
            $main_sales = Sale::where('user_id',auth()->user()->id)->whereHas('user', function ($query) {
                    return $query->where('id','=',auth()->user()->id);
                })->whereHas('client', function ($query) {
                    return $query->where('name','like','%'.$this->search_main.'%');
                })->whereHas('client', function ($query) {
                    return $query->where('kindergarden',0);
                })->orderBy('created_at','desc')->paginate(20);
                
            $kindergarten_sales = Sale::where('user_id',auth()->user()->id)->whereHas('user', function ($query) {
                return $query->where('id','=',auth()->user()->id);
            })->whereHas('client', function ($query) {
                return $query->where('name','like','%'.$this->search_kindergarten.'%');
            })->whereHas('client', function ($query) {
                    return $query->where('kindergarden',1);
            })->orderBy('created_at','desc')->paginate(20);  
        }else{
            $main_sales = Sale::whereHas('client', function ($query) {
                return $query->where('name','like','%'.$this->search_main.'%');
            })->whereHas('client', function ($query) {
                    return $query->where('kindergarden',0);
                })->orderBy('created_at','desc')->paginate(20); 
            
            $kindergarten_sales = Sale::whereHas('client', function ($query) {
                return $query->where('name','like','%'.$this->search_kindergarten.'%');
            })->whereHas('client', function ($query) {
                        return $query->where('kindergarden',1);
                })->orderBy('created_at','desc')->paginate(20);  
        }
            $main_total_paid=0;
            $kindergarten_total_paid=0;

            foreach($main_sales as $sale){
                $main_total_paid=$main_total_paid+$sale->sale_history->sum('paid');
            }
            $main_total_debt=$main_sales->sum(function($t){return $t->quantity*$t->price;})-$main_total_paid;

            foreach($kindergarten_sales as $sale){
                $kindergarten_total_paid=$kindergarten_total_paid+$sale->sale_history->sum('paid');
            }
            $kindergarten_total_debt=$kindergarten_sales->sum(function($t){return $t->quantity*$t->price;})-$kindergarten_total_paid;
            
            return view('livewire.debt-filter',compact('total_paid','main_sales','kindergarten_sales','main_total_debt','kindergarten_total_debt','main_total_paid','kindergarten_total_paid'));
    }
}

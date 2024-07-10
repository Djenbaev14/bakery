<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HistoryAdmin extends Component
{
    public $user_id;
    public $search;
    public function render()
    {
        return view('livewire.history-admin',[
            'users'=>DB::table('users')
            ->where('users.id','=',$this->user_id)
            ->join('sales','users.id','=','sales.added_id')
            ->join('breads','sales.bread_id','=','breads.id')
            ->join('clients','sales.client_id','=','clients.id')
            ->where('clients.name','like','%'.$this->search.'%')
            ->select('breads.name as bread_name','users.username as responsible','clients.name as client_name','breads.price as bread_price','sales.id','sales.quantity','sales.total_amount','sales.paid','sales.debt as debt','sales.updated_at as updated_at')
            ->orderBy('updated_at','desc')
            ->paginate(10),
            
            'total_amount'=>DB::table('users')
            ->where('users.id','=',$this->user_id)
            ->join('sales','users.id','=','sales.added_id')
            ->join('clients','sales.client_id','=','clients.id')
            ->where('clients.name','like','%'.$this->search.'%')
            ->sum('total_amount'),

            'total_paid'=>DB::table('users')
            ->where('users.id','=',$this->user_id)
            ->join('sales','users.id','=','sales.added_id')
            ->join('clients','sales.client_id','=','clients.id')
            ->where('clients.name','like','%'.$this->search.'%')
            ->sum('paid'),

            'total_cash'=>DB::table('users')
            ->where('users.id','=',$this->user_id)
            ->join('sales','users.id','=','sales.added_id')
            ->join('clients','sales.client_id','=','clients.id')
            ->where('clients.name','like','%'.$this->search.'%')
            ->sum('cash'),

            'total_transfers'=>DB::table('users')
            ->where('users.id','=',$this->user_id)
            ->join('sales','users.id','=','sales.added_id')
            ->join('clients','sales.client_id','=','clients.id')
            ->where('clients.name','like','%'.$this->search.'%')
            ->sum('transfers'),

            'total_debt'=>DB::table('users')
            ->where('users.id','=',$this->user_id)
            ->join('sales','users.id','=','sales.added_id')
            ->join('clients','sales.client_id','=','clients.id')
            ->where('clients.name','like','%'.$this->search.'%')
            ->sum('debt')
        ]);
    }
}

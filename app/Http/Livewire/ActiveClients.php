<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ActiveClients extends Component
{
    public function render()
    {
        return view('livewire.active-clients',[
            'clients'=>DB::table('sales')
            ->join('clients','clients.id','=','sales.client_id')
            ->selectRaw('sum(sales.total_amount) as total_amount, clients.name as client_name,clients.phone as client_phone')
            ->groupBy('clients.id')
            ->orderBy('total_amount','desc')
            ->paginate(10),

            'summa'=>DB::table('sales')
            ->join('clients','clients.id','=','sales.client_id')
            ->sum('sales.total_amount'),

            'kindergarden'=>DB::table('sales')
            ->join('clients','clients.id','=','sales.client_id')
            ->where('clients.kindergarden','=',1)
            ->selectRaw('sum(sales.total_amount) as total_amount, clients.name as client_name,clients.phone as client_phone')
            ->groupBy('clients.id')
            ->orderBy('total_amount','desc')
            ->paginate(10),
            
            'kindergarden_summa'=>DB::table('sales')
            ->join('clients','clients.id','=','sales.client_id')
            ->where('clients.kindergarden','=',1)
            ->sum('sales.total_amount'),
            ]
        );
    }
}

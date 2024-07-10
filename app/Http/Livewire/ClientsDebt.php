<?php

namespace App\Http\Livewire;

use DB;
use Livewire\Component;

class ClientsDebt extends Component
{
    public $search;
    public $kinder=0;
    public $active1 = 'text-primary';
    public $active2 = '';
    public function main(){
        $this->kinder=0;
        $this->active1 = 'text-primary';
        $this->active2 = '';
    }
    public function kindergarden(){
        $this->kinder=1;
        $this->active1 = '';
        $this->active2 = 'text-primary';
    }
    public function render()
    {
        return view('livewire.clients-debt',[
            'clients'=>DB::table('sales')
            ->join('clients','clients.id','=','sales.client_id')
            ->join('breads','breads.id','=','sales.bread_id')
            ->join('users','users.id','=','sales.added_id')
            ->where('clients.kindergarden','=',$this->kinder)
            ->where('clients.name','like','%'.$this->search.'%')
            ->selectRaw('sum(sales.debt) as sum, clients.name as client_name')
            ->groupBy('clients.id')
            ->paginate(10),
            'total_debts'=>DB::table('sales')
            ->join('clients','clients.id','=','sales.client_id')
            ->where('clients.kindergarden','=',$this->kinder)
            ->where('clients.name','like','%'.$this->search.'%')
            ->sum('sales.debt')
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
class SearchClient extends Component
{
    use WithPagination;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        if(auth()->user()->role_id == 3){
            $clients=Client::where('user_id',auth()->user()->id)->where('clients.name','like','%'.$this->search.'%')
            ->orderBy('id','desc')
            ->latest()->get();
        }else{
            $clients=Client::where('clients.name','like','%'.$this->search.'%')
            ->orderBy('id','desc')
            ->latest()->get();
        }
        return view('livewire.search-client',[
            'clients'=>$clients
        ]);
    }
}

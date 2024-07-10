<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Sale;
use Livewire\Component;

class DebtClientsSearch extends Component
{
    
    public $search_main;
    public $search_kindergarten;
    public function render()
    {
        
        $main_clients = Client::where('name','like','%'.$this->search_kindergarten.'%')->where('kindergarden',0)->orderBy('created_at','desc')->get(); 

        $kindergarten_clients = Client::where('name','like','%'.$this->search_kindergarten.'%')->where('kindergarden',1)->orderBy('created_at','desc')->get();  
        return view('livewire.debt-clients-search',compact('main_clients','kindergarten_clients'));
    }
}

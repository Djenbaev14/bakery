<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Sale;
use Livewire\Component;

class ClientHistories extends Component
{
    public $client;
    public $sale;
    public $payments;
    public $debt;
    public $active1 = 'text-primary';
    public $active2 = '';
    public $ac1 = 'd-block';
    public $ac2 = 'd-none';

    public function main(){
        $this->active1 = 'text-primary';
        $this->active2 = '';

        $this->ac1 = 'd-block';
        $this->ac2 = 'd-none';
    }
    public function kindergarden(){
        $this->active1 = '';
        $this->active2 = 'text-primary';

        $this->ac1 = 'd-none';
        $this->ac2 = 'd-block';
    }
    public function mount(Client $client,$sale,$debt,$payments){
        $this->client=$client;
        $this->sale=$sale;
        $this->payments=$payments;
        $this->debt=$debt;
    }
    public function render()
    {
        return view('livewire.client-histories');
    }
    
}

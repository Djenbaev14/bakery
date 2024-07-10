<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ShowSupplier extends Component
{
    use WithPagination;
    public $payments;
    public $delivery;
    public $active1 = 'text-primary';
    public $active2 = '';
    public $ac1 = 'd-block';
    public $ac2 = 'd-none';

    public function delivery(){
        $this->active1 = 'text-primary';
        $this->active2 = '';

        $this->ac1 = 'd-block';
        $this->ac2 = 'd-none';
    }
    public function payment(){
        $this->active1 = '';
        $this->active2 = 'text-primary';

        $this->ac1 = 'd-none';
        $this->ac2 = 'd-block';
    }

    public function mount($payments,$delivery){
        $this->payments=$payments;
        $this->delivery=$delivery;
    }
    public function render()
    {
        return view('livewire.show-supplier');
    }
}

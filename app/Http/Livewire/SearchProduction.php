<?php

namespace App\Http\Livewire;

use App\Models\Production;
use Livewire\Component;
use Livewire\WithPagination;

class SearchProduction extends Component
{
    use WithPagination;
    public $search;
    public function render()
    {
        
        $production=Production::orderBy('created_at','desc')->where('quantity','like','%'.$this->search.'%')->orWhereHas('user', function ($query) {
            return $query->where('username','like','%'.$this->search.'%');
        })->orWhereHas('bread', function ($query) {
            return $query->where('name','like','%'.$this->search.'%');
        })->get();
        // ->latest()->paginate(50);
        return view('livewire.search-production',['production'=>$production]);
    }
}

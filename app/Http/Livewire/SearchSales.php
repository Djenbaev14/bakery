<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SearchSales extends Component
{
    
    use WithPagination;
    public $search;
    public $sortField = 'created_at'; // Default sort field
    public $sortDirection = 'desc'; // Default sort direction
    public $selectedPage = 10; // Default value

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
        }
    }
    public function render()
    {
        if(auth()->user()->role_id == 3){

            $sales = Sale::where('user_id',auth()->user()->id)->orderBy($this->sortField,$this->sortDirection)
            ->whereHas('client', function ($query) {
                return $query->where('name','like','%'.$this->search.'%');
            })->paginate($this->selectedPage);
            
        }
        else{
            $sales = Sale::orderBy($this->sortField,$this->sortDirection)->whereHas('client', function ($query) {
                return $query->where('name','like','%'.$this->search.'%');
            })->orWhereHas('user', function ($query) {
                return $query->where('username','like','%'.$this->search.'%');
            })->paginate($this->selectedPage);  
            
        }
        
        return view('livewire.search-sales',[
            'sales'=>$sales
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Sales;
use App\Models\Sale;
use App\Models\sale_history;
use Illuminate\Http\Request;

class ExpectedDebtController extends Controller
{
    public function index(){
        // $text = "Вы уверены, что хотите принять эту задачу??";
        // confirmDelete($text);
        return view('admin.pages.debts.expected_debts');
    }

    public function update(Request $request){
        $request->validate([
            'updated_at'=>'required'
        ]);
        $date=date_create($request->updated_at);
        Sale::where('id',$request->id)->update([
            'updated_at'=>date_format($date,'Y-m-d H:i:s')
        ]);
        return redirect()->route('expected.debts.index')->with('success', 'успешно обновлено');
    }

    public function wallet(Request $request){
        for ($i=0; $i < count($request->check); $i++) { 
            sale_history::where('id',$request->check[$i])->update([
                'status'=>1
            ]);
        }

        return redirect()->route('expected.debts.index')->with('success','Успешно');
    }
}

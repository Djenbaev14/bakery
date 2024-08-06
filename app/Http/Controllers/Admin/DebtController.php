<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\sale_his;
use App\Models\sale_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    public function index(Request $request){
        $total_paid=0;
        if(auth()->user()->role_id == 3){
            $main_sales = Sale::where('user_id',auth()->user()->id)->whereHas('user', function ($query) {
                    return $query->where('id','=',auth()->user()->id);
                })->whereHas('client', function ($query) use ($request) {
                    return $query->where('name','like','%'.$request->search.'%');
                })->whereHas('client', function ($query) {
                    return $query->where('kindergarden',0);
                })->orderBy('created_at','desc')->paginate(20);
                
            $kindergarten_sales = Sale::where('user_id',auth()->user()->id)->whereHas('user', function ($query) {
                return $query->where('id','=',auth()->user()->id);
            })->whereHas('client', function ($query) use ($request) {
                return $query->where('name','like','%'.$request->search_kinder.'%');
            })->whereHas('client', function ($query) {
                    return $query->where('kindergarden',1);
            })->orderBy('created_at','desc')->paginate(20);  
        }else{
            $main_sales = Sale::whereHas('client', function ($query) use ($request) {
                return $query->where('name','like','%'.$request->search.'%');
            })->whereHas('client', function ($query) {
                    return $query->where('kindergarden',0);
                })->orderBy('created_at','desc')->paginate(20); 
            
            $kindergarten_sales = Sale::whereHas('client', function ($query) use ($request) {
                return $query->where('name','like','%'.$request->search_kinder.'%');
            })->whereHas('client', function ($query) {
                        return $query->where('kindergarden',1);
                })->orderBy('created_at','desc')->paginate(20);  
        }
            $main_total_paid=0;
            $kindergarten_total_paid=0;

            foreach($main_sales as $sale){
                $main_total_paid=$main_total_paid+$sale->sale_history->sum('paid');
            }
            $main_total_debt=$main_sales->sum(function($t){return $t->quantity*$t->price;})-$main_total_paid;

            foreach($kindergarten_sales as $sale){
                $kindergarten_total_paid=$kindergarten_total_paid+$sale->sale_history->sum('paid');
            }
            $kindergarten_total_debt=$kindergarten_sales->sum(function($t){return $t->quantity*$t->price;})-$kindergarten_total_paid;

        return view('admin.pages.debts.index',compact('total_paid','main_sales','kindergarten_sales','main_total_debt','kindergarten_total_debt','main_total_paid','kindergarten_total_paid'));
    }

    public function update(Request $request){
        $request->validate([
            'transfers'=>'required|numeric|min:0',
            'cash'=>'required|numeric|min:0'
        ]);
        if(intval($request->debt) >= ($request->cash+$request->transfers)){
            if($request->cash!=0){
                sale_history::create([
                    'sale_id'=>$request->sale_id,
                    'client_id'=>Sale::find($request->sale_id)->client_id,
                    'bread_id'=>Sale::find($request->sale_id)->bread_id,
                    'user_id'=>auth()->user()->id,
                    'paid'=>$request->cash,
                    'type'=>'nal'
                ]);
            }
            if($request->transfers!=0){
                sale_history::create([
                    'sale_id'=>$request->sale_id,
                    'client_id'=>Sale::find($request->sale_id)->client_id,
                    'bread_id'=>Sale::find($request->sale_id)->bread_id,
                    'user_id'=>auth()->user()->id,
                    'paid'=>$request->transfers,
                    'type'=>'per',
                    'status'=>1
                ]);
            }
            return redirect()->route('debts.index')->with('success', 'Успешно обновлено');
        }
        

        return redirect()->route('debts.index')->with('error', 'Долг не может быть выплачен сверх суммы');
    }

    public function payment(Request $request){
        $request->validate([
            'total'=>'required|numeric',
            'paid'=>'required|numeric',
            'type'=>'required|not_in:Выберите',
        ]);

        DB::beginTransaction();
        try {
            if(count($request->check)<=1){
                $sale=Sale::find($request->check[0]);
                sale_history::create([
                    'user_id'=>auth()->user()->id,
                    'client_id'=>Sale::find($request->check[0])->client_id,
                    'sale_id'=>$request->check[0],
                    'bread_id'=>Sale::find($request->check[0])->bread_id,
                    'paid'=>$request->paid,
                    'type'=>$request->type,
                    'created_at'=>Sale::find($request->check[0])->created_at
                ]);
            }else{
                for ($i=0; $i < count($request->check); $i++) { 
                    $sale[$i]=Sale::find($request->check[$i]);
                    $debt[$i]=($sale[$i]->price * $sale[$i]->quantity) - sale_history::where('sale_id',$request->check[$i])->sum('paid');
                    sale_history::create([
                        'user_id'=>auth()->user()->id,
                        'client_id'=>Sale::find($request->check[$i])->client_id,
                        'sale_id'=>$request->check[$i],
                        'bread_id'=>Sale::find($request->check[$i])->bread_id,
                        'paid'=>$debt[$i],
                        'type'=>$request->type,
                        'created_at'=>Sale::find($request->check[$i])->created_at
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('debts.index')->with('error', 'Не удалось');
        }
        return redirect()->route('debts.index',)->with('success', 'успешно создана');
    }
}

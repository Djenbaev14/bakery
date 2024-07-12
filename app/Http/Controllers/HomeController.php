<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Coming_product;
use App\Models\payment_history;
use App\Models\Sale;
use App\Models\Sale_items;
use App\Models\Supplier;
use App\Models\Transfers_to_supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function home(){
        $clients=Client::all();
        $debt_kindergarden_clients=Sale::whereHas('client', function($q) {
            $q->where('kindergarden',1);})->sum(DB::raw('quantity * price'))-payment_history::whereHas('client', function($q) {
                $q->where('kindergarden',1);})->sum('paid');
        
        $debt_clients=Sale::whereHas('client', function($q) {
            $q->where('kindergarden',0);})->sum(DB::raw('quantity * price'))-payment_history::whereHas('client', function($q) {
                $q->where('kindergarden',0);})->sum('paid');
        $count=0;            
        foreach ($clients as $client) {
            if($client->sale_history->sum('paid') - $client->sale->sum(function($t){return $t->price * $t->quantity;}) < 0){
                $count+=1;
            }
        }
        $debt_suppliers=Coming_product::where('supplier_id','!=',1)->sum(DB::raw('quantity * price'))-Transfers_to_supplier::where('supplier_id','!=',1)->sum('paid');
        return view('admin.home',compact('clients','debt_kindergarden_clients','debt_clients','count','debt_suppliers'));
    }

    public function changePassword(){
        return view('admin.password');
    }

    public function changePasswordUpdate(Request $request){
        if (!(Hash::check($request->get('current_password'), auth()->user()->password))) {
            return redirect()->back()->with("error","Ваш текущий пароль не совпадает с вашим паролем.");
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            return redirect()->back()->with("error","Новый пароль не может совпадать с вашим текущим паролем.");
        }
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string',
        ]);
        auth()->user()->update([
            'password'=>Hash::make($request->new_password),
        ]);
        
        return redirect()->route('change-password')->with("success","успешно изменен!");
    }
}

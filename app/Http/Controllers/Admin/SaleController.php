<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Sales;
use App\Models\Bread;
use App\Models\Bread_product;
use App\Models\Client;
use App\Models\Coming_product;
use App\Models\Delivery;
use App\Models\payment_history;
use App\Models\Refund_bread;
use App\Models\Return_bread;
use App\Models\Sale;
use App\Models\sale_history;
use App\Models\Sale_items;
use App\Models\User;
use App\Models\User_salary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(){
        $breads=Bread::all();
        if(auth()->user()->role_id == 3){
            $sales = Sale::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->paginate(20);
            $clients=Client::where('user_id',auth()->user()->id)->orderBy('id','desc')->get();
            
        }else{
            foreach ($breads as $bread) {
                $bread->quantity=warehouse_quan($bread->id);
            }

            $sales = Sale::orderBy('created_at','desc')->get();  
            $clients=Client::orderBy('id','desc')->get();
        }

        return view('admin.pages.sales.index',compact('breads','clients','sales'));
    }
    
    public function sale2_index(){
        
        $title = 'Отключение продажи!!';
        $text = "Вы уверены, что хотите удалить?";
        confirmDelete($title, $text);
        $breads=Bread::with(["sale" => function($q){$q->where('user_id', '=', auth()->user()->id);}])->get();
        if(auth()->user()->role_id == 3){
            $sales = Sale::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();
            $clients=Client::where('user_id',auth()->user()->id)->get();
            foreach ($breads as $bread) {
                $bread->quantity=warehouse_quan_delivery($bread->id);
            }
        }else{
            $sales = Sale::orderBy('created_at','desc')->paginate(20);  
            $clients=Client::all(); 
            foreach ($breads as $bread) {
                $bread->quantity=warehouse_quan($bread->id);
            }
        }
        $start_date=date('Y-m-d');
        return view('admin.pages.sales2.index',compact('breads','clients','sales','start_date'));
    }
    

    public function store(Request $request){
        $request->validate([
            'client_id'=>'required|string',
            'bread_id'=>'required',
            'quantity'=>'min:0',
            'total_price'=>'required|numeric',
        ]);
        $client_id=json_decode($request->client_id)->id;
            
                $sale=Sale::create([
                    'user_id'=>auth()->user()->id,
                    'client_id'=>$client_id,
                    'bread_id'=>$request->bread_id,
                    'quantity'=>$request->quantity,
                    'price'=>$request->price,
                    'delivery_kpi'=>User::find(auth()->user()->id)->KPI,
                    // 'created_at'=>$request->created_at." ".date("H:i:s")
                ]);
                if($request->cash>0){
                    sale_history::create([
                        'user_id'=>auth()->user()->id,
                        'sale_id'=>$sale->id,
                        'client_id'=>$client_id,
                        'bread_id'=>$request->bread_id,
                        'paid'=>$request->cash,
                        'type'=>'nal',
                        // 'created_at'=>$request->created_at." ".date("H:i:s")
                    ]);
                }
                if($request->transfers>0){
                    sale_history::create([
                        'user_id'=>auth()->user()->id,
                        'sale_id'=>$sale->id,
                        'client_id'=>$client_id,
                        'bread_id'=>$request->bread_id,
                        'paid'=>$request->transfers,
                        'type'=>'per',
                        'status'=>'0',
                        // 'created_at'=>$request->created_at." ".date("H:i:s")
                    ]);
                }
                // if(client_balance($client_id)>0){
                //         sale_history::create([
                //             'sale_id'=>$sale->id,
                //             'client_id'=>$request->client_id,
                //             'paid'=>$request->total_price >= client_balance($client_id) ? client_balance($client_id) : $request->total_price,
                //             'type'=>'nal',
                //             'created_at'=>$request->created_at." ".date("H:i:s")
                //         ]);
                // }
    
    
                // if(auth()->user()->role_id == 3){
                //     User_salary::create([
                //         'user_id'=>auth()->user()->id,
                //         'sale_id'=>$sale->id,
                //         'summa'=>$request->total_price*(User::find(auth()->user()->id)->KPI)/100,
                //         'created_at'=>$request->created_at." ".date("H:i:s")
                //     ]);
                // }
        
        
        return redirect()->route('sales2.index')->with('success', 'Успешно создана');
        

        
        

        
    }

    public function destroy(Request $request,$id){
        if(auth()->user()->role_id==1 || (auth()->user()->role_id==2 && Sale::find($id)->where('created_at' ,'>=', now()->subMinutes(10))->exists())){
            Sale::destroy($id);
            return redirect()->route('sales2.index')->with('success', 'Успешно удалено');
        }else{
            return redirect()->route('sales2.index')->with('error', 'Не удалось');
        }
        
        
        
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bread;
use App\Models\Client;
use App\Models\payment_history;
use App\Models\Sale;
use App\Models\sale_history;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(){
        $clients=Client::orderBy('id','desc')->get();
        return view('admin.pages.clients.index',compact('clients'));
    }
    public function show(Request $request,Client $client){
        $start_date =$request->start_date ? $request->start_date : date('Y-m-01');
        $end_date =$request->end_date ? $request->end_date : date('Y-m-d');

        $breads=Bread::with(['sale' => function($q) use ($start_date,$end_date) { 
                $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); }])
                        ->with('sale', function($q) use ($client) {
                            $q->where('client_id',$client->id);})
                        ->with(['sale_history' => function($q) use ($start_date,$end_date) { 
                $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); }])
                        ->with('sale_history', function($q) use ($client) {
                $q->where('client_id',$client->id);})
                ->get();
        // $delivery=Coming_product::where('supplier_id',$supplier->id)->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();
        return view('admin.pages.clients.show',compact('client','breads','start_date','end_date'));
    }

    public function histories(Client $client,Request $request){
        $start_date =$request->start_date ? $request->start_date : date('Y-m-d');
        $end_date =$request->end_date ? $request->end_date : date('Y-m-d');
        $client_sale=Sale::where('client_id',$client->id)->get();
        


        if(auth()->user()->role_id == 3){
            $sale=Sale::with('sale_history')->whereHas('client', function($q) use ($client) {
                $q->where('client_id',$client->id);})
                ->whereHas('user', function($q) {
                    $q->where('user_id',auth()->user()->id);})
                ->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])
                ->orderBy('created_at','desc')->get();
            
            $payments=payment_history::where('client_id',$client->id)
            ->whereHas('user', function($q) {
            $q->where('user_id',auth()->user()->id);})
            ->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])
            ->orderBy('created_at','desc')->get();
        }else{
            $sale=Sale::with('sale_item')->with('sale_history')->whereHas('client', function($q) use ($client) {
                $q->where('client_id',$client->id);})
                ->whereBetween(DB::raw('date(created_at)'), 
                [$start_date,
                 $end_date])
                ->orderBy('created_at','desc')->get();
            
            $payments=payment_history::where('client_id',$client->id)
            ->whereBetween(DB::raw('date(created_at)'), 
            [$start_date,
             $end_date])
            ->orderBy('created_at','desc')->get();
        }
        $total=0;
        foreach ($sale as $s) {
            $total+=$s->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $s->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;});
        }
        $total_paid=0;
        foreach ($sale as $s) {
            $total_paid+=$s->sale_history->sum('paid');
        }
        $debt=$total-$total_paid;


        return view('admin.pages.clients.histories',compact('sale','debt','payments','client','start_date','end_date'));
    }
    public function clientBreads(Request $request){
        $date =$request->date ? $request->date : date('Y-m-d');
        $breads=Bread::get();
        $clients=Client::with(["sale" => function($q) use($date){
            $q->whereDate('created_at', $date);}])->get();
        // return Sale::whereDate('created_at',$date)->get();
        // return $clients;
        return view('admin.pages.clients.breads',compact('date','clients','breads'));
    }
    public function clientBreadsShow(Request $request,Client $client){
        $start_date =$request->start_date ? $request->start_date : date('Y-m-01');
        $end_date =$request->end_date ? $request->end_date : date('Y-m-30');
        
        $begin = new DateTime($start_date);
        $end = new DateTime($end_date);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $breads=Bread::get();
        return view('admin.pages.clients.breads-show',compact('client','start_date','end_date','period','breads'));
    }
    public function pay_client_filter(Client $client,Request $request){
        return $request->all();
    }

    public function pay_client(Request $request){
        $request->validate([
            'total'=>'required|numeric',
            'debt'=>'required|numeric',
            'type'=>'required|not_in:Выберите',
        ]);
        DB::beginTransaction();
        try{
            $payment_history=payment_history::create([
                'client_id'=>$request->client_id,
                'user_id'=>auth()->user()->id,
                'paid'=>$request->total-$request->debt,
                'type'=>$request->type,
                'created_at'=>$request->created_at." ".date("H:i:s")
            ]);
            if($request->type == 'per'){
                $payment_history->update([
                    'status'=>1
                ]);
            }
            if(count($request->check)<=1){
                $sale=Sale::find($request->check[0]);
                // $paid=sale_history::where('sale_id',$request->check[0])->sum('paid');
                $debt=$sale->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $sale->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;})-sale_history::where('sale_id',$request->check[0])->sum('paid');
                if($request->debt==0){
                    sale_history::create([
                        'sale_id'=>$request->check[0],
                        'client_id'=>$request->client_id,
                        'user_id'=>auth()->user()->id,
                        'paid'=>$debt,
                        'type'=>$request->type,
                        'created_at'=>$request->created_at." ".date("H:i:s")
                    ]);
                }else{
                    sale_history::create([
                        'sale_id'=>$request->check[0],
                        'client_id'=>$request->client_id,
                        'user_id'=>auth()->user()->id,
                        'paid'=>$debt-$request->debt,
                        'type'=>$request->type,
                        'created_at'=>$request->created_at." ".date("H:i:s")
                    ]);
                }
            }else{
                for ($i=0; $i < count($request->check); $i++) { 
                    $sale[$i]=Sale::find($request->check[$i]);
                    $debt[$i]=$sale[$i]->sale_item->sum(function($t){return $t->price * $t->quantity;}) - $sale[$i]->return_bread->sum(function($t){return $t->sale_item->price * $t->quantity;})-sale_history::where('sale_id',$request->check[$i])->sum('paid');
                    sale_history::create([
                        'sale_id'=>$request->check[$i],
                        'client_id'=>$request->client_id,
                        'user_id'=>auth()->user()->id,
                        'paid'=>$debt[$i],
                        'type'=>$request->type,
                        'created_at'=>$request->created_at." ".date("H:i:s")
                    ]);
                }
            }
            
            DB::commit();
        }catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('client_histories',$request->client_id)->with('error', 'Не удалось');
        }
        return redirect()->route('client_histories',$request->client_id)->with('success', 'успешно создана');
        
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'phone'=>'required|unique:users,phone,'.$request->phone,
        ]);
        if(request()->has('kindergarden')){
            Client::create([
                'user_id'=>auth()->user()->id,
                'name'=>$request->name,
                'phone'=>$request->phone,
                'comment'=>$request->comment,
                'kindergarden'=>1
            ]);
        }else{
            Client::create([
                'user_id'=>auth()->user()->id,
                'name'=>$request->name,
                'phone'=>$request->phone,
                'comment'=>$request->comment,
            ]);
        }
        return redirect()->route('clients.index')->with('success', 'успешно создана');
    }
    public function destroy(Request $request,$id){
        Client::destroy($id);
        return redirect()->route('clients.index')->with('success', 'Успешно удалена');
    }

    public function update(Request $request){
        // return $request->all();
        $request->validate([
        'name'=>'required',
        'phone'=>'required|unique:users,phone,'.$request->phone,
        ]);
    if(request()->has('kindergarden')){
        Client::where('id',$request->id)->update([
            'user_id'=>auth()->user()->id,
            'name'=>$request->name,
            'phone'=>$request->phone,
            'comment'=>$request->comment,
            'kindergarden'=>1
        ]);
    }else{
        Client::where('id',$request->id)->update([
            'user_id'=>auth()->user()->id,
            'name'=>$request->name,
            'phone'=>$request->phone,
            'comment'=>$request->comment,
            'kindergarden'=>0
        ]);
    }
    return redirect()->route('clients.index')->with('success', 'успешно обновлено');
    }

    // public function return_bread(Request $request){
    //     $request->validate([
    //         'sale_item_id'=>'array',
    //         'quantity'=>'array',
    //     ]);
    //     try {
    //         $total=0;
    //         for ($i=0; $i < count($request->sale_item_id); $i++) { 
    //             $total+=$request->quantity[$i]*Sale_items::find($request->sale_item_id[$i])->price;
    //             if($request->quantity[$i]>0){
    //                 Return_bread::create([
    //                     'user_id'=>auth()->user()->id,
    //                     'client_id'=>$request->client_id,
    //                     'sale_id'=>$request->sale_id,
    //                     'sale_item_id'=>$request->sale_item_id[$i],
    //                     'price'=>Sale_items::find($request->sale_item_id[$i])->price,
    //                     'quantity'=>$request->quantity[$i]
    //                 ]);
    //             }
    //         }
    //         // Sale::where('id',$request->sale_id)->update([
    //         //     'total'=>DB::raw('total-'.$total)
    //         // ]);
    //         User_salary::where('sale_id',$request->sale_id)->update([
    //             'summa'=>DB::raw('summa-'.$total*auth()->user()->KPI/100),
    //         ]);
    //         DB::commit();
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return redirect()->route('client_histories',$request->client_id)->with('error', 'Не удалось');
    //     }
    //     return redirect()->route('client_histories',$request->client_id)->with('success', 'успешно создана');
    // }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TransfersToSupplierController;
use App\Models\Bread;
use App\Models\Client;
use App\Models\Coming_product;
use App\Models\Expenditure;
use App\Models\Expenditure_product;
use App\Models\Expenditure_Salary;
use App\Models\payment_history;
use App\Models\Product;
use App\Models\Production;
use App\Models\Return_bread;
use App\Models\Sale;
use App\Models\sale_history;
use App\Models\Transfers_to_supplier;
use App\Models\User;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function reportActive(Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-01');
        $end_date = $request->end_date ? $request->end_date :  date('Y-m-d');
        
        // $clients=Client::with(['sale' => function($q) use ($start_date,$end_date) { 
        //     $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        // }])->orderBy('id','desc')->get();
        $clients = Client::with(['sale' => function($query) {
            $query->orderByRaw('quantity * price');
        }])
        // ->orderByRaw('sale.price * sale.quantity')
        ->get();
        // return $clients;
        $kindergardens=Client::where('kindergarden','=',1)->with(['sale' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->orderBy('id','desc')->get();
        // $clients_total=Sale::whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date])->sum(DB::raw('quantity*price'));
        // $kindergardens_total=Sale::with(['client' => function($q) { 
        //     $q->where('kindergarden', '=', 1); 
        // }])->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date])->get();
        return view('admin.pages.report.active-clients',compact('start_date','end_date','clients','kindergardens'));
    }

    public function reportAdmin(){
        $admins=User::where('role_id','=','2')->get();
        $productions=Production::all();
        return view('admin.pages.report.admin-sale.admin-sale',compact('admins','productions'));
    }
    public function historyAdmin(User $user, Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-01');
        $end_date = $request->end_date ? $request->end_date :  date('Y-m-d');
        $sales=Sale::where('user_id',$user->id)->whereBetween(DB::raw('date(created_at)'), [$start_date, $end_date])->orderBy('id','desc')->paginate(10);
        $sale_histories=sale_history::where('user_id',$user->id)->whereBetween(DB::raw('date(created_at)'), [$start_date, $end_date])->get();
        return view('admin.pages.report.admin-sale.history-admin',compact('user','sales','sale_histories','start_date', 'end_date'));
    }
    public function ha(User $user, Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-01');
        $end_date = $request->end_date ? $request->end_date :  date('Y-m-d');
        $user=User::where('id',$user->id)->with(['expenditure' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->with(['sale' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->first();
        $payment_history = payment_history::orderBy('id', 'desc')
        ->where('type','nal')
        ->where('user_id',$user->id)
        ->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])
        ->paginate(30); 
        $sale_histories=sale_history::with(["sale" => function($q) use($user){
            $q->where('user_id', '=', $user->id);
        }])->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();


        return view('admin.pages.report.admin-sale.ha',compact('payment_history','user','start_date', 'end_date','sale_histories'));
    }
    public function reportBenifit(Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-01');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');

        $production_count=Production::whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->sum('quantity');
        $sale_coming=Sale::whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->sum(DB::raw('quantity * price'));
        $expenditure=Expenditure::whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->sum('price')+Expenditure_product::whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->sum(DB::raw('quantity * price'));

        
        $expenditure_suppliers=Transfers_to_supplier::whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->sum('paid');
        $expenditure_users=Expenditure::whereHas('expenditure_type',function($q) {
            return $q->where('deduction_from_wages','=','0');
        })->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->sum('price');
        $expenditure_salaries=Expenditure::whereHas('expenditure_type',function($q) {
            return $q->where('deduction_from_wages','=','1');
        })->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->sum('price');
        return view('admin.pages.report.benifit.index',compact('start_date','end_date','production_count','sale_coming','expenditure','expenditure_suppliers','expenditure_users','expenditure_salaries'));
    }
    
    public function reportDelivery(Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-01');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');
        $users=User::where('role_id',3)->with(['sale' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->get();
        
        return view('admin.pages.report.delivery.index',compact('users','start_date','end_date'));
    }
    public function reportGroup(Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-01');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');
        $users=User::where('role_id',4)->with(['production' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->get();
        return view('admin.pages.report.group.index',compact('users','start_date','end_date'));
    }
    public function reportBalance(){
        $users=User::orderBy('id','desc')->get();
        return view('admin.pages.report.balance.index',compact('users'));
    }

    public function reportBalanceShow(User $user){
        $expenditure_salaries=Expenditure_Salary::where('user_id',$user->id)->paginate(10);
        if($user->role_id==3){
          $coming=Sale::where('user_id',$user->id)->orderBy('id','desc')->paginate(10);
        }else if($user->role_id == 2){
          $coming=Production::orderBy('id','desc')->paginate(10);
        }else if($user->role_id == 4){
          $coming=Production::where('responsible_id',$user->id)->orderBy('id','desc')->paginate(10);
        }
        return view('admin.pages.report.balance.show',compact('user','expenditure_salaries','coming'));
    }

    public function reportSale(Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-01');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');
        
        $sale_histories=sale_history::whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date])->get();
        $sales=Sale::whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date])->get();
        $clients=Client::with('sale_history',function($query) use ($start_date,$end_date){
            return $query->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]);
        })->get();

        $deliveries=User::where('role_id',3)->with('sale_history',function($query) use ($start_date,$end_date){
            return $query->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]);
        })->with('sale',function($query) use ($start_date,$end_date){
            return $query->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]);
        })->with('expenditure',function($query) use ($start_date,$end_date){
            return $query->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]);
        })->with('expenditure_salary',function($query) use ($start_date,$end_date){
            return $query->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]);
        })->get();
        return view('admin.pages.report.sale.index',compact('start_date','end_date','sale_histories','sales','deliveries','clients'));
    }
    public function reportSaleShow( Sale $sale){
        $expenditure=Expenditure::where('user_id',$sale->user_id)
        ->whereDate('created_at', $sale->created_at->format('Y-m-d'))
        ->get();
        return view('admin.pages.report.sale.show',compact('sale','expenditure'));
    }

    public function reportProduction(){
        $breads= DB::table('sales')
        ->join('breads','sales.bread_id','=','breads.id')
        ->selectRaw('sum(breads.produced) as total_quantity,sum(breads.price*breads.produced) as total_amount, breads.name as bread_name,breads.updated_at as updated_at')
        ->groupBy('bread_id')
        ->paginate(30);
        $total_amount=DB::table('sales')
        ->selectRaw('sum(sales.total_amount) as total_amount')
        ->get();
        return view('admin.pages.report.production',compact('breads','total_amount'));
    }

    public function reportWarehouse(Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');

        $products=Product::with(['coming_product' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->with(['expenditure_product' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->orderBy('id','desc')->paginate(30);
        $coming_total=0;
        $expenditure_total=0;
        foreach ($products as $product) {
            foreach ($product->coming_product as $c_pro) {
                $coming_total+=$product->price*$c_pro->quantity;
            }
            foreach ($product->expenditure_product as $c_pro) {
                $expenditure_total+=$product->price*$c_pro->quantity;
            }
        }
        return view('admin.pages.report.warehouse',compact('products','start_date','end_date','coming_total','expenditure_total'));
    }
    
    public function reportSale2(Request $request){
        $date=$request->date ? $request->date : date('Y-m-d');
        $breads=Bread::all();
        $productions=Production::whereDate('created_at', $date)->get();
        $users=User::where('role_id','!=',1)->get();
        $sales=Sale::whereDate('created_at', $date)->get();
        $sale_items=Sale::whereDate('created_at', $date)->get();
        $sale_histories=sale_history::whereDate('created_at', $date)->get();
        $expendituries=Expenditure::whereDate('created_at', $date)->get();
        return view('admin.pages.report.sale2.index',compact('breads','users','productions','sales','sale_items','sale_histories','expendituries','date'));
    }

    public function reportWareFilter(Request $request){
        $request->validate([
            'date_from'=>'required',
            'date_to'=>'required'
        ]);
        $products=DB::table('history_warehouse')
        ->join('products','history_warehouse.product_id','=','products.id')
        ->whereDate('history_warehouse.created_at','<=',$request->date_to)
        ->whereDate('history_warehouse.created_at','>=',$request->date_from)
        ->selectRaw('sum(history_warehouse.new_expenditure) as expenditure,sum(history_warehouse.new_coming) as coming,products.id as product_id,products.price as price,products.name as name')
        ->groupBy('product_id')
        ->paginate(30);
        $total_coming=Product::select(DB::raw('sum(price * coming) as total'))
        ->when(
            $request->date_from && $request->date_to,
            function (Builder $builder) use ($request) {
                $builder->whereBetween(
                    DB::raw('DATE(products.updated_at)'),
                    [
                        $request->date_from,
                        $request->date_to
                    ]
                );
            }
        )->get();
        
        $total=DB::table('history_warehouse')
        ->join('products','history_warehouse.product_id','=','products.id')
        ->whereDate('history_warehouse.created_at','<=',$request->date_to)
        ->whereDate('history_warehouse.created_at','>=',$request->date_from)
        ->select(DB::raw('sum(price * new_expenditure) as total_expenditure,sum(price * new_coming) as total_coming'))->get();
        $date_from=$request->date_from;
        $date_to=$request->date_to;

        return view('admin.pages.report.warehouse',compact('products','total','date_from','date_to'));
    }

    public function historyClient(Sale $sale){
        $sale_histories=sale_history::orderBy('id','desc')
        ->where('sale_id',$sale->id)
        ->get();
        // $transfers = sale_history::where('sale_id',$id)->where('type','per')->sum('paid');
        // $cash = sale_history::where('sale_id',$id)->where('type','nal')->where('status','=',1)->sum('paid');
        return view('admin.pages.report.admin-sale.history-client',compact('sale_histories'));
    }
    public function reportSaleBack(){ 
        return redirect()->back()->withInput();
    }

    public function reportMoney(Request $request){

        // $startDate=Sale_items::first()->created_at;
        // $endDate=Sale_items::orderBy('id','desc')->first()->created_at;


        // $sale_histories=Sale_items::whereBetween('created_at', [$startDate, $endDate])->selectRaw('SUM(quantity*price) as paid, MONTH(created_at) as month, YEAR(created_at) as year')->groupBy('month', 'year')->orderBy('month', 'asc')->get();

        // $payment_histories = payment_history::whereBetween(DB::raw('date(created_at)'), [$startDate, $endDate])->selectRaw('SUM(paid) as paid, MONTH(created_at) as month, YEAR(created_at) as year')->groupBy('month', 'year')->orderBy('month', 'asc')->get();

        // $expenditures=Expenditure::whereBetween(DB::raw('date(created_at)'), [$startDate, $endDate])->selectRaw('SUM(price) as expenditure, MONTH(created_at) as month, YEAR(created_at) as year')->groupBy('month', 'year')->orderBy('month', 'asc')->get();
        
        $year=$request->year ? $request->year : date('Y');

        return view('admin.pages.report.report-money',compact('year'));
    }

    public function reportWarehouse2(Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');

        $breads=Product::with(['coming_product' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->with(['expenditure_product' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->orderBy('id','desc')->paginate(30);

        $coming_breads=Bread::with(['production' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->get();
        $expenditure_breads=Bread::with(['sale' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->get();

        return view('admin.pages.report.warehouse2',compact('start_date','end_date','coming_breads','expenditure_breads'));
    }
}

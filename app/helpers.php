<?php 
use App\Models\Bread;
use App\Models\Client;
use App\Models\Coming_product;
use App\Models\Delivery;
use App\Models\Expenditure;
use App\Models\Expenditure_product;
use App\Models\Expenditure_Salary;
use App\Models\ExpenditureType;
use App\Models\payment_history;
use App\Models\Product;
use App\Models\Production;
use App\Models\Refund_bread;
use App\Models\Return_bread;
use App\Models\Sale;
use App\Models\sale_history;
use App\Models\User_salary;

// function SaleHistories($year,$month)
// {
//   $sale_items=Sale_items::whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->sum(DB::raw("quantity * price"));
//   $return_breads=Return_bread::whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->sum(DB::raw("quantity * price"));
//   return $sale_items-$return_breads;
// }

  function Paid($year,$month){
    $paid=sale_history::where('type','!=','nal')->whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->sum("paid");
    return $paid;
  } 

  function cashPaid($year,$month){
    $paid=sale_history::where('type','=','nal1')->whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->sum("paid");
    return $paid;
    // $paid=payment_history::where('type','nal')->whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->sum("paid");
  }
  function transfersPaid($year,$month){
    $paid=sale_history::where('type','=','per')->whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->sum("paid");
    return $paid;
    // $paid=payment_history::where('type','per')->whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->sum("paid");
  }

  function noConfir($year,$month){
    $paid=sale_history::where('type','=','nal')->whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->sum("paid");
    return $paid;
  }

  function expenditure_name(){
    return ExpenditureType::all();
  }
  function totalExpenditures($year,$month){
    $expenditure=Expenditure::whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->sum("price");
    return $expenditure;
  }
  function Expenditure($year,$month,$id){
    $expenditure=Expenditure::where('expenditure_type_id',$id)->whereRaw('YEAR(created_at) = '.$year)->whereRaw('MONTH(created_at) = '.$month)->sum("price");
    return $expenditure;
  }
  function expenditure_salary($user){
    $expenditures=Expenditure_Salary::where('user_id',$user->id)->get();
    $expenditure_summa=0;
    foreach ($expenditures as $expenditure) {
      $expenditure_summa+=$expenditure->expenditure->price;
    }
    return $expenditure_summa;
  }
  
  function user_balance($user){
    if($user->role_id==3){
      return Sale::where('user_id',$user->id)->sum(DB::raw('quantity * delivery_kpi')) - expenditure_salary($user);
    }else if($user->role_id == 2){
      return Production::sum(DB::raw('quantity * seller_kpi')) - expenditure_salary($user);
    }else if($user->role_id == 4){
      return Production::where('responsible_id',$user->id)->sum(DB::raw('quantity * worker_kpi')) - expenditure_salary($user);
    }
  }

  function client_balance($id){
    return Client::where('id',$id)->first()->sale_history->sum('paid') - Client::where('id',$id)->first()->sale->sum(function($t){return $t->price * $t->quantity;}) ;
  }

  function product_quan($product_id){
    return Coming_product::where('product_id',$product_id)->sum('quantity')-Expenditure_product::where('product_id',$product_id)->sum('quantity');
  }
  function warehouse_quan($id){
     return Production::where('bread_id',$id)->sum('quantity')+Refund_bread::where('bread_id',$id)->where('status',1)->sum('quantity')-Delivery::where('bread_id',$id)->sum('quantity')-Sale::where('bread_id','=',$id)->whereHas('user', function($q) {
      $q->where('role_id','!=',3);})->sum('quantity');
  }
  function warehouse_quan_delivery($id){
    return Delivery::where("bread_id",$id)->where('truck_id',auth()->user()->id)->sum('quantity') - Sale::where("bread_id",$id)->where('user_id',auth()->user()->id)->sum('quantity') -Refund_bread::where("bread_id",$id)->where('user_id',auth()->user()->id)->sum('quantity');
  }
  function warehouse_quan_truck($truck_id,$id){
    return Delivery::where("bread_id",$id)->where('truck_id',$truck_id)->sum('quantity') - Sale::where("bread_id",$id)->where('user_id',$truck_id)->sum('quantity') -Refund_bread::where("bread_id",$id)->where('user_id',$truck_id)->sum('quantity');
  }

  

  function totalSales($sales){
    $total = 0 ;
    foreach ($sales as $sale) {
      $total+=$sale->sum(DB::raw('quantity * price'));
    }

    return $total;
  }

  function one_paid($sale){
    return $sale->quantity*$sale->price -$sale->sale_history->sum('paid');
  }

  function approvedSales($sales){
    $total=0;
    foreach ($sales as $sale) {
      $total+=$sale->sale_history->where('type','!=','nal')->sum('paid');
    }

    return $total;
  }
  
  function noConfirmedSales($sales){
    $total=0;
    foreach ($sales as $sale) {
      $total+=$sale->sale_history->where('type','=','nal')->sum('paid');
    }

    return $total;
  }

  function return_bread($items){
    $total=0;
    foreach ($items as $item) {
      $total+=$item->return_bread->sum('quantity');
    }
    return $total;
  }

  // function returnBreadSum($sale_items){
  //   $total=0;
  //   foreach ($sale_items as $item) {
  //     $total+=$item->return_bread->sum('quantity')*$item->price;
  //   }
  //   return $total;

  // }
?>
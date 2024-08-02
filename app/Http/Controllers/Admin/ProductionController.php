<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bread;
use App\Models\Bread_product;
use App\Models\Control;
use App\Models\Expenditure;
use App\Models\Expenditure_product;
use App\Models\Expenditure_production;
use App\Models\Product;
use App\Models\Production;
use App\Models\User;
use App\Models\User_salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    public function index(){
        
        $breads=Bread::all();
        $workers=DB::table('users')
        ->join('roles','users.role_id','=','roles.id')
        ->where('roles.name','=','WORKER')
        ->select('users.id','users.username as name')
        ->get();
        $production=Production::orderBy('created_at','desc')->get();
        // return $production;
        return view('admin.pages.production.index',compact('breads','workers','production'));
    }

    public function store(Request $request){
        $request->validate([
            'bread_id'=>'required',
            'quantity'=>'required',
            'user_id'=>'array|required'
        ]);
        
        
        if(in_array(auth()->user()->id,$request->user_id) || auth()->user()->role_id==1 || auth()->user()->role_id==2){
            if((Control::whereNull('end_date')->where('first_id',$request->user_id[0])->exists() || Control::whereNull('end_date')->where('second_id',$request->user_id[0])->exists()) &&
            (Control::whereNull('end_date')->where('first_id',$request->user_id[1])->exists() || Control::whereNull('end_date')->where('second_id',$request->user_id[1])->exists())
            ){
                DB::beginTransaction();
                try {
                
                        $bread_products=Bread_product::where('bread_id',$request->bread_id)->get();
    
                        $cost_price=0;
                        for ($k=0; $k < count($bread_products); $k++) { 
    
                            $price[$k]=Product::find($bread_products[$k]->product_id)->price;
                            $cost_price+=$bread_products[$k]->quantity/$bread_products[$k]->milky_quan*$price[$k];
                        }
                        // productionga qosiw
                        for ($i=0; $i < count($request->user_id); $i++) { 
                            $production[$i]=Production::create([
                                'user_id'=>auth()->user()->id,
                                'responsible_id'=>$request->user_id[$i],
                                'bread_id'=>$request->bread_id,
                                'quantity'=>($request->quantity)/2,
                                'cost_price'=>$cost_price,
                                'worker_kpi'=>User::find($request->user_id[$i])->KPI,
                                'seller_kpi'=>User::where('role_id',2)->first()->KPI
                            ]);
    
                            // usi nanga ketetin produktilerden skladtan aliw
                        
                        for($j=0; $j < count($bread_products); $j++) { 
    
                            $expenditure_product[$j]=Expenditure_product::create([
                                'user_id'=>auth()->user()->id,
                                'product_id'=>$bread_products[$j]->product_id,
                                'price'=>Product::find($bread_products[$j]->product_id)->price,
                                'quantity'=>($bread_products[$j]->quantity/$bread_products[$j]->milky_quan)*($request->quantity/2),
                            ]);
                            Expenditure_production::create([
                                'production_id'=>$production[$i]->id,
                                'expenditure_product_id'=>$expenditure_product[$j]->id,
                            ]);
                        }
                        }
                    DB::commit();
                    
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return redirect()->route('productions.index')->with('error','Не удалось');
                }
        
        
                return redirect()->route('productions.index')->with('success', 'Успешно создана');
            }else{
                return redirect()->route('productions.index')->with('error','Этим людям не разрешено');
            }
        }else{
            return redirect()->route('productions.index')->with('error','Этим людям не разрешено');
        }
                


    }

    public function changeQuan(Request $request ,Production $production){
        $request->validate([
            'quantity'=>'required|min:1|max:'.$production->quantity
        ]);

        if(auth()->user()->role_id==1 || (auth()->user()->role_id==2 && Production::find($production->id)->where('created_at' ,'>=', now()->subMinutes(10))->exists()) || (auth()->user()->role_id==4 && Production::find($production->id)->where('user_id' ,'=', auth()->user()->id)->exists() && Production::find($production->id)->where('created_at' ,'>=', now()->subMinutes(10))->exists())){
        
            DB::beginTransaction();
            try {
                    Production::where('id',$production->id)->update([
                        'quantity'=>DB::raw('quantity-'.$request->quantity)
                    ]);


                    $expenditure_production=Expenditure_production::where('production_id',$production->id)->get();

                    $bread_product=Bread_product::where('bread_id',$production->bread_id)->get();
                    for ($i=0; $i < count($expenditure_production); $i++) { 
                        Expenditure_product::where('id',$expenditure_production[$i]->expenditure_product_id)->update([
                            'quantity'=>DB::raw('quantity-'.($bread_product[$i]->quantity/$bread_product[$i]->milky_quan)*$request->quantity)
                        ]);
                    }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->route('productions.index')->with('error','Не удалось');
            }
                
                return redirect()->route('productions.index')->with('success', 'Успешно удалена');
        }else{
            return redirect()->route('productions.index')->with('error','Не удалось');
        }
    }

    
    public function destroy(Request $request,$id){

        if(auth()->user()->role_id==1 || (auth()->user()->role_id==2 && Production::find($id)->where('created_at' ,'>=', now()->subMinutes(10))->exists()) || (auth()->user()->role_id==4 && Production::find($id)->where('user_id' ,'=', auth()->user()->id)->exists() && Production::find($id)->where('created_at' ,'>=', now()->subMinutes(10))->exists())){
            DB::beginTransaction();

            try {
                $production=Production::find($id);
                        $expenditure_production=Expenditure_production::where('production_id',$id)->get();
                        for ($i=0; $i < count($expenditure_production); $i++) { 
                            Expenditure_product::destroy($expenditure_production[$i]->expenditure_product_id);
                        }
                        Production::destroy($id);
                
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->route('productions.index')->with('error', 'Не удалось');
            }
        }else{
            return redirect()->route('productions.index')->with('error', 'Не удалось');
        }
        
        
        return redirect()->route('productions.index')->with('success', 'Успешно удалена');

    }
}

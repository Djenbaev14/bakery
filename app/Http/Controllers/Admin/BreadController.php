<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bread;
use App\Models\Bread_product;
use App\Models\Client;
use App\Models\Product;
use App\Models\Production;
use App\Models\Sale;
use App\Models\Sale_items;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class BreadController extends Controller
{
    public function index(){
        $breadss=Bread::orderBy('id','desc')->paginate(50);
        $products=Product::all();
        $breads=Bread::with('bread_product')->orderBy('id','desc')->paginate(50);
        return view('admin.pages.warehouse.breads',compact('breads','products','breadss'));
    }
    
    public function store(Request $request){
        $request->validate([
            'name'=>'required|unique:breads,name,'.$request->name,
            'price'=>'required|numeric|min:0',
            'kindergarden_price'=>'required|numeric|min:0',
            'user_price.*'=>'required|numeric|min:0',
            'user_kindergarden_price.*'=>'required|numeric|min:0',
            'litr' => 'required|array',
            'litr.*'=>'required|numeric|min:0',
            'quantity' => 'required|array',
            'quantity.*'=>'required|numeric|min:0'
        ]);
        DB::beginTransaction();
        try {
            
            $count=count($request->product_id);
            $cost_price=0;
            for ($i=0; $i < $count; $i++) { 
                $price=Product::find($request->product_id[$i])->price;
                $cost_price+=$request->quantity[$i]/$request->litr[$i]*$price;
            }

            $bread=Bread::create([
                'name'=>$request->name,
                'price'=>$request->price,
                'kindergarden_price'=>$request->kindergarden_price,
                'cost_price'=>$cost_price,
            ]);


            for ($j=0; $j < $count; $j++) { 
                
                Bread_product::create([
                    'bread_id'=>$bread->id,
                    'product_id'=>$request->product_id[$j],
                    'quantity'=>$request->quantity[$j],
                    'milky_quan'=>$request->litr[$j]
                ]);

            }
            
            DB::commit();
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('breads.index')->with('error', 'Не удалось');
        }
        
        return redirect()->route('breads.index')->with('success', 'Успешно создана');
    }
    public function destroy(Request $request,$id){
        Bread_product::where('bread_id',$id)->delete();
        Bread::destroy($id);
        return redirect()->route('breads.index')->with('success', 'Успешно удалена');
    }
    public function update(Request $request){

        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric|min:0',
            'kindergarden_price'=>'required|numeric|min:0',
            'quantity' => 'required|array',
            'quantity.*'=>'required|numeric|min:0',
            'litr' => 'required|array',
            'litr.*'=>'required|numeric|min:0',
            // 'product_id.*'=>'required|unique:breads,name,'.$request->name,
        ]);

        try {

            $count=count($request->product_id);
            $products_id=Bread_product::where('bread_id',$request->id)->pluck('product_id')->all();
        // $cost_price=0;

        // aldin quraminda bolgan produkti qosilmasa bazadan oshiriledi
        for ($i=0; $i < count($products_id); $i++) { 
            if(!in_array($products_id[$i],$request->product_id)){
                Bread_product::where('bread_id',$request->id)->where('product_id',$products_id[$i])->delete();
            }
        }
        $product_id_unique=array_unique($request->product_id);
        $pro_ids=$request->product_id;

        // ozine tuser bahasin esaplaw  
        $index_id = array_map(function($product_id_unique, $pro_ids) {
            return $product_id_unique === $pro_ids;
        }, $product_id_unique, $pro_ids);

        // for ($i=0; $i < count($index_id); $i++) { 
        //     $price=Product::find($request->product_id[$i])->price;
        //     if($index_id[$i]){
        //         $cost_price+=$request->quantity[$i]/$request->litr[$i]*$price;
        //     }
        // }



        Bread::where('id',$request->id)
        ->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'kindergarden_price'=>$request->kindergarden_price,
            // 'cost_price'=>$cost_price,
        ]);

        for ($i=0; $i < count($index_id); $i++) { 
            if($index_id[$i]){
                if(Bread_product::where('bread_id',$request->id)->where('product_id',$request->product_id[$i])->exists()){
                    Bread_product::where('bread_id',$request->id)->where('product_id',$request->product_id[$i])
                    ->update([
                        'quantity'=>$request->quantity[$i],
                        'milky_quan'=>$request->litr[$i]
                    ]);
                }else{
                    Bread_product::create([
                        'bread_id'=>$request->id,
                        'product_id'=>$request->product_id[$i],
                        'quantity'=>$request->quantity[$i],
                        'milky_quan'=>$request->litr[$i]
                    ]);
                }
            }
        }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('breads.index')->with('error', 'Не удалось');
        }
        return redirect()->route('breads.index')->with('success', 'Успешно обновлено');
    }

    public function showBread(Request $request ,Bread $bread){
        
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');

        $coming_bread=Production::where('bread_id',$bread->id)->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();
        
        $expenditure_bread=Sale::where('bread_id',$bread->id)->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();

        $sellers=User::where('role_id',1)->orWhere('role_id',2)->orWhere('role_id',3)->with(["sale" => function($q) use($bread,$start_date,$end_date) {$q->where('bread_id', '=', $bread->id)->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]);}])->get();
        

        return view('admin.pages.warehouse.show_bread',compact('bread','coming_bread','expenditure_bread','sellers','start_date','end_date'));
    }
}

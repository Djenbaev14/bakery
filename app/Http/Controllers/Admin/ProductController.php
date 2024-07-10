<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coming_product;
use App\Models\Expenditure_product;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Union;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(){
        $unions=Union::all();
        $suppliers=Supplier::all();
        $products=Product::orderBy('id','desc')->get();
        return view('admin.pages.warehouse.products',compact('unions','suppliers','products'));
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|unique:products,name,'.$request->name,
            'price'=>'required',
            'union_id'=>'required'
        ]);

        Product::create([
            'union_id'=>$request->union_id,
            'name'=>$request->name,
            'price'=>$request->price,
        ]);
        return redirect()->route('products.index')->with('success', 'Успешно создана');
    }

    public function show(Product $product,Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');
        $coming_products=Coming_product::where('product_id',$product->id)->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();
        $expenditure_products=Expenditure_product::where('product_id',$product->id)->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();
        return view('admin.pages.warehouse.show_product',compact('product','coming_products','expenditure_products','start_date','end_date'));
    }

    public function destroy(Request $request,$id){
        Product::destroy($id);
        return redirect()->route('products.index')->with('success', 'Успешно удалена');
    }

    public function update(Request $request){
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric|min:0'
        ]);
        Product::where('id',$request->id)
        ->update([
            'name'=>$request->name,
            'price'=>$request->price
        ]);
        return redirect()->route('products.index')->with('success', 'Успешно обновлено');
    }

    public function addQuantity(Request $request,){
        $request->validate([
            'quantity'=>'required|numeric|min:0',
            'price'=>'required|numeric|min:0',
            'product_id'=>'required',
            'supplier_id'=>'required',
        ]);
        try {
            if($request->product_id==1){
                Product::where('id',2)->update([
                    'price'=>$request->price
                ]);
            }
            Coming_product::create([
                'user_id'=>auth()->user()->id,
                'supplier_id'=>$request->supplier_id,
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'price'=>$request->price,
                'created_at'=>$request->created_at." ".date("H:i:s")
            ]);

            Product::where('id',$request->product_id)->update([
                'price'=>$request->price,
                'created_at'=>$request->created_at." ".date("H:i:s")
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('products.index')->with('error', 'Не удалось');
        }
        return redirect()->route('products.index')->with('success', 'Успешно добавлен');
    }

    public function showDestory(Request $request,$id){

        if(auth()->user()->role_id==1 || (auth()->user()->role_id==2 && Coming_product::find($id)->where('created_at' ,'>=', now()->subMinutes(10))->exists())){
            Coming_product::destroy($id);
            return redirect()->route('products.index')->with('success', 'Успешно удалена');
        }else{
            return redirect()->route('products.index')->with('error', 'Не удалось');
        }
    }
}

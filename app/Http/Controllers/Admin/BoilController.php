<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coming_product;
use App\Models\Expenditure_coming_product;
use App\Models\Expenditure_product;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BoilController extends Controller
{
    public function index(){
        $milk=Product::where('type','boil')->get();
        $products=Expenditure_coming_product::orderBy('created_at','desc')->paginate(100);
        $products->setCollection($products->groupBy('expenditure_product_id'));
        return view('admin.pages.boil.index',compact('milk','products'));
    }

    public function create(Request $request){
        $request->validate([
            'bread_id'=>'required|numeric',
            'quantity'=>'required|numeric',
            'cream_quantity'=>'required|numeric|max:'.$request->quantity,
            'created_at' => 'required|',
        ]);
        $coming_product[0]=Coming_product::create([
            'user_id'=>auth()->user()->id,
            'supplier_id'=>1,
            'product_id'=>2,
            'quantity'=>$request->quantity-$request->cream_quantity,
            'price'=>Product::find(2)->price,
            'created_at'=>$request->created_at." ".date("H:i:s")
        ]);
        
        $coming_product[1]=Coming_product::create([
            'user_id'=>auth()->user()->id,
            'supplier_id'=>1,
            'product_id'=>3,
            'quantity'=>$request->cream_quantity,
            'price'=>Product::find(3)->price,
            'created_at'=>$request->created_at." ".date("H:i:s")
        ]);

        
        $expenditure_product=Expenditure_product::create([
            'user_id'=>auth()->user()->id,
            'product_id'=>1,
            'quantity'=>$request->quantity,
            'created_at'=>$request->created_at." ".date("H:i:s")
        ]);

        for ($i=0; $i < count($coming_product); $i++) { 
            Expenditure_coming_product::create([
                'user_id'=>auth()->user()->id,
                'expenditure_product_id'=>$expenditure_product->id,
                'coming_product_id'=>$coming_product[$i]->id,
                'created_at'=>$request->created_at." ".date("H:i:s")
            ]);
        }
        
        return redirect()->route('boil.index')->with('success', 'Успешно создана');
    }

    public function delete(Request $request,Expenditure_product $expenditure_product){
        if(auth()->user()->role_id==1 || auth()->user()->role_id==2){
                $expenditure_coming_product=Expenditure_coming_product::where('expenditure_product_id',$expenditure_product->id)->get();
    
                for ($i=0; $i < count($expenditure_coming_product); $i++) { 
                    Coming_product::destroy($expenditure_coming_product[$i]->coming_product_id);
                }
                $expenditure_product->delete();
                return redirect()->route('boil.index')->with('success', 'Успешно удалена');
        }else{
            return redirect()->route('boil.index')->with('error', 'Не удалось');
        }

    }
}

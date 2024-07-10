<?php

namespace App\Http\Controllers;

use App\Models\Coming_product;
use App\Models\sale_history;
use App\Models\Supplier;
use App\Models\Transfers_to_supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index(){
        $suppliers=Supplier::orderBy('id','desc')->get();
        return view('admin.pages.suppliers.index',compact('suppliers'));
    }
    
    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'phone'=>'required|unique:users,phone,'.$request->phone,
        ]);

        Supplier::create([
            'user_id'=>auth()->user()->id,
            'name'=>$request->name,
            'phone'=>$request->phone,
            'comment'=>$request->comment
        ]);
        
        return redirect()->route('suppliers.index')->with('success', 'успешно создана');
    }

    public function show(Request $request, Supplier $supplier){

        
        $start_date =$request->start_date ? $request->start_date : date('Y-m-01');
        $end_date =$request->end_date ? $request->end_date : date('Y-m-d');

        $payments=Transfers_to_supplier::where('supplier_id',$supplier->id)->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();
        $delivery=Coming_product::where('supplier_id',$supplier->id)->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();
        return view('admin.pages.suppliers.show',compact('supplier','payments','delivery','start_date','end_date'));
    }

    public function paid(Request $request,Supplier $supplier){
        $request->validate([
            'summa'=>'required|numeric|min:0',
            'type'=>'required',
            'comment'=>'required',
            'created_at'=>'required'
        ]);

            try {
                Transfers_to_supplier::create([
                    'supplier_id'=>$supplier->id,
                    'paid'=>$request->summa,
                    'type'=>$request->type,
                    'comment'=>$request->comment,
                    'created_at'=>$request->created_at." ".date("H:i:s")
                ]);
    
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->route('suppliers.show',$supplier->id)->with('error', 'Не удалось');
            }
            return redirect()->route('suppliers.show',$supplier->id)->with('success', 'успешно создана');
    }
    public function update(Request $request){
        $request->validate([
            'name'=>'required',
            'phone'=>'required|unique:users',
            'comment'=>'required'
        ]);

        Supplier::where('id',$request->id)->update([
            'user_id'=>auth()->user()->id,
            'name'=>$request->name,
            'phone'=>$request->phone,
            'comment'=>$request->comment
        ]);
        
        return redirect()->route('suppliers.index')->with('success', 'успешно создана');
    }

    public function paymentDestroy(Request $request,$supplier_id,$id){
        
        if(auth()->user()->role_id==1 || (auth()->user()->role_id==2 && Transfers_to_supplier::find($id)->where('created_at' ,'>=', now()->subMinutes(10))->exists())){
            Transfers_to_supplier::destroy($id);
            return redirect()->route('suppliers.show',$supplier_id)->with('success', 'Успешно удалена');
        }else{
            return redirect()->route('productions.index')->with('error','Не удалось');
        }
    }
}

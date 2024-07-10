<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bread;
use App\Models\Delivery;
use App\Models\Refund_bread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function index(){
        $breads=Bread::all();
        $trucks=User::where('role_id',3)->get();
        if(auth()->user()->role_id ==3){
            $deliveries=Delivery::where('truck_id','=',auth()->user()->id)->orderBy('created_at','desc')->get();
        }else{
            $deliveries=Delivery::orderBy('created_at','desc')->get();
        }
        
        $delivery_breads=Bread::with(["delivery" => function($q){$q->where('truck_id', '=', auth()->user()->id);}])
        ->with(["refund_bread" => function($q){$q->where('user_id', '=', auth()->user()->id);}])
        ->with(["sale" => function($q){$q->where('user_id', '=', auth()->user()->id);}])->get();
         
        foreach ($delivery_breads as $bread) {
            $bread->quantity=$bread->delivery->sum('quantity')-$bread->sale->sum('quantity')-$bread->refund_bread->sum('quantity');
        }
        return view('admin.pages.deliveries.index',compact('deliveries','breads','trucks','delivery_breads'));
    }
    public function deliveryHistory(){
        
        // $title = 'Удаление возвращенного товара!!';
        // $text = "Вы уверены, что хотите удалить?";
        // confirmDelete($title, $text);
        return view('admin.pages.deliveries.delivery-history');
    }
    public function store(Request $request){
        $request->validate([
            'bread_id'=>'required',
            'quantity'=>'required',
        ]);
        
        DB::beginTransaction();
        try {
                    Delivery::create([
                        'responsible_id'=>auth()->user()->id,
                        'truck_id'=>$request->truck_id,
                        'bread_id'=>$request->bread_id,
                        'quantity'=>$request->quantity,
                    ]);  
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('deliveries.index')->with('error', 'Не удалось');
        }
        

        
        return redirect()->route('deliveries.index')->with('success', 'Успешно создана');
    }

    public function refund(Request $request){
        $request->validate([
            'bread_id'=>'required',
            'quantity'=>'required|numeric|min:1|max:'.warehouse_quan_delivery($request->bread_id)
        ]);
        
        DB::beginTransaction();

        try {
            
            // $bread=Bread::where('id',$request->bread_id)->with(["delivery" => function($q){$q->where('truck_id', '=', auth()->user()->id);}])
            // ->with(["refund_bread" => function($q){$q->where('user_id', '=', auth()->user()->id);}])
            // ->with(["sale" => function($q){$q->where('user_id', '=', auth()->user()->id);}])->first();
            
            // $quantity=$bread->delivery->sum('quantity')-$bread->sale->sum('quantity')-$bread->refund_bread->sum('quantity');


            Refund_bread::create([
                'user_id'=>auth()->user()->id,
                'bread_id'=>$request->bread_id,
                'quantity'=>$request->quantity
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('deliveries.index')->with('error', 'Не удалось');
        }
        
        return redirect()->route('deliveries.index')->with('success', 'Успешно изменен');
    }
    public function destroy(Request $request,Delivery $delivery){
        
        if($delivery->quantity <= warehouse_quan_truck($delivery->truck_id,$delivery->bread_id)){
            Delivery::destroy($delivery->id);
            return redirect()->route('deliveries.index')->with('success', 'Успешно удалена');
        }else{
            return redirect()->route('deliveries.index')->with('error', 'Не удалось');
        }
        
        
    }
    public function refundConfirm(Request $request,$id){
        Refund_bread::where('id',$id)->update([
            'status'=>'1'
        ]);
        return redirect()->route('deliveries.delivery-history')->with('success', 'Успешно подтверждено');

    }
    public function refundDestroy(Request $request,$id){
        
        if(auth()->user()->role_id==1 || (auth()->user()->role_id==2 && Refund_bread::find($id)->where('created_at' ,'>=', now()->subMinutes(10))->exists())){
            Refund_bread::destroy($id);
            return redirect()->route('deliveries.delivery-history')->with('success', 'Успешно удалена');
        }else{
            return redirect()->route('deliveries.delivery-history')->with('error', 'Не удалось');
        }
        

    }
    
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Control;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccessController extends Controller
{
    public function index(){
        $workers=Role::where('name','WORKER')->first();
        $access_controls=DB::table('controls')
        ->join('users','controls.first_id','=','users.id')
        ->leftJoin('users as us','controls.second_id','=','us.id')
        ->select('controls.*','users.username as first_name','us.username as second_name')
        ->orderBy('id','desc')
        ->paginate(10);
        if(Control::whereNull('end_date')->exists()){
            $first_id=Control::orderBy('id','desc')->first()->first_id;
            $second_id=Control::orderBy('id','desc')->first()->second_id;
        }else{
            $first_id=null;
            $second_id=null;
        }
        $arr=[];
        array_push($arr,$first_id,$second_id);
        return view('admin.pages.controls.index',compact('access_controls','workers','arr'));
    }

    public function store(Request $request){
        $request->validate([
            'user_id'=>'required|array|min:2|max:2'
        ]);
        if($request->has('access')){
            if(Control::whereNull('end_date')->exists()){
                Control::whereNull('end_date')->update([
                    'end_date'=>now()->toDateTimeString()
                ]);
            }
            Control::create([
                'first_id'=>$request->user_id[0],
                'second_id'=>$request->user_id[1]
            ]);
            
            return redirect()->route('controls.index')->with('success', 'успешно создана');
        }elseif ($request->has('limit')) {
            if(Control::whereNull('end_date')->exists()){
                Control::whereNull('end_date')->update([
                    'end_date'=>now()->toDateTimeString()
                ]);
            }
            
            return redirect()->route('controls.index')->with('success', 'успешно создана');
        }
        $first_id=$request->user_id[0];
        $second_id=$request->user_id[1];
        return redirect()->route('controls.index')->with('error', 'неудачно создана');
    }
}

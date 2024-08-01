<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FineController extends Controller
{
    public function index(Request $request){
        $title = 'Жаримани очириш!!';
        $text = "Очиришни хохлайсизми?";
        confirmDelete($title, $text);
        $start_date=$request->start_date ? $request->start_date : date('Y-m-d');
        $end_date=$request->end_date ? $request->end_date : date('Y-m-d');
        $users=User::orderBy('id','desc')->get();
        $fines_expectation=Fine::where('status','=','0')->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();
        $fines=Fine::where('status','=','1')->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();
        return view('admin.pages.fines.index',compact('start_date','end_date','users','fines','fines_expectation'));
    }

    public function store(Request $request){
        $request->validate([
            'price'=>'required',  
        ]);
        $file_name='';
        if (!empty($request->image)) {
            $request->validate([
                'image' => 'required|mimes:png,jpg,jpeg|max:2048'
            ]);
            $file =$request->file('image');
            $file_name = $file->getClientOriginalName(); 
            $file->move(public_path('admin/fines'), $file_name);
        }

        Fine::create([
            'responsible_id'=>auth()->user()->id,
            'user_id'=>$request->user_id,
            'price'=>$request->price,
            'comment'=>$request->comment,
            'image'=>$file_name ,
        ]);
        
        return redirect()->route('fines.index')->with('success', 'Успешно создана');
    }
    public function check(Request $request,$fine_id){
        Fine::where('id',$fine_id)->update([
        'status'=>1 
        ]);
        return redirect()->route('fines.index')->with('success', 'Успешно изменен');
    }

    public function destroy(Request $request,$fine_id){
        Fine::find($fine_id)->delete();
        return redirect()->route('fines.index')->with('success', 'Успешно удалена');
    }
}

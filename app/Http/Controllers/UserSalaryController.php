<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Production;
use App\Models\Sale_items;
use App\Models\User;
use App\Models\User_salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSalaryController extends Controller
{
    public function index(Request $request){
        $start_date = $request->start_date ? $request->start_date : date('Y-m-d');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');

        $users=User::where('role_id','=',3)->with(['user_salary' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->with(['return_bread' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->with(['expenditure' => function($q) use ($start_date,$end_date) { 
            $q->whereBetween(DB::raw('date(created_at)'), [$start_date,$end_date]); 
        }])->orderBy('id','desc')->paginate(50);

        return view('admin.pages.users_salary.index',compact('users','start_date','end_date'));
    }


    public function show(Request $request, User $user){

        $start_date = $request->start_date ? $request->start_date : date('Y-m-d');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');

        $user_salary=User_salary::where('user_id',$user->id)->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('id','desc')->paginate(50);
        $expenditure=Expenditure::where('user_id',$user->id)->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('id','desc')->paginate(50);
        return view('admin.pages.users_salary.show',compact('user_salary','expenditure','user','start_date','end_date'));
    }

    public function expenditure(Request $request){
        $request->validate([
            'summa'=>'required|numeric'
        ]);
        Expenditure::create([
            'expenditure_type_id'=>1,
            'user_id'=>$request->user_id,
            'price'=>$request->summa,
        ]);
        return redirect()->route('users_salary.index')->with('success', 'Успешно обновлено');
    }
}

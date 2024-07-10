<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bread;
use App\Models\Expenditure;
use App\Models\Expenditure_Salary;
use App\Models\ExpenditureType;
use App\Models\User;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenditureController extends Controller
{
    public function index(Request $request){
        // return Expenditure::find(2)->expenditure_salary[0];
        $title = 'Харажатни очириш!!';
        $text = "Очиришни хохлайсизми?";
        confirmDelete($title, $text);
        $breads=Bread::all();
        $start_date=$request->start_date ? $request->start_date : date('Y-m-d');
        $end_date=$request->end_date ? $request->end_date : date('Y-m-d');
        $user_id=$request->user_id ? $request->user_id : '';
        $users=User::orderBy('id','desc')->get();
        $expenditures=Expenditure::where('responsible_id','=',$user_id)->orWhereHas('expenditure_salary', function ($query) use ($user_id){
            $query->where('user_id', '=', $user_id);
        })->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();
        $expenditure_type=ExpenditureType::all();
        if($user_id == 'Все' || !$user_id){
            $expenditures=Expenditure::whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->get();
        }
        if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4){
            $user_id=auth()->user()->id;
            $expenditure_type=ExpenditureType::where('deduction_from_wages','=','0')->get();
        }
        return view('admin.pages.expenditure.index',compact('expenditures','expenditure_type','start_date','end_date','breads','user_id','users'));
    }
    public function show(Request $request ,User $user){
        $start_date=$request->start_date ? $request->start_date : date('Y-m-d');
        $end_date=$request->end_date ? $request->end_date : date('Y-m-d');
        $expenditures=Expenditure::where('responsible_id','=',$user->id)->whereBetween(DB::raw('date(created_at)'),[$start_date,$end_date])->orderBy('created_at','desc')->paginate(50);

        return view('admin.pages.expenditure.show',compact('expenditures','user','start_date','end_date'));
    }

    public function store(Request $request){
        $request->validate([
            'price'=>'required|numeric|min:0',
        ]);
        $expenditure=Expenditure::create([
            'expenditure_type_id'=>$request->expenditure_type_id,
            'responsible_id'=>auth()->user()->id,
            'price'=>$request->price,
            'comment'=>$request->comment,
            'created_at'=>$request->created_at." ".date("H:i:s")
        ]);
        if(ExpenditureType::find($request->expenditure_type_id)->deduction_from_wages == 1){
            Expenditure_Salary::create([
                'expenditure_id'=>$expenditure->id,
                'user_id'=>$request->user_id
            ]);
        }
        return redirect()->route('expenditure.index')->with('success', 'Успешно создана');
    }
    public function type_store(Request $request){
        $request->validate([
            'name'=>'required|unique:expenditure_types,name'
        ]);
        ExpenditureType::create([
            'name'=>$request->name
        ]);
        return redirect()->route('expenditure.index')->with('success', 'Успешно создана');

    }
    // public function filter(Request $request){
    //     $request->validate([
    //         'date_from'=>'required',
    //         'date_to'=>'required'
    //     ]);
    //     $expenditures=Expenditure::orderBy('id','desc')
    //     ->join('expenditure_types','expenditures.expenditure_type_id','=','expenditure_types.id')
    //     ->join('users','expenditures.added_id','=','users.id')
    //     ->select('users.username','expenditure_types.name','expenditures.*')
    //         ->when(
    //             $request->date_from && $request->date_to,
    //             function (Builder $builder) use ($request) {
    //                 $builder->whereBetween(
    //                     DB::raw('DATE(expenditures.created_at)'),
    //                     [
    //                         $request->date_from,
    //                         $request->date_to
    //                     ]
    //                 );
    //             }
    //         )
    //         ->paginate(10);
    //     $role_expense=Expenditure::orderBy('id','desc')
    //     ->join('users','expenditures.added_id','=','users.id')
    //     ->join('roles','roles.id','=','users.role_id')
    //     ->select('expenditures.*','roles.name as role_name')
    //         ->when(
    //             $request->date_from && $request->date_to,
    //             function (Builder $builder) use ($request) {
    //                 $builder->whereBetween(
    //                     DB::raw('DATE(expenditures.created_at)'),
    //                     [
    //                         $request->date_from,
    //                         $request->date_to
    //                     ]
    //                 );
    //             }
    //         )
    //     ->get()
    //     ->groupBy('role_name');
    //     $expenditure_type=ExpenditureType::all();
    //     $date_from=$request->date_from;
    //     $date_to=$request->date_to;
    //     return view('admin.pages.expenditure.index',compact('expenditures','expenditure_type','date_from','date_to','role_expense'));
    // }

    public function delete(Request $request,Expenditure $expenditure){
        $expenditure->delete();
        return redirect()->route('expenditure.index')->with('success', 'Успешно удалена');
    }
    
}

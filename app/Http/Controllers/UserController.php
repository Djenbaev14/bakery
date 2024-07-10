<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function users(){
        $users=DB::table('users')
        ->join('roles','users.role_id','=','roles.id')
        ->select('users.*','roles.name as role_name','roles.r_name')
        ->orderBy('id','desc')
        ->paginate(50);
        $roles=Role::all();
        return view('admin.pages.users.index',compact('users','roles'));
    }

    public function edit(User $user){
        return view('admin.pages.users.edit',compact('user'));
    }

    public function update(Request $request,User $user){
        // if (!(Hash::check($request->get('current_password'), $user->password))) {
        //     return redirect()->back()->with("error","Ваш текущий пароль не совпадает с вашим паролем.");
        // }

        // if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
        //     return redirect()->back()->with("error","Новый пароль не может совпадать с вашим текущим паролем.");
        // }

        // $request->validate([
        //     'username'=>'required',
        //     'phone'=>'required|min:9',
        //     'KPI'=>'required',
        //     'current_password' => 'required',
        //     'new_password' => 'required|string|min:8',
        // ]);
        
        $request->validate([
            'username'=>'required',
            'phone'=>'required|min:9',
            'KPI'=>'required',
        ]);

        //Change Password
        $user->update([
            'username'=>$request->username,
            'phone'=>$request->phone,
            'KPI'=>$request->KPI,
        ]);
        return redirect()->route('users.index')->with("success","успешно изменен!");
    }

    public function store(Request $request){
        $request->validate([
            'username'=>'required|unique:users,username,'.$request->username,
            'phone'=>'required|unique:users,phone,'.$request->phone,
            'KPI'=>'required|numeric|min:0',
            'password'=>'required',
            'role_id'=>'required'
        ]);
        User::create([
            'role_id'=>$request->role_id,
            'username'=>$request->username,
            'phone'=>$request->phone,
            'KPI'=>$request->KPI,
            'password'=>Hash::make($request->password)
        ]);
        return redirect()->route('users.index')->with('success', 'успешно создана');
    }

    public function Userkey($id){
        Auth::logout();
        $user=User::find($id);
        Auth::login($user);

        return redirect()->route('home');
    }

    // public function destroy(User $user){
    //     return $request->all();
    // }
}

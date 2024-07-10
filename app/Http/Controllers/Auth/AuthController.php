<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function auth(Request $request){
        $login = request()->input('user');

        if(is_numeric($login)){
            $field = 'phone';
        }else {
            $field = 'username';
        }
        
        request()->merge([$field => $login]);

        if(Auth::attempt(request()->only($field,'password'))){
            $role=Role::find(auth()->user()->role_id)->name;
            return redirect()->route('home');
        }

        return redirect()->back()->with('error', 'Логин или пароль неверный');
    }

    public function logout(Request $request){

        Auth::logout();

        return redirect()->route('login');
    }
}

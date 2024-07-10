<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class DebtClientController extends Controller
{
    public function index(){
        $clients=Client::all();
        return view('admin.pages.debt_clients.index',compact('clients'));
    }
}

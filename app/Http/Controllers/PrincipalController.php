<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PrincipalController extends Controller
{
    public function index(Request $request){
        return view("principal.index");
    }

    public function listDistributor(Request $request){
        return view("principal.list-distributor");
    }

    public function monitorStockOnDistributor(Request $request){
        $distributor = User::find($request->id);
        return view("principal.distributor-stock", compact('distributor'));
    }
}

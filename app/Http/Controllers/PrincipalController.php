<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function index(Request $request){
        return view("principal.index");
    }

    public function listDistributor(Request $request){
        return view("principal.list-distributor");
    }
}

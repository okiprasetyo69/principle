<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Repositories\DistributorStockRepositoryEloquent;

class DistributorController extends Controller
{
     /**
    * @var Category
    */
    
    private DistributorStockRepositoryEloquent $distributor;

    public function __construct(DistributorStockRepositoryEloquent $distributor) 
    {
        $this->distributor = $distributor;
    }

    public function index(Request $request){
        return view("distributor.index");
    }

    public function distributorStock(Request $request){
        $user = Auth::user();
        return view("distributor.stock.index", compact("user"));
    }

    public function distributorPurchaseOrder(Request $request){
        $user = Auth::user();
        return view("distributor.purchase_order.index", compact("user"));
    }

    public function addPurchaseOrder(Request $request){
        $user = Auth::user();
        return view("distributor.purchase_order.add", compact("user"));
    }
}

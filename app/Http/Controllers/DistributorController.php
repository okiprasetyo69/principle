<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Repositories\DistributorStockRepositoryEloquent;
use App\Models\Product;
use Illuminate\Pagination\CursorPaginator;

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
        $query = Product::query();

        if($request->search_product != null){
            $query = $query->where("product_name", "like", "%" . $request->search_product. "%");
        }
        
        $data = $query->with('category', 'items')->cursorPaginate(9);
        
        return view("distributor.stock.index", compact("data", "user"));
    }

    public function loadMoreProductPaginate(Request $request){    
        $cursor = $request->cursor;    
        $query = Product::query();

        if($request->product_name != null){
            $query = $query->where("product_name", "like", "%" . $request->product_name. "%");
        }
        $data = $query->with('category', 'items')->cursorPaginate(9, ['*'], 'cursor', $cursor);
        return response()->json([
            'data' => $data->items(),
            'next_cursor' => $data->nextCursor()?->encode(),
        ]);
    }

    public function detailProduct(Request $request){
        $user = Auth::user();
        $product = Product::with('category', 'items')->where("product_name", $request->product_name)->where("id", $request->id)->first();
        return view("distributor.stock.detail_product", compact("product", "user"));
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

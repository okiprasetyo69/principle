<?php

namespace App\Services\Repositories;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Services\Interfaces\ProductService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProductRepositoryEloquent implements ProductService {
    /**
     * @var Product
     */
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(Request $request){
        try{
            
            $product = $this->product::with('category')->orderBy('product_name', 'ASC');
          
            if($request->product_name != null){
                $product = $product->where("product_name", "like", "%" . $request->product_name. "%");
            }

            $product = $product->get();

            $datatables = Datatables::of($product);
            return $datatables->make( true );
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){

    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }

    public function detail(Request $request){

    }

}
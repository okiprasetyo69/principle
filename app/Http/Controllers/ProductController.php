<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;

class ProductController extends Controller
{
    public function index(Request $request){
        return view("principal.product.index");
    }

    public function addProduct(Request $request){
        return view("principal.product.add");
    }

    public function edit(Request $request, $id){
        $product = Product::with("items")->where("id", $id)->first();
        return view("principal.product.detail", compact("product"));
    }

}


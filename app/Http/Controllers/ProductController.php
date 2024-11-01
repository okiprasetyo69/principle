<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function signature(Request $request){
        $userId = auth()->user()->id;
        $path = "public/uploads/signatures/".$userId.".png";
        $existPath = Storage::exists($path);
        $url = "";
        if($existPath){
            $url = Storage::url($path);
        }
        return view("principal.product.signature", compact('url'));
    }
}


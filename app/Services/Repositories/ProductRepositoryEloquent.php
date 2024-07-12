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
use Illuminate\Support\Facades\File; 

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
            
            $product = $this->product::with('category', 'items');
          
            if($request->product_name != null){
                $product = $product->where("product_name", "like", "%" . $request->product_name. "%");
            }

            if($request->category_id != null){
                $product = $product->where("category_id", $request->category_id);
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
        try{

            $product = $this->product;
            $product->fill($request->all());

            $imageName = "";
            if($request->hasFile('image_name')){
                // add new file
                $file = $request->file('image_name');
                $imageName = $file->getClientOriginalName();
                $image['filePath'] = $imageName;
                $file->move(public_path().'/uploads/product/', $imageName);
            }

            $product->product_name = $request->product_name;
            $product->title = $request->title;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->qty = $request->qty;
            $product->total_price = (int) $request->qty * (int) $request->price;
            $product->save();

            $productDetail = new ProductDetail();
            $productDetail->product_id = $product->id;
            $productDetail->image_name = $imageName;
            $productDetail->description = $request->description;

            $productDetail->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $product
            ]); 

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function update(Request $request){
        try{
            $product = $this->product;
            $product->fill($request->all());

            $product = $product::where("id", $request->id)->first();

            if($product == null){
                return response()->json([
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $imageName = "";
            $productDetail = ProductDetail::where("product_id", $product->id)->first();

            if($request->hasFile('image_name')){

                $existFile = File::exists(public_path('uploads/product/'.$productDetail->image_name.'')); 
                
                if($existFile){
                    File::delete(public_path('uploads/product/'.$productDetail->image_name.''));
                }

                $file = $request->file('image_name');
                $imageName = $file->getClientOriginalName();
                $image['filePath'] = $imageName;
                $file->move(public_path().'/uploads/product/', $imageName);
            } else {
                $imageName = $productDetail->image_name;
            }

            $product->product_name = $request->product_name;
            $product->title = $request->title;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->qty = $request->qty;
            $product->total_price = (int) $request->qty * (int) $request->price;
            $product->save();

            $productDetail->product_id = $product->id;
            $productDetail->image_name = $imageName;
            $productDetail->description = $request->description;
            $productDetail->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $product
            ]); 

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request, $id){
        try{
            $product = $this->product::with('category', 'items')->where("id", $id)->first();

            if($product == null){
                return response()->json([
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $product
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request, $id){
        try{
            $product = $this->product::where("id", $id)->first();

            if($product == null){
                return response()->json([
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $productDetail = ProductDetail::where("product_id", $id)->first();
            $existFile = File::exists(public_path('uploads/product/'.$productDetail->image_name.'')); 
            if($existFile){
                File::delete(public_path('uploads/product/'.$productDetail->image_name.''));
            }
            
            $product->delete();
            $productDetail->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Success delete product .',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

}
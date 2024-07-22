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
use Illuminate\Support\Arr;

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

            if($request->id != null){
                $product = $product->where("id", $request->id);
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

            $product->product_name = $request->product_name;
            $product->title = $request->title;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->qty = $request->qty;
            $product->total_price = (int) $request->qty * (int) $request->price;
            $product->description = $request->description;
            $product->save();

            $imageNames = [];
            if($request->hasfile('images')){

                foreach($request->file('images') as $file){
                    $imageName = time().'_'.str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move(public_path().'/uploads/product/', $imageName);
                    $imageNames[] = $imageName;
                    ProductDetail::create([
                        'product_id' => $product->id,
                        'image_name' => $imageName
                    ]);
                }
            }

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
            // dd($request->id);
            $product = $this->product;
            $product->fill($request->all());

            $product = $product::where("id", $request->id)->first();

            if($product == null){
                return response()->json([
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $product->product_name = $request->product_name;
            $product->title = $request->title;
            $product->price = $request->price;
            $product->category_id = $request->category_id;
            $product->qty = $request->qty;
            $product->total_price = (int) $request->qty * (int) $request->price;
            $product->description = $request->description;
            $product->save();

            $productDetail = ProductDetail::where("product_id", $request->id)->get();
            $imageNames = [];
            if($request->hasfile('images')){
                //remove exist file
                if($productDetail != null){
                    foreach ($productDetail as $key => $value) {
                        $existFile = File::exists(public_path('uploads/product/'.$value->image_name.'')); 
                        if($existFile){
                            File::delete(public_path('uploads/product/'.$value->image_name.''));
                            $productDetail[$key]->delete();
                        }
                    }
                }

                foreach($request->file('images') as $file){
                    $imageName = time().'_'.str_replace(' ', '_', $file->getClientOriginalName());
                    $file->move(public_path().'/uploads/product/', $imageName);
                    $imageNames[] = $imageName;
                    ProductDetail::create([
                        'product_id' => $product->id,
                        'image_name' => $imageName
                    ]);
                }
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

    public function delete(Request $request){
        try{
            $product = $this->product::where("id", $request->id)->first();

            if($product == null){
                return response()->json([
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }
            
            $productDetail = ProductDetail::where("product_id", $request->id)->first();

            $existFile = File::exists(public_path('uploads/product/'.$productDetail->image_name.'')); 
            if($existFile != null){
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
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Controllers\Controller as BaseController;

use App\Services\Interfaces\ProductService;

class ProductApiController extends BaseController
{
    
    private ProductService $service;

    public function __construct(ProductService $service) 
    {
        $this->service = $service;
    }

    public function getProduct(Request $request){
        try{
            $product = $this->service->getProduct($request);
            if($product != null){
                return $product;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{
            $validator = Validator::make(
                $request->all(), [
                    'product_name' => 'required',
                    'price' => 'required',
                    'qty' => 'required',
                    'category_id' => 'required',
                    'image_name' => 'max:2048',
                ]
            );
    
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors()->first(),
                    'status' => 400
                ]);
            }

            $product = $this->service->create($request);
            if($product != null){
                return $product;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function update(Request $request){
        try{
            $validator = Validator::make(
                $request->all(), [
                    'id' => 'required',
                    'product_name' => 'required',
                    'price' => 'required',
                    'qty' => 'required',
                    'category_id' => 'required',
                    'image_name' => 'max:2048',
                ]
            );
    
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors()->first(),
                    'status' => 400
                ]);
            }

            $product = $this->service->update($request);
            if($product != null){
                return $product;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request, $id){
        try{
            $validator = Validator::make(['id' => $id], [
                'id' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors(),
                    'status' => 400
                ]);
            }
    
            $product = $this->service->detail($request, $id);
            return $product;
        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request, $id){
        try{
            $validator = Validator::make(['id' => $id], [
                'id' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->errors(),
                    'status' => 400
                ]);
            }
    
            $product = $this->service->delete($request, $id);
            return $product;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }    

}

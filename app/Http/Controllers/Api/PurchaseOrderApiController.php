<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Controllers\Controller as BaseController;

use App\Services\Interfaces\PurchaseOrderService;

class PurchaseOrderApiController extends BaseController
{
    /**
    * @var PurchaseOrder
    */
    
    private PurchaseOrderService $service;

    public function __construct(PurchaseOrderService $service) 
    {
        $this->service = $service;
    }

    public function getPurchaseOrder(Request $request){
        try{
            $purchaseOrder = $this->service->getPurchaseOrder($request);
            if($purchaseOrder != null){
                return $purchaseOrder;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'product_id' => 'required',
                'distributor_id' => 'required',
                'qty' => 'required',
            ]);
            
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 400
                ]);
            }

            $purchaseOrder = $this->service->create($request);
            if($purchaseOrder){
                return $purchaseOrder;
            }

        }catch(Exception $ex){
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

            $purchaseOrder = $this->service->delete($request, $id);
            if($purchaseOrder){
                return $purchaseOrder;
            }

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

            $purchaseOrder = $this->service->detail($request, $id);
            if($purchaseOrder){
                return $purchaseOrder;
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
        }
    }

}

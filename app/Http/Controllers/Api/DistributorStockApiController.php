<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Http\Controllers\Controller as BaseController;

use App\Services\Interfaces\DistributorStockService;

class DistributorStockApiController extends BaseController
{
    /**
    * @var DistributorStockService
    */
    
    private DistributorStockService $service;

    public function __construct(DistributorStockService $service) 
    {
        $this->service = $service;
    }

    public function getDistributorStockItem(Request $request){
        try{
            $distributorStock = $this->service->getDistributorStock($request);
            if($distributorStock != null){
                return $distributorStock;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

}
<?php

namespace App\Services\Repositories;

use App\Models\DistributorStock;
use App\Services\Interfaces\DistributorStockService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DistributorStockRepositoryEloquent implements DistributorStockService {
     /**
     * @var DistributorStock
     */
    private DistributorStock $distributorStock;

    public function __construct(DistributorStock $distributorStock)
    {
        $this->distributorStock = $distributorStock;
    }

    public function getDistributorStock(Request $request){
        try{
            
            $distributorStock = $this->distributorStock::with('user', 'product')->orderBy('qty', 'DESC');
          
            if($request->product_id != null){
                $distributorStock = $distributorStock->where("product_id", $request->product_id);
            }

            $distributorStock = $distributorStock->get();

            $datatables = Datatables::of($distributorStock);
            return $datatables->make( true );
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

}
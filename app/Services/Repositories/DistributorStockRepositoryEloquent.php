<?php

namespace App\Services\Repositories;

use App\Models\DistributorStock;
use App\Models\User;
use App\Models\Product;
use App\Services\Interfaces\DistributorStockService;
use App\Repositories\UserRepository;

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

     /**
     * @var User
     */
    private User $user;

    public function __construct(DistributorStock $distributorStock, User $user)
    {
        $this->distributorStock = $distributorStock;
        $this->user = $user;
    }

    public function getDistributorStock(Request $request){
        try{
            
            $distributorStock = $this->distributorStock::with('user', 'product')
                                ->orderBy('qty', 'DESC');
          
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

    public function getStockPerDistributor(Request $request){
        try{
            
            $distributorStock = $this->distributorStock::with('user', 'product')
                                ->where("user_id", $request->user_id)
                                ->orderBy('qty', 'DESC');
            
            if($request->product_id != null){
                $distributorStock = $distributorStock->where("product_id", $request->product_id);
            }

            if($request->id != null){
                $distributorStock = $distributorStock->where("id", $request->id);
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

    public function create(Request $request){
        try{
            $distributorStock = $this->distributorStock;
            $distributorStock->fill($request->all());

            if($request->id != null){
                $distributorStock = $distributorStock::find($request->id);
            }

            $product = Product::where("id", $request->product_id)->first();
            $distributorStock->user_id = $request->user_id;
            $distributorStock->product_id = $request->product_id;
            $distributorStock->qty = $request->qty;
            $distributorStock->total_price = (int) $request->qty * (int) $product->price;

            $distributorStock->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $distributorStock
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $distributorStock = $this->distributorStock::where("id", $request->id)->first();
            if($distributorStock == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $distributorStock->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete category.',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}   
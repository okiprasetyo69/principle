<?php

namespace App\Services\Repositories;

use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Services\Interfaces\PurchaseOrderService;
use App\Services\Constants\PurchaseOrderConstantInterface;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PurchaseOrderRepositoryEloquent implements PurchaseOrderService {

     /**
     * @var PurchaseOrder
     */
    private PurchaseOrder $purchaseOrder;

    public function __construct(PurchaseOrder $purchaseOrder)
    {
        $this->purchaseOrder = $purchaseOrder;
    }

    public function getPurchaseOrder(Request $request){
        try{
            
            $purchaseOrder = $this->purchaseOrder::with('distributor', 'product', 'admin');
          
            if($request->purchase_order_date != null){
                $purchaseOrder = $purchaseOrder->where("purchase_order_date", $request->purchase_order_date);
            }

            $purchaseOrder = $purchaseOrder->orderBy('purchase_order_date', 'DESC')->get();

            $datatables = Datatables::of($purchaseOrder);
            return $datatables->make( true );
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{
            $purchaseOrder = $this->purchaseOrder;
            $purchaseOrder->fill($request->all());

            $poNumber = "";
            $status = null;
            $verifiedBy = null;
            $verifiedDate = null;

            // get price from product
            $product = Product::where("id", $request->product_id)->first();

            if($request->id != null){
                $purchaseOrder = $purchaseOrder::find($request->id);
                $poNumber = $purchaseOrder->purchase_order_number;
            } 
            
            if($request->id == null){
                // create purchase order number
                $prefix = "PO";
                $date = now()->format('ym');
                $today = Carbon::today();
                $month = $today->format('m');
                $year = $today->format('Y');
                $invoice = PurchaseOrder::whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('id', 'desc')->first();
                $count = 0;
                if($invoice == null){
                    $poNumber =  $prefix . '.' . $date . '.' . $count + 1 ;
                } else {
                    $lastInvoice =  explode(".", $invoice->purchase_order_number);
                    $lastNumber = $lastInvoice[count($lastInvoice) - 1];
                    $poNumber =  $prefix . '.' . $date . '.' . $lastNumber + 1;
                }

                $status = PurchaseOrderConstantInterface::IN_ORDER;

            }
            
            if($request->verified_by != null){
                $verifiedBy = $request->verified_by;
                $verifiedDate = date('Y-m-d');
                $status = PurchaseOrderConstantInterface::VERIFIED_PURCHASE_ORDER;
            }

            // assign value
            $purchaseOrder->purchase_order_number = $poNumber;
            $purchaseOrder->distributor_id = $request->distributor_id;
            $purchaseOrder->product_id = $request->product_id;
            $purchaseOrder->qty = $request->qty;
            $purchaseOrder->total_price = (int) $request->qty * (int) $product->price;
            $purchaseOrder->purchase_order_date = date('Y-m-d');
            $purchaseOrder->status = $status;
            $purchaseOrder->verified_date = $verifiedDate;
            $purchaseOrder->verified_by = $verifiedBy;

            $purchaseOrder->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $purchaseOrder
            ]); 

        }catch(Exception $ex){
            Log::error($ex->getMessage());
        }
    }

    public function delete(Request $request, $id){
        try{
            $purchaseOrder = $this->purchaseOrder::where("id", $id)->first();
            if($purchaseOrder == null){
                return response()->json([
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $purchaseOrder->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete purchase order.',
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
        }
    }

    public function detail(Request $request, $id){
        try{
            $purchaseOrder = $this->purchaseOrder::where("id", $id)->first();

            if($purchaseOrder == null){
                return response()->json([
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Success get detail purchase order !',
                'data' => $purchaseOrder
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
        }
    }

}
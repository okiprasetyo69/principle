<?php

namespace App\Observers;
use App\Services\Constants\UserConstantInterface;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Models\Product;
use App\Mail\PurchaseOrderNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderObserver
{
    protected $user;
    protected $product;

    public function __construct(User $user, Product $product)
    {
        $this->user = $user;
        $this->product = $product;
    }

    public function created(PurchaseOrder $purhcaseOrder)
    {
        $user = $this->user::where("id", 1)->first();
        $product = $this->product::where("id", $purhcaseOrder->product_id)->first();
        $qtyOrder = $purhcaseOrder->qty;

        $sendMail = Mail::to($user->email)->send(new PurchaseOrderNotification($user, $product, $qtyOrder));
    }
}

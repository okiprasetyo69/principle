<?php

namespace App\Observers;

use App\Services\Constants\UserConstantInterface;
use App\Services\Constants\StockConstantInterface;
use App\Models\DistributorStock;
use App\Models\User;
use App\Models\Product;
use App\Mail\PrincipalMailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;

class PrincipalObserver
{
    protected $user;
    protected $product;

    public function __construct(User $user, Product $product)
    {
        $this->user = $user;
        $this->product = $product;
    }

    public function created(DistributorStock $distributorStock)
    {
        // Mail::to($user->email)->send(new PrincipalMailNotification($user));
    }

    public function updated(DistributorStock $distributorStock)
    {
       try{
            if($distributorStock->qty <= StockConstantInterface::STOCK_MINIMUM){
                $user = $this->user::where("id", 1)->first();
                $product = $this->product::where("id", $distributorStock->product_id)->first();
                // SEND MAIL
                $sendMail = Mail::to($user->email)->send(new PrincipalMailNotification($user, $product));
            }
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}

<?php

namespace App\Observers;

use App\Services\Constants\UserConstantInterface;
use App\Services\Constants\StockConstantInterface;
use App\Models\DistributorStock;
use App\Models\User;
use App\Models\Product;
use App\Mail\DistributorNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;

class DistibutorObserver
{
    protected $user;
    protected $product;

    public function __construct(User $user, Product $product)
    {
        $this->user = $user;
        $this->product = $product;
    }

    /**
     * Handle the DistributorStock "created" event.
     */
    public function created(DistributorNotification $distributorStock)
    {
        if($distributorStock->qty <= StockConstantInterface::STOCK_MINIMUM){
            $user = $this->user::where("id", $distributorStock->user_id)->first();
            $product = $this->product::where("id", $distributorStock->product_id)->first();
            // SEND MAIL
            $sendMail = Mail::to($user->email)->send(new DistributorNotification($user, $product));
        }
    }

    /**
     * Handle the DistributorStock "updated" event.
     */
    public function updated(DistributorStock $distributorStock)
    {
        try{
            if($distributorStock->qty <= StockConstantInterface::STOCK_MINIMUM){
                $user = $this->user::where("id", $distributorStock->user_id)->first();
                $product = $this->product::where("id", $distributorStock->product_id)->first();
                // SEND MAIL
                $sendMail = Mail::to($user->email)->send(new DistributorNotification($user, $product));
            }
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    /**
     * Handle the DistributorStock "deleted" event.
     */
    public function deleted(DistributorStock $distributorStock): void
    {
        //
    }

    /**
     * Handle the DistributorStock "restored" event.
     */
    public function restored(DistributorStock $distributorStock): void
    {
        //
    }

    /**
     * Handle the DistributorStock "force deleted" event.
     */
    public function forceDeleted(DistributorStock $distributorStock): void
    {
        //
    }
}

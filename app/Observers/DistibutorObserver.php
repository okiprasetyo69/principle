<?php

namespace App\Observers;

use App\Models\DistributorStock;
use App\Models\User;
use App\Mail\DistributorNotification;
use Illuminate\Support\Facades\Mail;


class DistibutorObserver
{
    /**
     * Handle the DistributorStock "created" event.
     */
    public function created(User $user): void
    {
        Mail::to($user->email)->send(new DistributorNotification($user));
    }

    /**
     * Handle the DistributorStock "updated" event.
     */
    public function updated(DistributorStock $distributorStock): void
    {
        //
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

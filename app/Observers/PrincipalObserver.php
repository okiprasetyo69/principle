<?php

namespace App\Observers;

use App\Models\User;
use App\Mail\PrincipalMailNotification;
use Illuminate\Support\Facades\Mail;

class PrincipalObserver
{
    public function created(User $user)
    {
        // Mail::to($user->email)->send(new PrincipalMailNotification($user));
    }

    public function updated(User $user)
    {
        Mail::to($user->email)->send(new PrincipalMailNotification($user));
    }
}

<?php

namespace App\Observers;

use App\Models\User;
use Hydrat\GroguCMS\Events\UserCreated;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        event(new UserCreated($entry));
    }
}

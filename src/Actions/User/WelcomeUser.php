<?php

namespace Hydrat\GroguCMS\Actions\User;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Foundation\Auth\User;

class WelcomeUser
{
    use AsAction;

    public function handle(User $user)
    {
        $expiresAt = now()->addDays(2);
        $user->sendWelcomeNotification($expiresAt);
    }
}

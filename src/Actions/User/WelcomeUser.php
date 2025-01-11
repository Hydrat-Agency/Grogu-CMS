<?php

namespace Hydrat\GroguCMS\Actions\User;

use Illuminate\Foundation\Auth\User;
use Lorisleiva\Actions\Concerns\AsAction;

class WelcomeUser
{
    use AsAction;

    public function handle(User $user)
    {
        $expiresAt = now()->addDays(2);
        $user->sendWelcomeNotification($expiresAt);
    }
}

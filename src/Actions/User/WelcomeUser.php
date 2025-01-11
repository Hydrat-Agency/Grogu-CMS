<?php

namespace Hydrat\GroguCMS\Actions\User;

use Illuminate\Foundation\Auth\User;
use Hydrat\GroguCMS\Events\UserCreated;
use Lorisleiva\Actions\Concerns\AsAction;

class WelcomeUser
{
    use AsAction;

    public function handle(User $user)
    {
        $expiresAt = now()->addDays(2);
        $user->sendWelcomeNotification($expiresAt);
    }

    public function asListener(...$parameters): bool
    {
        $event = $parameters[0];

        if ($event instanceof UserCreated) {
            return $this->handle($event->user);
        }

        $this->handle(...$parameters);
    }
}

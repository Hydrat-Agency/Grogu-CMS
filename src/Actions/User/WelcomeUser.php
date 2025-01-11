<?php

namespace Hydrat\GroguCMS\Actions\User;

use Hydrat\GroguCMS\Events\UserCreated;
use Illuminate\Foundation\Auth\User;
use Lorisleiva\Actions\Concerns\AsAction;

class WelcomeUser
{
    use AsAction;

    public function handle(User $user): void
    {
        $expiresAt = now()->addDays(2);
        $user->sendWelcomeNotification($expiresAt);
    }

    public function asListener(...$parameters)
    {
        $event = $parameters[0];

        if ($event instanceof UserCreated) {
            return $this->handle($event->user);
        }

        $this->handle(...$parameters);
    }
}

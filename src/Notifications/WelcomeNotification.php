<?php

namespace Hydrat\GroguCMS\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Spatie\WelcomeNotification\WelcomeNotification as BaseWelcomeNotification;

class WelcomeNotification extends BaseWelcomeNotification
{
    protected function buildWelcomeNotificationMessage(): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Setup your :appName account', ['appName' => config('app.name')]))
            ->line(Lang::get('You are receiving this email because an account was created for you.'))
            ->action(Lang::get('Set initial password'), $this->showWelcomeFormUrl)
            ->line(Lang::get('This welcome link will expire in :count hours.', ['count' => round(abs($this->validUntil->diffInRealHours()))]));
    }
}

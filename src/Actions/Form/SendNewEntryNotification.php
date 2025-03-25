<?php

namespace Hydrat\GroguCMS\Actions\Form;

use Hydrat\GroguCMS\Models\FormEntry;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class SendNewEntryNotification
{
    use AsAction;

    public function handle(
        FormEntry $entry,
        string $notification = '\Hydrat\GroguCMS\Mail\NewFormEntry',
    ): void {
        $entry->loadMissing('form');

        $form = $entry->form;

        if (filled($emails = explode(',', $form->notify_emails))) {
            foreach ($emails as $email) {
                $email = trim($email);

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($email)->queue(new $notification($entry));
                }
            }
        }
    }
}

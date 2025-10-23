<?php

namespace Hydrat\GroguCMS\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Hydrat\GroguCMS\Models\FormEntry;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Hydrat\GroguCMS\Enums\FormFieldType;
use Illuminate\Mail\Mailables\Attachment;

class NewFormEntry extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public FormEntry $entry,
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('New form entry').' - '.$this->entry->form->name.' '.config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'grogu-cms::mails.new-entry',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        /** @var \Spatie\LaravelData\DataCollection $this->entry->values */
        $attachments = $this->entry->values
            ->toCollection()
            ->where('type', FormFieldType::Attachment)
            ->whereNotNull('value')
            ->pluck('value');

        return $attachments
            ->map(fn ($fileName) => Attachment::fromStorageDisk('local', $fileName))
            ->values()
            ->all();
    }
}

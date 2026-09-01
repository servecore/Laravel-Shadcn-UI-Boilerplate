<?php

namespace App\Mail;

use App\Models\RegistrationInvite;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class RegistrationInviteMail extends Mailable
{
    /**
     * Create a new message instance.
     */
    public function __construct(
        public RegistrationInvite $invite,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Complete your registration',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-invite',
            with: [
                'invite' => $this->invite,
                'url' => route('register.complete', $this->invite->token),
            ],
        );
    }
}

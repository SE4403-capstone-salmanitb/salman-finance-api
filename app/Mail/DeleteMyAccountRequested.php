<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeleteMyAccountRequested extends Mailable
{
    use Queueable, SerializesModels;

    protected $name, $verificationLink;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $verificationLink)
    {
        $this->name = $name;
        $this->verificationLink = $verificationLink;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Delete My Account Requested',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.DeleteMyAccountRequested',
            with: [
                'name' => $this->name,
                'verificationLink' => $this->verificationLink
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

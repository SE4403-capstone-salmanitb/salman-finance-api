<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class newLoginLocation extends Mailable
{
    use Queueable, SerializesModels;

    protected string $geolocation;
    protected string $name;

    /**
     * Create a new message instance.
     */
    public function __construct(string $newLocation, string $name)
    {
        $this->geolocation = $newLocation;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Login Location Detected',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.new-login-location',
            with: [
                'geolocation' => $this->geolocation,
                'name' => $this->name,
                'date' => now()->format('d-m-Y'),
                'time' => now()->format('H:i'),
                'urlChangePassword' => config('app.frontend_url').'/profile'
            ]
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

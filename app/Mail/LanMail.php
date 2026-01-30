<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LanMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $title;
    public $type;
    public $content;
    public $name;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $participant)
    {
        $this->title = $data[0]->title;
        $this->type = $data[0]->type;
        $this->content = $data[0]->content;
        $this->name = $participant->first_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
           view: 'mail.lan',
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

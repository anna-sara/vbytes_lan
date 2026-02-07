<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SmsMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $phone;
    public $name;

    

    /**
     * Create a new message instance.
     */
    public function __construct($participant)
    {

        function formatToSwedenPrefix($phoneNumber) {
            // 1. Remove everything that is NOT a digit
            $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

            info($cleaned);

            // 2. Check existing prefixes and format accordingly
            if (str_starts_with($cleaned, '0046')) {
                // Already correct
                return $cleaned;
            } 
            
            if (str_starts_with($cleaned, '46')) {
                // Starts with 46 (e.g. was +46), add 00
                return '00' . $cleaned;
            } 
            
            if (str_starts_with($cleaned, '0')) {
                // Starts with 0 (local format), remove 0 and add 0046
                return '0046' . substr($cleaned, 1);
            }

            // Fallback: Assume it's a number missing the prefix entirely
            return '0046' . $cleaned;
        }
       
        $this->name = $participant->first_name;
        $this->phone = formatToSwedenPrefix($participant->guardian_phone);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->phone,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
           view: 'mail.sms',
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
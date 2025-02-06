<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestCallEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName;
    public $messageContent;

    /**
     * Create a new message instance.
     */
    public function __construct($clientName, $messageContent)
    {
        $this->clientName = $clientName;
        $this->messageContent = $messageContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'LoanMarket: Client Request Call',
            from: 'ruellobo.04@gmail.com',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.client',
            with: [
                'clientName' => $this->clientName,
                'messageContent' => $this->messageContent,
                'logo' => "asset('assets/images/loanmarket/logos/Loan-Market.svg')"
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

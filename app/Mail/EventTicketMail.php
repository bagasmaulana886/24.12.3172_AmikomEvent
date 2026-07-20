<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The transaction instance.
     *
     * @var mixed
     */
    public $transaction;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $transaction
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'E-Ticket Resmi Anda: ' . ($this->transaction->event->title ?? 'AmikomEventHub');

        return $this->subject($subject)
                    ->view('emails.ticket')
                    ->with(['transaction' => $this->transaction]);
    }
}

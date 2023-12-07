<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSupport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subject;
    private $message;

    public function __construct($subject, $message)
    {
        $this->subject = $subject; 
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = auth()->user()?->first_name . ' ' . auth()->user()?->last_name;
        $subject = $this->subject;
        $message = $this->message;
        $email = auth()->user()?->email;

        return $this->subject($subject)->replyTo($email)->markdown('emails.contact-support', compact('user', 'subject', 'message', 'email'));
    }
}

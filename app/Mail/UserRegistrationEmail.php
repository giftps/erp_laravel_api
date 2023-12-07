<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $confirmation_code;
    private $type;

    public function __construct($confirmation_code, $type)
    {
        $this->confirmation_code = $confirmation_code;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $confirmation_code = $this->confirmation_code;
        $subject = $this->type === 'registration' ? 'User Registration' : 'Password Reset';
        $type = $this->type;

        return $this->subject($subject)->markdown('emails.user-registration', compact('confirmation_code', 'type'));
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LetterOfGuarantee extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $gop_path;
    private $guarantee_type;

    public function __construct($gop_path)
    {
        $this->gop_path = $gop_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Letter of guarantee')->attach($this->gop_path)->view('notifications.letter-of-guarantee');
    }
}

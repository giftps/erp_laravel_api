<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberQuotation extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $member_details;
    private $file_path;
    private $registration_token;
    private $origin_url;
    private $receipient;

    public function __construct($member_details, $file_path, $registration_token, $origin_url, $receipient)
    {
        $this->member_details = $member_details;
        $this->file_path = $file_path;
        $this->registration_token = $registration_token;
        $this->origin_url = $origin_url;
        $this->receipient = $receipient;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = 'SES Quotation';

        if($this->receipient != 'Member'){
            $subject = 'Quotation for - ' . $this->member_details->first_name . ' ' . $this->member_details->family->family_code;
        }

        return (new MailMessage)
        ->subject($subject)
        ->attach($this->file_path)
        ->view('notifications.new-member-quotation', [
            'member_details' => $this->member_details,
            'ui_url' => $this->origin_url,
            'receipient' => $this->receipient,
            'registration_token' => $this->registration_token
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

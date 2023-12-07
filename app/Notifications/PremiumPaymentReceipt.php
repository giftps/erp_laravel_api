<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PremiumPaymentReceipt extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $member_details;
    private $file_path;
    private $amount;
    private $membership_schedule_path;

    public function __construct($member_details, $file_path, $amount, $membership_schedule_path)
    {
        $this->member_details = $member_details;
        $this->file_path = $file_path;
        $this->amount = $amount;
        $this->membership_schedule_path = $membership_schedule_path;
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
        return (new MailMessage)
        ->subject('Premium Payment Processed')
        ->attach($this->file_path)
        ->attach($this->membership_schedule_path)
        ->view('notifications.premium-payment-receipt', [
            'member_details' => $this->member_details,
            'amount' => $this->amount
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

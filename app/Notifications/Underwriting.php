<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Underwriting extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $member;
    public $exclusions;
    public $registration_token;
    public $attatchment_path;
    public $origin_url;

    public function __construct($member, $exclusions, $registration_token, $attatchment_path, $origin_url)
    {
        $this->member = $member;
        $this->exclusions = $exclusions;
        $this->registration_token = $registration_token;
        $this->attatchment_path = $attatchment_path;
        $this->origin_url = $origin_url;
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
        ->subject('Underwriting Letter')
        ->attach($this->attatchment_path)
        ->view('notifications.underwrite', [
            'member' => $this->member,
            'exclusions' => $this->exclusions,
            'link' => $this->origin_url . '/accept-underwriting' . '/' . $this->registration_token
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

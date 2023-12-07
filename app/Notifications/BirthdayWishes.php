<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BirthdayWishes extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $message;
    private $member;
    public function __construct($member)
    {
        $this->member = $member;
        $this->message = 'We hope that the start of this new year in your life brings you much success and happiness! Have a fantastic birthday and wishing all the very best to you from the entire team here!';
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
        // sendAText($this->member->mobile_number, 'Happy birthday! ' . $this->message);

        return (new MailMessage)
            ->subject('Happy Birthday')
            ->view('notifications.birthday-wishes', [
                'member' => $this->member,
                'messages' => $this->message
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

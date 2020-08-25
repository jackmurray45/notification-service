<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class Send extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [$notifiable->notification->type];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        //Assign email, send email, then unset for update
        $notifiable->email = $notifiable->recipient;
        $mailSend = (new MailMessage)->line($notifiable->notification->content);
        unset($notifiable->email);
        
        //Update log to mark sent timestamp and change status
        $notifiable->update([
            'status' => 'sent',
            'sent_on' => Carbon::now()
        ]);

        return $mailSend;
    }
}

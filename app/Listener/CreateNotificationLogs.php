<?php

namespace App\Listener;

use App\Events\NotificationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\NotificationLog;

class CreateNotificationLogs
{

    /**
     * Handle the event.
     *
     * @param  NotificationCreated  $event
     * @return void
     */
    public function handle(NotificationCreated $event)
    {
        $arrayOfRecipients = explode(",",$event->notification->recipients);
        
        foreach($arrayOfRecipients as $recipient)
        {
            $data = [
                'recipient' => $recipient,
                'notification_id' => $event->notification->id
            ];

            NotificationLog::create($data);
        }
    }
}

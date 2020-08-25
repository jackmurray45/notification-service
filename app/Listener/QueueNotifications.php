<?php

namespace App\Listener;

use App\Events\NotificationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Send;

class QueueNotifications
{

    /**
     * Handle the event.
     *
     * @param  NotificationCreated  $event
     * @return void
     */
    public function handle(NotificationCreated $event)
    {
        $notificationLogs = $event->notification->notificationLogs;

        foreach($notificationLogs as $nl)
        {
            $nl->notify(new Send());
        }
        
    }
}

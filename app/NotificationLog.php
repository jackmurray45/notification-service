<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notification;

class NotificationLog extends Model
{

    use Notifiable;

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    protected $fillable = [
        'recipient', 'status', 'sent_on', 'notification_id', 'status'
    ];

    protected $hidden = [

    ];



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sent_on' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\NotificationLog;

class Notification extends Model
{

    use SoftDeletes;

    public function notificationLogs()
    {
        return $this->hasMany(NotificationLog::class);
    }

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'markdown' => 'boolean',
        'expires_on' => 'datetime',
        'send_on' => 'datetime',
        'sent_on' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}

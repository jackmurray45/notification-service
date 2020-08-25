<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\Expires;

class Token extends Authenticatable
{
    use HasRoles;
    use Expires;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'token', 'validated_on', 'expires_on'
    ];

    protected $hidden = [
        'token'
    ];



    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'validated_on' => 'datetime',
        'expires_on' => 'datetime',
    ];

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }
}

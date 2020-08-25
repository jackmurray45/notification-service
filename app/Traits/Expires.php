<?php

namespace App\Traits;

use App\Scopes\ExpiresScope;
use Carbon\Carbon;

trait Expires {

    protected static function bootExpires()
    {
        static::addGlobalScope(new ExpiresScope);
    }

    public function delete()
    {
        return $this->update(['expires_on' => Carbon::now()]);
    }

}
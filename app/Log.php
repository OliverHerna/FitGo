<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function entity()
    {
        return $this->belongsTo('App\Entity');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

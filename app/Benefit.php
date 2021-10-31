<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Paquete;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Benefit extends Model
{
    public function entity()
    {
        return $this->morphOne('App\Entity', 'entitiabble');
    }

    public function paquete()
    {
        return $this->hasMany('App\Paquete');
    }
    public function paquete_user()
    {
        return $this->hasOne('App\PaqueteUser');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{

    public function entity()
    {
        return $this->morphOne('App\Entity', 'entitiabble');
    }

    public function benefit()
    {
        return $this->belongsTo('App\Benefit');
    }
    public function users()
    {
        return $this->belongsToMany('App\User', 'paquete_users');
    }

    public function paquete_user()
    {
        return $this->hasMany('App\PaqueteUser');
    }
}
